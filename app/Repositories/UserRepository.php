<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\User
     */
    public function store($attributes)
    {
        return $this->user->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\User
     */
    public function show()
    {
        return $this->user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\User
     */
    public function update($attributes)
    {
        $this->user->update($attributes);
        
        return $this->user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = $this->user;
        $this->user->delete();

        return $user;
    }
}