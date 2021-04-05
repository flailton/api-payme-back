<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface IUserTypeRepository extends IRepository
{
    public function all();
}