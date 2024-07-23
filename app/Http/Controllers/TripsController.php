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

    /**
     * @OA\Get(
     *     path="/api/trips/{id}",
     *     tags={"Trips"},
     *     summary="Get a trip by ID",
     *     description="Returns a single trip",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
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
        return $trip;
    }

    /**
     * @OA\Post(
     *     path="/api/trips",
     *     tags={"Trips"},
     *     summary="Create a new trip",
     *     description="Creates a new trip",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="starting_point", type="string"),
     *             @OA\Property(property="ending_point", type="string"),
     *             @OA\Property(property="starting_at", type="string", format="date-time"),
     *             @OA\Property(property="available_places", type="integer"),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="user_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Trip created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'starting_point' => 'required|string|max:255',
            'ending_point' => 'required|string|max:255',
            'starting_at' => 'required|date_format:Y-m-d\TH:i:sP',
            'available_places' => 'required|integer',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $trip = Trips::create($validatedData);

        return response()->json($trip, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/trips/{id}",
     *     tags={"Trips"},
     *     summary="Update a trip",
     *     description="Updates a trip by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="starting_point", type="string", nullable=true),
     *             @OA\Property(property="ending_point", type="string", nullable=true),
     *             @OA\Property(property="starting_at", type="string", format="date-time", nullable=true),
     *             @OA\Property(property="available_places", type="integer", nullable=true),
     *             @OA\Property(property="price", type="number", format="float", nullable=true),
     *             @OA\Property(property="user_id", type="integer", nullable=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trip updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
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
            'starting_point' => 'nullable|string|max:255',
            'ending_point' => 'nullable|string|max:255',
            'starting_at' => 'nullable|date_format:Y-m-d\TH:i:sP',
            'available_places' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $trip->update($validatedData);

        return response()->json($trip);
    }

    /**
     * @OA\Delete(
     *     path="/api/trips/{id}",
     *     tags={"Trips"},
     *     summary="Delete a trip",
     *     description="Deletes a trip by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
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

        return response()->json(null, 204);
    }
}
