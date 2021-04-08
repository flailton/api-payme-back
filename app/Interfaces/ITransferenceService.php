<?php


namespace App\Interfaces;

use App\Interfaces\IService;
use Illuminate\Http\Request;

interface ITransferenceService extends IService
{
    public function transaction(Request $request);
}