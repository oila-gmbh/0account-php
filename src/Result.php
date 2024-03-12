<?php

declare(strict_types=1);

namespace Oila\ZeroAccount;

class Result
{
    /** @var array<string, mixed> $data */
    private $data;

    /** @var Metadata $metadata */
    private $metadata;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data, Metadata $metadata)
    {
        $this->data = $data;
        $this->metadata = $metadata;
    }

    /**
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return $this->data;
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }
}
