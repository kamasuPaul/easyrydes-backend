<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ModifyHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //force all requests to be json requests
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);
        //fix cors error
        $response->header( 'Access-Control-Allow-Origin', '*' );
        $response->header( 'Access-Control-Allow-Headers','Content-Type','X-Auth-Token','Origin','Authorization');

        return $response;
    }
}
