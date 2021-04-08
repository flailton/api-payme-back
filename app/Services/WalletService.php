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
    public function show($id)
    {
        try{
            $response['body'] = $this->walletRepository->show($id);
        } catch (Exception $ex) {
            $response['body']['errors'][] = $ex->getMessage();
            $response['status'] = 404;
        }

        return $response;
    }

    public function debit($id, $value){
        $wallet = $this->walletRepository->show($id);
        $new_value = $this->walletRepository->canDebit($wallet, $value);
        if($new_value !== false){
            $this->walletRepository->update(['value' => $new_value], $wallet->id);

            return true;
        }
        
        throw new Exception('Saldo em carteira insuficiente!');
    }

    public function credit($id, $value){
        $wallet = $this->walletRepository->show($id);
        $new_value = $wallet->value + $value;
        $this->walletRepository->update(['value' => $new_value], $wallet->id);

        return true;
    }
}