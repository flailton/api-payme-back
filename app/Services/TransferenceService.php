<?php

namespace App\Services;

use App\Interfaces\ITransferenceRepository;
use App\Interfaces\ITransferenceService;
use App\Interfaces\IUserService;
use App\Jobs\SendNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class TransferenceService implements ITransferenceService
{
    private ITransferenceRepository $transferenceRepository;
    private IUserService $userService;
    private SendNotification $sendNotification;

    public function __construct(
        ITransferenceRepository $transferenceRepository,
        IUserService $userService,
        SendNotification $sendNotification
    ) {
        $this->transferenceRepository = $transferenceRepository;
        $this->userService = $userService;
        $this->sendNotification = $sendNotification;
    }

    /**
     * Transference money between users.
     *
     * @param  Illuminate\Http\Request;  $request
     * @return \Illuminate\Http\Response
     */
    public function transaction(Request $request)
    {
        /**
         * rules()
         * messages()
         * Validar no Controller
         */
        $request->validate(
            $this->transferenceRepository->getTransference()->rules(), 
            $this->transferenceRepository->getTransference()->messages()
        );

        $attributes = $request->all();

        # Obtaining user payer to proceed with transaction.
        if (!$this->userService->ableTransference($attributes['payer'])) {
            throw new Exception('Lojistas não podem realizar transferências!');
        }

        try {
            DB::beginTransaction();

            $response = $this->transferenceRepository->store($attributes);

            $this->userService->debit($attributes['payer'], $attributes['value']);
            $this->userService->credit($attributes['payee'], $attributes['value']);

            $authorization = $this->authorization();
            if (!isset($authorization['message']) || $authorization['message'] !== 'Autorizado') {
                throw new Exception('Esta transferência não foi autorizada!');
            }

            $this->sendNotification->dispatch($this->userService->find($attributes['payee']));
        } catch (\Throwable $th) {
            DB::rollBack();
            $response['errors'] = $th->getMessage();
            $response['status'] = 406;
        } finally {
            DB::commit();
        }

        return $response;
    }
    /**
     * Criar uma nova classe
     */
    private function authorization()
    {
        return ['message' => 'Não autorizado!'];
        return Http::get(Config::get('constants.authorization_check.url'));
    }

    private function allow($action, $object)
    {
        return Gate::inspect($action, $object);
    }
}
