<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use App\Interfaces\IWalletService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserService implements IUserService
{
    private IUserRepository $userRepository;
    private IWalletService $walletService;

    public function __construct(
        IUserRepository $userRepository,
        IWalletService $walletService
    ) {
        $this->userRepository = $userRepository;
        $this->walletService = $walletService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = $this->userRepository->all();

        foreach ($users as $key => $user) {
            $users[$key]['user_type'] = $user->user_type;
            if (strlen($user->document) === 11) {
                $users[$key]['document'] = substr($user->document, 0, 3) . '.' .
                    substr($user->document, 3, 3) . '.' .
                    substr($user->document, 6, 3) . '-' .
                    substr($user->document, 9);
            } else {
                $users[$key]['document'] = substr($user->document, 0, 2) . '.' .
                    substr($user->document, 2, 3) . '.' .
                    substr($user->document, 5, 3) . '/' .
                    substr($user->document, 8, 4) . '-' .
                    substr($user->document, 12, 2);
            }
        }

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $attributes
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->userRepository->getUser()->rules(), $this->userRepository->getUser()->messages());

        $attributes['password'] = Hash::make($request->get('password'));
        $response = $this->userRepository->store($request->all());

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty($user = $this->userRepository->show($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        $user['user_type'] = $user->user_type;
        if (strlen($user->document) === 11) {
            $user['document'] = substr($user->document, 0, 3) . '.' .
                substr($user->document, 3, 3) . '.' .
                substr($user->document, 6, 3) . '-' .
                substr($user->document, 9);
        } else {
            $user['document'] = substr($user->document, 0, 2) . '.' .
                substr($user->document, 2, 3) . '.' .
                substr($user->document, 5, 3) . '/' .
                substr($user->document, 8, 4) . '-' .
                substr($user->document, 12, 2);
        }

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [];
        if ($request->method() === 'PATCH') {
            foreach ($this->userRepository->getUser()->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $regra;
                }
            }
        } else {
            $rules = $request->rules();
        }

        $request->validate($rules, $this->userRepository->getUser()->messages());

        if (empty($this->userRepository->find($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        if (!empty($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        $user = $this->userRepository->update($request->all(), $id);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($this->userRepository->find($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        return $this->userRepository->destroy($id);
    }

    public function find($id)
    {
        if (empty($user = $this->userRepository->find($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        return $user;
    }

    public function ableTransference($id)
    {
        if (empty($this->userRepository->find($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        return $this->userRepository->ableTransference($id);
    }

    public function debit($id, $value)
    {
        if (empty($user = $this->userRepository->find($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        return $this->walletService->debit($user->wallets[0]->id, $value);
    }

    public function credit($id, $value)
    {
        if (empty($user = $this->userRepository->find($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        return $this->walletService->credit($user->wallets[0]->id, $value);
    }
}
