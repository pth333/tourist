<?php

namespace App\Http\Middleware;

use App\Models\Tour;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuantityLimitPerson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tour = Tour::find($request->tourId);
        $totalPerson = $request->quantity_adult + $request->quantity_child + $request->quantity_infant;
        $totalParticipants = $tour->participants + $totalPerson;

        if ($totalParticipants > $tour->max_participants) {
            return response()->json([
                'message' => 'Số lượng người vượt quá giới hạn'
            ], 429);
        }
        return $next($request);
    }
}
