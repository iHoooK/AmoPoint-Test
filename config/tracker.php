<?php

return [
    'site_key' => env('TRACKER_SITE_KEY', 'amopoint-demo-key'),

    'allowed_domains' => array_values(array_filter(array_map(
        static fn (string $domain): string => trim(strtolower($domain)),
        explode(',', (string) env('TRACKER_ALLOWED_DOMAINS', 'localhost,127.0.0.1,::1'))
    ))),

    'allow_local_file' => env('TRACKER_ALLOW_LOCAL_FILE', true),

    'consent_cookie' => env('TRACKER_CONSENT_COOKIE', 'amopoint_tracking_consent'),

    'geo_api_url' => env('TRACKER_GEO_API_URL', 'https://ipwho.is'),
];
