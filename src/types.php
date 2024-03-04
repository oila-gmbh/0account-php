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
        $this->isWebhookRequest = $$isWebhookRequest;
    }

    public function userId()
    {
        return $this->userId;
    }

    public function profileId()
    {
        return $this->profileId;
    }

    public function isWebhookRequest()
    {
        return $this->isWebhookRequest;
    }
}

class Result
{
    private $data;
    private $metadata;

    public function __construct($data, Metadata $metadata)
    {
        $this->data = $data;
        $this->metadata = $metadata;
    }

    public function data()
    {
        return $this->data;
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }
}
