<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\IUserService;

/**
 * User Controller.
 */
class UserController extends Controller
{
    private IUserService $userService;

    /**
     * Display a listing of the resource.
     *
     * @param \App\Interfaces\IUserService $userService InterfaceUserService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->userService->all();
        $status = (!empty($response['status'])? $response['status'] : 200);

        return response()->json($response['body'], $status);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request Request recived.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->userService->store($request);
        $status = (!empty($response['status'])? $response['status'] : 200);

        return response()->json($response['body'], $status);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $response = $this->userService->show();
        $status = (!empty($response['status'])? $response['status'] : 200);

        return response()->json($response['body'], $status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = $this->userService->update($request);
        $status = (!empty($response['status'])? $response['status'] : 200);

        return response()->json($response['body'], $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $response = $this->userService->destroy();
        $status = (!empty($response['status'])? $response['status'] : 200);

        return response()->json($response['body'], $status);
    }
}
