<?php

namespace Oila\ZeroAccount;

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
