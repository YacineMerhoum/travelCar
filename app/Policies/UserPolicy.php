<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, UserModel $model)
    {
        return $user->role === 'admin' || $user->id === $model->id;
    }

    public function update(User $user, UserModel $model)
    {
        return $user->role === 'admin' || $user->id === $model->id;
    }

    public function delete(User $user, UserModel $model)
    {
        return $user->role === 'admin';
    }
}
