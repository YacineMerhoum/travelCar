<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Trips",
 *     description="API Endpoints for Managing Trips"
 * )
 */
class TripsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/trips",
     *     summary="Get all trips",
     *     tags={"Trips"},
     *     @OA\Response(
     *         response=200,
     *         description="List of trips",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Trip"))
     *     )
     * )
     */
    public function index()
    {
        // Implementation here
    }

    /**
     * @OA\Post(
     *     path="/api/trips",
     *     summary="Create a new trip",
     *     tags={"Trips"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"starting_point", "ending_point", "starting_at", "available_places", "price"},
     *             @OA\Property(property="starting_point", type="string", example="Paris"),
     *             @OA\Property(property="ending_point", type="string", example="London"),
     *             @OA\Property(property="starting_at", type="string", format="date-time", example="2024-07-23T14:30:00Z"),
     *             @OA\Property(property="available_places", type="integer", example=3),
     *             @OA\Property(property="price", type="number", format="float", example=100.00),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Trip created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'starting_point' => 'required|string|max:255',
            'ending_point' => 'required|string|max:255',
            'starting_at' => 'required|date',
            'available_places' => 'required|integer',
            'price' => 'required|integer',

        ]);

        $trip = new Trips();
        $trip->starting_point = $request->starting_point;
        $trip->ending_point = $request->ending_point;
        $trip->starting_at = $request->starting_at;
        $trip->available_places = $request->available_places;
        $trip->price = $request->price;
        $trip->user_id = $request->user()->id;
        $trip->save();

        return response()->json($trip, 201);
    }

    public function update(Request $request, $id)
    {
        // Implementation here
    }

    /**
     * @OA\Delete(
     *     path="/api/trips/{id}",
     *     summary="Delete a trip",
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trip deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trip not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Implementation here
    }
}
