<?php declare(strict_types=1);

namespace Oila\ZeroAccount;

if (!function_exists('getAuthHeader')) {
    function getAuthHeader($headers): ?string
    {
        $authHeaders = ["x-0account-auth", "X-0account-Auth", "X-0account-AUTH"];
        return getFromHeader($authHeaders, $headers);
    }
}

if (!function_exists('getUUIDHeader')) {
    function getUUIDHeader($headers): ?string
    {
        $uuidHeaders = ["x-0account-uuid", "X-0account-Uuid", "X-0account-UUID"];
        return getFromHeader($uuidHeaders, $headers);
    }
}

if (!function_exists('getFromHeader')) {
    function getFromHeader($headerNames, $headers): ?string
    {
        foreach ($headerNames as $headerName) {
            $header = getFromHeaders($headerName, $headers);
            if ($header) return $header;
        }
        return null;
    }
}

if (!function_exists('getFromHeaders')) {
    function getFromHeaders($headerName, $headers): ?string
    {
        if (isset($headers[$headerName])) return $headers[$headerName];

        $lowerCaseHeaderName = strtolower($headerName);

        foreach ($headers as $key => $value) {
            if (strtolower($key) === $lowerCaseHeaderName) {
                if ($value) return $value;
            }
        }
        return null;
    }
}

if (!function_exists('constructResult')) {
    function constructResult($body, $isWebhookRequest): Result
    {
        $data = $body['data'];
        $meta = $body['metadata'];
        $metadata = new Metadata($meta['userId'], $meta['profileId'], $isWebhookRequest);
        return new Result($data, $metadata);
    }
}
