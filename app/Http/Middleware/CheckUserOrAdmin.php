<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserOrAdmin
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
        $userId = $request->route('id');

        if (Auth::user()->id !== (int)$userId && !Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
