<?php

namespace Oila\ZeroAccount;

interface Engine
{
    public function set(string $key, array $value): void;

    public function get(string $key): ?array;
}
