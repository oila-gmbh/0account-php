<?php

declare(strict_types=1);

namespace Oila\ZeroAccount;

use InvalidArgumentException;

final class ZeroAccount
{
    /**
     * @var Engine
     */
    private $engine;

    /**
     * @var string
     */
    private $appSecret;

    public function __construct(string $appSecret, ?Engine $engine = null)
    {
        $this->appSecret = $appSecret;
        $this->engine = $engine ?? new FileEngine();
    }

    /**
     * @param array<string, string> $headers
     * @param array<string, mixed>|string $body
     * throws Exception
     */
    public function auth(array $headers, $body): Result
    {
        if (empty($this->appSecret)) {
            throw new InvalidArgumentException("app secret is not set");
        }

        /** @var ?array<string, mixed> $bodyArr */
        $bodyArr = is_string($body) ? json_decode($body, true) : $body;

        $uuid = getUUIDHeader($headers);
        if (empty($uuid)) throw new InvalidArgumentException("uuid is not provided");
        if (empty($bodyArr)) throw new InvalidArgumentException("body is not provided");

        $authenticating = strtolower(getAuthHeader($headers) ?? "") === "true";
        if (!$authenticating) {
            /** @var array<string, mixed> $meta */
            $meta = $bodyArr['metadata'] ?? [];
            /** @var ?string $appSecret */
            $appSecret = $meta['appSecret'] ?? null;

            if (empty($appSecret) || $appSecret !== $this->appSecret) {
                throw new InvalidArgumentException("incorrect app secret");
            }
            unset($meta['appSecret']);
            $bodyArr['metadata'] = $meta;
            $this->save($uuid, $bodyArr);
            return constructResult($bodyArr, true);
        }

        $newBody = $this->authorize($uuid);
        return constructResult($newBody, false);
    }

    /**
     * @param array<string, mixed> $body
     */
    private function save(?string $uuid, array $body): void
    {
        if (empty($body)) throw new InvalidArgumentException('no data has been provided');
        if (empty($uuid)) throw new InvalidArgumentException('uuid is required');
        $this->engine->set($uuid, $body);
    }

    /**
     * @return array<string, mixed>
     */
    private function authorize(string $uuid): array
    {
        $body = $this->engine->get($uuid);
        if (empty($body)) throw new InvalidArgumentException('could not get data from the engine');
        return $body;
    }
}
