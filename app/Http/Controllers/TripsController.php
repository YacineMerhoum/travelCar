<?php

namespace App\Http\Controllers;

use App\Models\Trips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Trips"))
     *     )
     * )
     */
    public function index()
    {
        $trips = Trips::all();
        return response()->json($trips);
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
     *         @OA\JsonContent(ref="#/components/schemas/Trips")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'starting_point' => 'required|string',
            'ending_point' => 'required|string',
            'starting_at' => 'required|date',
            'available_places' => 'required|integer',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $trip = Trips::create($validatedData);
        return response()->json($trip, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/trips/{id}",
     *     summary="Get a trip by ID",
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trip details",
     *         @OA\JsonContent(ref="#/components/schemas/Trips")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trip not found"
     *     )
     * )
     */
    public function show($id)
    {
        $trip = Trips::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        return response()->json($trip);
    }

    /**
     * @OA\Put(
     *     path="/api/trips/{id}",
     *     summary="Update a trip",
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="starting_point", type="string", example="Paris"),
     *             @OA\Property(property="ending_point", type="string", example="London"),
     *             @OA\Property(property="starting_at", type="string", format="date-time", example="2024-07-23T14:30:00Z"),
     *             @OA\Property(property="available_places", type="integer", example=3),
     *             @OA\Property(property="price", type="number", format="float", example=100.00)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trip updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Trips")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trip not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $trip = Trips::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        $validatedData = $request->validate([
            'starting_point' => 'sometimes|string',
            'ending_point' => 'sometimes|string',
            'starting_at' => 'sometimes|date',
            'available_places' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $trip->update($validatedData);
        return response()->json($trip);
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
        $trip = Trips::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        $trip->delete();
        return response()->json(['message' => 'Trip deleted successfully']);
    }
}
