<?php

namespace App\Services;

use App\Interfaces\IWalletRepository;
use App\Interfaces\IWalletService;
use Exception;
use Illuminate\Validation\ValidationException;

class WalletService implements IWalletService
{
    private IWalletRepository $walletRepository;

    public function __construct(
        IwalletRepository $walletRepository
    ) {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try{
            if(empty($this->walletRepository->wallet->id)){
                throw new Exception('Usuário informado não existe!');
            }

            $wallet = $this->walletRepository->show();

            $response['body'] = $this->walletRepository->show();
        } catch (Exception $ex) {
            $response['body']['errors'][] = $ex->getMessage();
            $response['status'] = 404;
        }

        return $response;
    }
}