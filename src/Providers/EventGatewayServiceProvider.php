<?php

namespace SpringboardVR\EventGatewayService\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Route;
use SpringboardVr\Jobs\BroadcastEvent;
use SpringboardVr\Services\User\Entities\User;

class EventGatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/event-gateway.php', 'event-gateway');

        Route::post(config('event-gateway.client.route'), 'SpringboardVR\EventGatewayService\Http\Controllers\EventsController@handle');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/event-gateway.php' => config_path('event-gateway.php'),
        ], 'config');

        // Listen for events inside application and send them to Gateway.
        foreach (config('event-gateway.channels', []) as $channel => $events) {
            Event::listen($events, function ($payload) use ($channel) {
                if (method_exists($payload, 'toEventArray')) {
                    $data = $payload->toEventArray();
                } elseif (method_exists($payload, 'toArray')) {
                    $data = $payload->toArray();
                } elseif (is_array($payload)) {
                    $data = $payload;
                } else {
                    $data = [];
                }

                BroadcastEvent::dispatch($channel, $data)->onQueue(config('event-gateway.queue_name'));
            });
        }
    }
}
