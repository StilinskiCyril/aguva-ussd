<?php

declare(strict_types=1);

return [
    // The default message displayed to users when no other response is available
    'default_message' => env('USSD_DEFAULT_MESSAGE', 'Aguva USSD'),

    // If set to true, only MSISDNs (phone numbers) in the whitelist are allowed to access the USSD service
    // If false, the USSD service is open to all MSISDNs
    'restrict_to_whitelist' => env('USSD_RESTRICT_TO_WHITELIST', true),

    // If set to true, all incoming USSD request payloads from the provider will be logged for tracking and debugging
    'log_ussd_request' => env('USSD_LOG_REQUEST', true),

    // A comma-separated list of MSISDNs (phone numbers) that are allowed to access the USSD service
    // Only applicable if 'USSD_RESTRICT_TO_WHITELIST' is set to true
    'whitelist_msisdns' => env('USSD_WHITELIST_MSISDNS', '254705799644,254705799641'),

    // The number of seconds to wait before ending a USSD session
    // Some providers require a slight delay before terminating the session
    'end_session_sleep_seconds' => env('USSD_END_SESSION_SLEEP_SECONDS', 2),

    // The USSD code assigned by your service provider (e.g., *999#)
    'ussd_code' => env('USSD_CODE', '999'),

    // The API endpoint that receives USSD request payloads from the provider
    // This should be a valid URL where the USSD server can forward incoming requests
    'online_endpoint' => env('USSD_ONLINE_ENDPOINT', 'api/process-payload/55034fd5-bd23h5d9948f'),
];
