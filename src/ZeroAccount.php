<?php

namespace Oila\ZeroAccount;

use InvalidArgumentException;

final class ZeroAccount
{
    /**
     * @var ?Engine
     */
    private $engine;

    /**
     * @var string
     */
    private $appSecret;

    /**
     * @param String $appSecret
     * @param ?Engine $engine
     */
    public function __construct(string $appSecret, ?Engine $engine = null)
    {
        $this->appSecret = $appSecret;
        $this->engine = $engine ?? new FileEngine();
    }

    /**
     * @return Result
     * throws Exception
     */
    public function auth(): Result
    {
        if (empty($this->appSecret)) {
            throw new InvalidArgumentException("app secret is not set");
        }

        if (!isset($this->engine)) {
            throw new InvalidArgumentException("engine is not set and/or the library is not initialised");
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $body = $body ?: $_POST;
        $headers = getallheaders();

        $uuid = getUUIDHeader($headers);
        if (!isset($uuid)) throw new InvalidArgumentException("uuid is not provided");

        $authenticating = strtolower(getAuthHeader($headers) ?? "") === "true";
        if ($authenticating) {
            $meta = $body['metadata'];

            if (empty($meta['appSecret']) || $meta['appSecret'] !== $this->appSecret) {
                throw new InvalidArgumentException("incorrect app secret");
            }
            unset($body['metadata']['appSecret']);
            $this->save($uuid, $body);
            return constructResult($body, true);
        }

        $newBody = $this->authorize($uuid);
        return constructResult($newBody, false);
    }

    private function save($uuid, $body)
    {
        if (!isset($body)) throw new InvalidArgumentException('no data has been provided');
        if (!isset($uuid)) throw new InvalidArgumentException('uuid is required');
        $this->engine->set($uuid, $body);
    }

    private function authorize($uuid): array
    {
        $body = $this->engine->get($uuid);
        if (empty($body)) throw new InvalidArgumentException('could not get data from the engine');
        return $body;
    }
}
