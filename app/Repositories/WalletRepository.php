<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Interfaces\IWalletRepository;

class walletRepository implements IWalletRepository
{
    private wallet $wallet;
    
    public function __construct(wallet $wallet) {
        $this->wallet = $wallet;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show()
    {
        return $this->wallet;
    }

}