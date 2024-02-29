<?php

namespace Oila\ZeroAccount;

interface Engine
{
    public function set(string $key, array $value);

    public function get(string $key): array;
}
