<?php

namespace App\Repositories;

use App\Models\UserType;
use App\Interfaces\IUserTypeRepository;

class UserTypeRepository implements IUserTypeRepository
{
    private UserType $userType;
    
    public function __construct(UserType $userType) {
        $this->userType = $userType;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->userType->all();
    }

}