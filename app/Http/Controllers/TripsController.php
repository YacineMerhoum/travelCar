<?php

namespace App\Http\Controllers;

use App\Models\Trips;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/trips",
     *     tags={"Trips"},
     *     summary="Get list of trips",
     *     description="Returns a list of trips",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Trip"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        return Trips::all();
    }

    // Ajoute d'autres méthodes et annotations si nécessaire
}
