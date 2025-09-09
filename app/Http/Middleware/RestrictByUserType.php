<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictByUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$types
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$types): Response
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado.');
        }

        if (!in_array($request->user()->vc_tipo, $types)) {
            return redirect()->route('unauthorized')->with('error', 'Acesso não autorizado.');
        }

        return $next($request);
    }
}