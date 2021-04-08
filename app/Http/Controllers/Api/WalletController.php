<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\IWalletService;

class WalletController extends Controller
{
    private IWalletService $walletService;

    public function __construct(IWalletService $walletService) {
        $this->walletService = $walletService;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->walletService->show($id);
        $status = (!empty($response['status'])? $response['status'] : 200);

        return response()->json($response, $status);
    }
}
