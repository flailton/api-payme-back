<?php

namespace App\Http\Controllers;

use App\Interfaces\IWalletService;
use Illuminate\Http\Request;

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
    public function show()
    {
        $response = $this->walletService->show();
        $status = (!empty($response['status'])? $response['status'] : 200);

        return response()->json($response['body'], $status);
    }
}
