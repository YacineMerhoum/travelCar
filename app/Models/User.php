<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     required={"id", "lastname", "firstname", "email", "password", "role"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="lastname",
 *         type="string",
 *         example="Doe"
 *     ),
 *     @OA\Property(
 *         property="firstname",
 *         type="string",
 *         example="John"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         example="john.doe@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         example="password123"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         example="admin"
 *     ),
 *     @OA\Property(
 *         property="avatar",
 *         type="string",
 *         example="http://example.com/avatar.jpg"
 *     )
 * )
 */
class User extends Authenticatable implements HasName
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'password',
        'role',
        'avatar',
    ];
    // Les attributs qui devraient être cachés pour les tableaux.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Les attributs qui devraient être castés en types natifs.
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the trips for the user.
     */
    public function trips()
    {
        return $this->hasMany(Trips::class);
    }


    /**
     * Vérifie si l'utilisateur a un rôle spécifique.
     *
     * @param  string  $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function getFilamentName(): string
    {
        return $this->getAttributeValue('lastname');
    }
}
