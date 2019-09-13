# Readme

# Event Gateway service for Laravel

This package is built to share events between micro services though Event Gateway. It's separated under client and service part.

## Installation

Install using composer:

`composer require springboardvr/event-gateway-service`

Publish config:

`php artisan vendor:publish --provider="SpringboardVR\EventGatewayService\Providers\EventGatewayServiceProvider" --tag="config"`

# Client

Client is responsible for receiving events from Event Gateway and dispatching them internally.

## Setup

1. Create you client account on Event Gateway and set your client secret and client url (by default `https://HOST/events`).
2. Set your client secret in `config/event-gateway.php` or `EVENTGATEWAY_CLIENT_SECRET` env variable.

## Usage

Set channels you would like to listen to in Event Gateway subscribers section. Events are always starting with service for example `billing_service.invoice.created`.

Example:

    Event::listen('billing_service.invoice.created', function ($invoice) {
        PaymentService::payInvoice($invoice);
    });

# Service

Service is responsible for sharing selected events with event Gateway and other micro services.

## Setup

1. Create a new service at Event Gateway and set service name with service secret.
2. Setup you Event Gateway, service name, and secret in `config/event-gateway.php`.
3. Setup events you would like to share with Event Gateway using `event-gateway.channels` config.

## Usage

Events matching `event-gateway.channels` pattern (currently no wildcard support), are going to be shared with other micro services subscribed to namespace used in channels configuration. Event Gateway will automatically add service prefix to every event dispatched.
For example if you are using service name `billing` and setup channel

    'invoice.saved' => [
        'eloquent.saved: App/Models/Invoice',
     ]

every save event of invoice model going to be dispatched as `billing.invoice.saved`.
