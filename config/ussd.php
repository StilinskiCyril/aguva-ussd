<?php
return [
    'default_message' => env('DEFAULT_MESSAGE', 'Aguva USSD'), // The default message to show when no other message is available
    'restrict_to_whitelist' => env('RESTRICT_TO_WHITELIST', true), // Set to false to allow all msisdns
    'log_ussd_request' => env('LOG_USSD_REQUEST', '#############'), // Set to true to log all ussd request payloads from provider
    'whitelist_msisdns' => env('WHITELIST_MSISDNS', '#############'), // Comma separated list of msisdns to whitelist
    'end_session_sleep_seconds' => env('END_SESSION_SLEEP_SECONDS', '#############'), // Delay in seconds before ending session
    'ussd_code' => env('USSD_CODE', '999'), // This is the ussd code given to you by your provider eg 999
    'online_endpoint' => env('ONLINE_ENDPOINT', 'api/process-payload/55034fd5-bd23h5d9948f') // The endpoint to receive ussd payloads from provider
];