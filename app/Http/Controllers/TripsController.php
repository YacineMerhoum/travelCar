<?php

namespace App\Http\Controllers;

use App\Models\Trips;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    public function index()
    {
        $trips = Trips::all();
        return response()->json($trips);
    }

    public function show($id)
    {
        $trip = Trips::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }
        return response()->json($trip);
    }

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
        $trip = Trips::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        $trip->update($request->all());

        return response()->json($trip);
    }

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
