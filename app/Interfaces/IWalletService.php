<?php


namespace App\Interfaces;

use App\Interfaces\IService;

interface IWalletService extends IService
{
    public function show($id);

    public function debit($wallet, $value);

    public function credit($wallet, $value);
}