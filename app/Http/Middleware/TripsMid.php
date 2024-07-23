<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TripsMid
{
    public function handle(Request $request, Closure $next): Response
    {
        // Assurez-vous que l'utilisateur est authentifié
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        // Vérifiez si l'utilisateur est autorisé à effectuer des opérations sur les trips
        if ($request->user()->role === 'admin' || $request->user()->role === 'trip_manager') {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized. Access to trips is restricted.'], 403);
    }
}
