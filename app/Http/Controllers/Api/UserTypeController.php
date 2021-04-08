<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserTypeService;

class UserTypeController extends Controller
{
    private UserTypeService $userTypeService;

    public function __construct(UserTypeService $userTypeService)
    {
        $this->userTypeService = $userTypeService;
    }

    /**
     * @OA\Get(
     * path="/api/user_types",
     * summary="Consultar tipos de usuário",
     * description="Consultar todos os tipos de usuário",
     * operationId="index",
     * tags={"UserTypes"},
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="array", collectionFormat="multi",
     *          @OA\Items(type="object",
     *                  @OA\Property(property="id", type="int", example="1"),
     *                  @OA\Property(property="name", type="string", example="Usuário")
     *           )
     *          )
     *        )
     *     )
     * )
     */
    public function index()
    {
        try {
            $response['body'] = $this->userTypeService->all();
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }
}
