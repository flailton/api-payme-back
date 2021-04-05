<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface IUserRepository extends IRepository
{
    public function all();

    public function store($attributes);

    public function show();

    public function update($attributes);
    
    public function destroy();
}