<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface IWalletRepository extends IRepository
{
    public function show($id);
    
    public function update($attributes, $id);
    
    public function canDebit($wallet, $value);

}