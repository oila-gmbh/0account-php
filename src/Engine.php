<?php

declare(strict_types=1);

namespace Oila\ZeroAccount;

interface Engine
{
    /**
     * @param array<string, mixed> $value
     */
    public function set(string $key, array $value): void;

    /**
     * @return array<string, mixed>|null
     */
    public function get(string $key): ?array;
}
