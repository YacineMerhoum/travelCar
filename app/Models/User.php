<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'password',
        'role',
        'avatar',
    ];

    /**
     * Get the trips for the user.
     */
    public function trips()
    {
        return $this->hasMany(Trips::class);
    }
}
