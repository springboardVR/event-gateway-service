<?php

return [
    // Gateway event endpoint, by default https://PROJECT_ID.cloudfunctions.net/event.
    'api' => env('EVENTGATEWAY_API'),
    
    // Algorithm used for signatures (HMAC). Must be equal to algorithm used on gateway.
    'algorithm' => 'sha256',

    /*
    |--------------------------------------------------------------------------
    | Client credentials.
    |--------------------------------------------------------------------------
    |
    | Client account is used to listen for events happening on Gateway.
    |
    | By default events are sent by POST to /events endpoint.
    |
     */
    'client' => [
        'secret' => env('EVENTGATEWAY_CLIENT_SECRET'),
        'route' => env('EVENTGATEWAY_CLIENT_ROUTE', 'events'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Service credentials.
    |--------------------------------------------------------------------------
    |
    | Service credentials are used to share events with Gateway.
    |
     */
    'service' => [
        'name' => env('EVENTGATEWAY_SERVICE_NAME'),
        'secret' => env('EVENTGATEWAY_SERVICE_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue name.
    |--------------------------------------------------------------------------
    |
    | Events service using queue. Here you can setup queue name.
    |
     */
    'queue_name' => env('EVENTGATEWAY_QUEUE_NAME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Events shared with gateway.
    |--------------------------------------------------------------------------
    |
    | List of events to share with gateway, for example:
    | 'user.saved' => [
    |     'eloquent.saved: App/User',
    | ]
    |
     */
    'channels' => [],
];
