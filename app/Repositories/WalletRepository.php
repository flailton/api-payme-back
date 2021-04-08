<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Interfaces\IWalletRepository;

class WalletRepository implements IWalletRepository
{
    private Wallet $wallet;
    
    public function __construct(wallet $wallet) {
        $this->wallet = $wallet;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  Array  $attributes
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show($id)
    {
        return $this->wallet->find($id);
    }

    public function update($attributes, $id)
    {
        $this->wallet->find($id)->update($attributes);
        
        return $this->wallet;
    }

    public function canDebit($wallet, $value)
    {
        $this->wallet = $wallet;
        return $this->wallet->canDebit($value);
    }

}