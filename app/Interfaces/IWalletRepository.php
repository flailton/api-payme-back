<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface IWalletRepository extends IRepository
{
    public function show();
}