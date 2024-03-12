<?php

declare(strict_types=1);

namespace Oila\ZeroAccount;

final class FileEngine implements Engine
{
    public function set(string $key, array $value): void
    {
        file_put_contents($key . '.txt', json_encode($value));
    }

    public function get(string $key): ?array
    {
        $data = file_get_contents($key . '.txt');

        if ($data === false) {
            return null;
        }

        unlink($key . '.txt');

        /** @var ?array<string, mixed> $result */
        $result = json_decode($data, true);

        return $result;
    }
}
