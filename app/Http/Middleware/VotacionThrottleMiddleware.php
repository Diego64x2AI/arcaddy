<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;

class VotacionThrottleMiddleware extends ThrottleRequests
{
	protected function resolveRequestSignature($request)
	{
		return sha1($request->ip().'|'.$request->input('id'));
	}
}
