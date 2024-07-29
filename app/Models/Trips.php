<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Trips",
 *     type="object",
 *     required={"starting_point", "ending_point", "starting_at", "available_places", "price", "user_id"},
 *     @OA\Property(property="id", type="integer", description="ID of the trip"),
 *     @OA\Property(property="starting_point", type="string", description="Starting point of the trip"),
 *     @OA\Property(property="ending_point", type="string", description="Ending point of the trip"),
 *     @OA\Property(property="starting_at", type="string", format="date-time", description="Starting date and time of the trip"),
 *     @OA\Property(property="available_places", type="integer", description="Number of available places"),
 *     @OA\Property(property="price", type="number", format="float", description="Price of the trip"),
 *     @OA\Property(property="user_id", type="integer", description="ID of the user who created the trip")
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Trips extends Model
{
    use HasFactory;

    protected $fillable = [
        'starting_point',
        'ending_point',
        'starting_at',
        'available_places',
        'price',
        'user_id',
    ];

    /**
     * Get the user that owns the trip.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}