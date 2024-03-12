<?php declare(strict_types=1);

namespace Oila\ZeroAccount;

if (!function_exists('getAuthHeader')) {
    /**
     * @param array<string, string|array<string, string>> $headers
     */
    function getAuthHeader(array $headers): ?string
    {
        $authHeaders = ["x-0account-auth", "X-0account-Auth", "X-0account-AUTH"];
        return getFromHeader($authHeaders, $headers);
    }
}

if (!function_exists('getUUIDHeader')) {
    /**
     * @param array<string, string|array<string, string>> $headers
     */
    function getUUIDHeader(array $headers): ?string
    {
        $uuidHeaders = ["x-0account-uuid", "X-0account-Uuid", "X-0account-UUID"];
        return getFromHeader($uuidHeaders, $headers);
    }
}

if (!function_exists('getFromHeader')) {
    /**
     * @param array<int, string> $headerNames
     * @param array<string, string|array<string, string>> $headers
     */
    function getFromHeader(array $headerNames, array $headers): ?string
    {
        foreach ($headerNames as $headerName) {
            $header = getFromHeaders($headerName, $headers);
            if ($header) return $header;
        }
        return null;
    }
}

if (!function_exists('getFromHeaders')) {
    /**
     * @param array<string, string|array<string, string>> $headers
     */
    function getFromHeaders(string $headerName, array $headers): ?string
    {
        if (!empty($headers[$headerName] ?? null)) return headerString($headers[$headerName]);

        $lowerCaseHeaderName = strtolower($headerName);

        foreach ($headers as $key => $value) {
            if (strtolower($key) === $lowerCaseHeaderName) {
                if ($value) return headerString($value);
            }
        }
        return null;
    }
}

if (!function_exists('headerString')) {
    /**
     * @param null|string|array<string, string> $header
     */
    function headerString($header): ?string
    {
        if (is_null($header)) {
            return null;
        }

        if (is_array($header)) {
            $headers = array_reverse($header);
            return array_pop($headers);
        }

        return $header;
    }
}

if (!function_exists('constructResult')) {
    /**
     * @param array<string, mixed> $body
     */
    function constructResult(array $body, bool $isWebhookRequest): Result
    {
        /** @var array<string, mixed> $data */
        $data = $body['data'] ?? [];
        /** @var array{profileId: ?string} $meta */
        $meta = $body['metadata'] ?? [];
        // we don't need userId for php library
        $metadata = new Metadata('', $meta['profileId'] ?? '', $isWebhookRequest);
        return new Result($data, $metadata);
    }
}
