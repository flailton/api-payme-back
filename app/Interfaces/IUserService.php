<?php


namespace App\Interfaces;

use App\Interfaces\IService;
use Illuminate\Http\Client\Request;

interface IUserService extends IService
{
    public function all();

    public function store(Request $request);

    public function show();

    public function update(Request $request);
    
    public function destroy();
}