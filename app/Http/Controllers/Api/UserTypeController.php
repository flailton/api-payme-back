<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use App\Services\UserTypeService;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    private UserTypeService $userType;

    public function __construct(UserTypeService $userType) {
        $this->userType = $userType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
}
