<?php


namespace App\Interfaces;

use App\Interfaces\IService;
use Illuminate\Http\Request;

interface IUserService extends IService
{
    public function all();

    public function store(Request $request);

    public function show($id);

    public function update(Request $request, $id);
    
    public function destroy($id);

    public function find($id);

    public function ableTransference($id);

    public function debit($id, $value);

    public function credit($id, $value);
}