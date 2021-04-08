<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ITransferenceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class TransferenceController extends Controller
{
    private ITransferenceService $transferenceService;

    public function __construct(ITransferenceService $transferenceService)
    {
        $this->transferenceService = $transferenceService;
    }

    /**
     * @OA\Post(
     * path="/api/transference",
     * summary="Realizar transferência",
     * description="Realizar transferência entre usuáios",
     * operationId="transaction",
     * tags={"Transferences"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Realizar transferência",
     *    @OA\JsonContent(
     *       required={"payer","payee","value"},
     *       @OA\Property(property="payer", type="int", example="1"),
     *       @OA\Property(property="payee", type="int", example="2"),
     *       @OA\Property(property="value", type="float", example="10.23")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="object", collectionFormat="multi",
     *              @OA\Property(property="value", type="int", example="120.15"),
     *              @OA\Property(property="updated_at", type="string", example="2021-04-08T01:35:47.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-04-08T01:35:47.000000Z"),
     *              @OA\Property(property="id", type="integer", example="2")
     *          )
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="errors", type="array", collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example="O Token está expirado!"
     *              )
     *          )
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="Dados fora do padrão esperado ou não informados",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object", collectionFormat="multi",
     *          @OA\Property(property="value", type="array", collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example="O campo de valor é obrigatório!"
     *              )
     *             )
     *          )
     *        )
     *     ),
     * )
     */
    public function transaction(Request $request)
    {
        try {
            $response['body'] = $this->transferenceService->transaction($request);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            if ($ex instanceof ValidationException) {
                $response['body']['errors'] = $ex->errors();
            }
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }
}
