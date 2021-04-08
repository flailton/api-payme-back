<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface ITransferenceRepository extends IRepository
{
    public function show($id);

    public function store($attributes);
    
    public function update($attributes, $id);

    public function getTransference();
}