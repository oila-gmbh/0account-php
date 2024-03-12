<?php declare(strict_types=1);

namespace Oila\ZeroAccount;

class Metadata
{
    /** @var string $userId */
    private $userId;

    /** @var string $profileId */
    private $profileId;

    /** @var bool $isWebhookRequest */
    private $isWebhookRequest;

    public function __construct(string $userId, string $profileId, bool $isWebhookRequest = false)
    {
        $this->userId = $userId;
        $this->profileId = $profileId;
        $this->isWebhookRequest = $isWebhookRequest;
    }

    /**
     * @deprecated It is not actually deprecated. The method is for internal use only.
     */
    public function userId(): string
    {
        return $this->userId;
    }

    public function profileId(): string
    {
        return $this->profileId;
    }

    public function isWebhookRequest(): bool
    {
        return $this->isWebhookRequest;
    }
}
