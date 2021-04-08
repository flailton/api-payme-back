<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Interfaces\IUserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
     * @OA\Get(
     * path="/api/users",
     * summary="Consultar usuários",
     * description="Consultar todos os usuários",
     * operationId="index",
     * tags={"Users"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="array", collectionFormat="multi",
     *          @OA\Items(type="object",
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="name", type="string", example="admin"),
     *              @OA\Property(property="email", type="email", example="admin@admin.com"),
     *              @OA\Property(property="document", type="string", example="991.290.566-73"),
     *              @OA\Property(property="user_type_id", type="int", example="1"),
     *              @OA\Property(property="user_type", type="object",
     *                  @OA\Property(property="id", type="int", example="1"),
     *                  @OA\Property(property="name", type="string", example="Usuário"),
     *              ),
     *           )
     *          )
     *        )
     *     )
     * )
     */
    public function index()
    {
        try {
            $response['body'] = $this->userService->all();
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }


        return response()->json($response['body'], $response['status']);
    }

    /**
     * @OA\Post(
     * path="/api/users",
     * summary="Criar usuário",
     * description="Criar usuário na API",
     * operationId="store",
     * tags={"Users"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Criar usuário",
     *    @OA\JsonContent(
     *       required={"name","email","password","document","user_type_id"},
     *       @OA\Property(property="name", type="string", example="admin"),
     *       @OA\Property(property="password", type="string", example="admin@123"),
     *       @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *       @OA\Property(property="document", type="string", example="99129056673"),
     *       @OA\Property(property="user_type_id", type="int", example="1")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="object", collectionFormat="multi",
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="name", type="string", example="admin"),
     *              @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *              @OA\Property(property="document", type="string", example="991.290.566-73"),
     *              @OA\Property(property="user_type_id", type="int", example="1")
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
     *          @OA\Property(property="name", type="array", collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example="O campo nome é obrigatório!"
     *              )
     *             )
     *          )
     *        )
     *     ),
     * )
     */
    public function store(Request $request)
    {
        try {
            $response['body'] = $this->userService->store($request);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            if($ex instanceof ValidationException){
                $response['body']['errors'] = $ex->errors();
            }
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    /**
     * @OA\Get(
     * path="/api/users/{user}",
     * summary="Buscar usuário",
     * description="Buscar usuário na API",
     * operationId="show",
     * tags={"Users"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="object", collectionFormat="multi",
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="name", type="string", example="admin"),
     *              @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *              @OA\Property(property="document", type="string", example="991.290.566-73"),
     *              @OA\Property(property="user_type_id", type="int", example="1"),
     *              @OA\Property(property="user_type", type="object",
     *                  @OA\Property(property="id", type="int", example="1"),
     *                  @OA\Property(property="name", type="string", example="Usuário"),
     *              ),
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
     *    response=404,
     *    description="Dados incorretos",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Usuário informado não existe!"),
     *       )
     *    ),
     * )
     */
    public function show($id)
    {
        try {
            $response['body'] = $this->userService->show($id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    /**
     * @OA\Put(
     * path="/api/users/{user}",
     * summary="Atualizar usuário",
     * description="Atualizar usuário na API",
     * operationId="update",
     * tags={"Users"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Atualizar usuário",
     *    @OA\JsonContent(
     *       required={"name","email","password","document","user_type_id"},
     *       @OA\Property(property="name", type="string", example="admin"),
     *       @OA\Property(property="password", type="string", example="admin@123"),
     *       @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *       @OA\Property(property="document", type="string", example="99129056673"),
     *       @OA\Property(property="user_type_id", type="int", example="1")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="object", collectionFormat="multi",
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="name", type="string", example="admin"),
     *              @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *              @OA\Property(property="document", type="string", example="991.290.566-73"),
     *              @OA\Property(property="user_type_id", type="int", example="1"),
     *              @OA\Property(property="user_type", type="object",
     *                  @OA\Property(property="id", type="int", example="1"),
     *                  @OA\Property(property="name", type="string", example="Usuário"),
     *              ),
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
     *    response=404,
     *    description="Dados incorretos",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Usuário informado não existe!"),
     *       )
     *    ),
     * @OA\Response(
     *    response=422,
     *    description="Dados fora do padrão esperado ou não informados",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object", collectionFormat="multi",
     *          @OA\Property(property="email", type="array", collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example="O campo e-mail está fora do formato esperado!"
     *              )
     *             )
     *          )
     *        )
     *     ),
     * )
     */
    /**
     * @OA\Patch(
     * path="/api/users/{user}",
     * summary="Atualizar usuário",
     * description="Atualizar usuário na API",
     * operationId="update",
     * tags={"Users"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Atualizar usuário",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="admin"),
     *       @OA\Property(property="password", type="string", example="admin@123"),
     *       @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *       @OA\Property(property="document", type="string", example="99129056673"),
     *       @OA\Property(property="user_type_id", type="int", example="1")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="object", collectionFormat="multi",
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="name", type="string", example="admin"),
     *              @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *              @OA\Property(property="document", type="string", example="991.290.566-73"),
     *              @OA\Property(property="user_type_id", type="int", example="1"),
     *              @OA\Property(property="user_type", type="object",
     *                  @OA\Property(property="id", type="int", example="1"),
     *                  @OA\Property(property="name", type="string", example="Usuário"),
     *              ),
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
     *    response=404,
     *    description="Dados incorretos",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Usuário informado não existe!"),
     *       )
     *    ),
     * @OA\Response(
     *    response=422,
     *    description="Dados fora do padrão esperado ou não informados",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object", collectionFormat="multi",
     *          @OA\Property(property="email", type="array", collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example="O campo e-mail está fora do formato esperado!"
     *              )
     *             )
     *          )
     *        )
     *     ),
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $response['body'] = $this->userService->update($request, $id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            if($ex instanceof ValidationException){
                $response['body']['errors'] = $ex->errors();
            }
            $response['status'] = 404;
        }


        return response()->json($response['body'], $response['status']);
    }

    /**
     * @OA\Delete(
     * path="/api/users/{user}",
     * summary="Remover usuário",
     * description="Remover usuário na API",
     * operationId="destroy",
     * tags={"Users"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(type="object", collectionFormat="multi",
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="name", type="string", example="admin"),
     *              @OA\Property(property="email", type="email", format="email", example="admin@admin.com"),
     *              @OA\Property(property="document", type="string", example="991.290.566-73"),
     *              @OA\Property(property="user_type_id", type="int", example="1")
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
     *    response=404,
     *    description="Dados incorretos",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Usuário informado não existe!"),
     *       )
     *    ),
     * )
     */
    public function destroy($id)
    {
        try {
            $response['body'] = $this->userService->destroy($id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }
}
