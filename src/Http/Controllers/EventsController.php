<?php

namespace SpringboardVR\EventGatewayService\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SpringboardVR\EventGatewayService\Http\Requests\EventRequest;

class EventsController extends Controller
{
	/**
	 * Handle event from event gateway.
	 *
	 * @param EventRequest $request
	 * @return void
	 */
    public function handle(EventRequest $request)
    {
    	event($request->input('channel.name'), $request->input('data'));
    }
}
