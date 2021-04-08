<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TransferencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *php artisan route
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function transaction(User $user)
    {
        return ($user->user_type_id === 1? 
            Response::allow() : 
            Response::deny('Lojistas não podem realizar transferências!'));
    }
}
