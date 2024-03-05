<?php declare(strict_types=1);

namespace Oila\ZeroAccount;

class Metadata
{
    private $userId;
    private $profileId;
    private $isWebhookRequest;

    public function __construct($userId, $profileId, $isWebhookRequest = false)
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
