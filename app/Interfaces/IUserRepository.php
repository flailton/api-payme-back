<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface IUserRepository extends IRepository
{
    public function all();

    public function store($attributes);

    public function show($id);

    public function update($attributes, $id);
    
    public function destroy($id);

    public function ableTransference($id);

    public function find($id);

    public function getUser();
}