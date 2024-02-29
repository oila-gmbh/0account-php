<?php

namespace Oila\ZeroAccount;

final class FileEngine implements Engine
{

    public function set(string $key, array $value): void
    {
        file_put_contents($key . '.txt', json_encode($value));
    }

    public function get(string $key): array
    {
        $data = file_get_contents($key . '.txt');
        unlink($key . '.txt');

        return json_decode($data, true);
    }
}
