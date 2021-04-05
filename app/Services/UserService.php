<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserService implements IUserService
{
    private IUserRepository $userRepository;

    public function __construct(
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        try{
            $users = $this->userRepository->all();

            foreach($users as $key => $user){
                $users[$key]['user_type'] = $user->user_type;
                if(strlen($user->document) === 11){
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

            $response['body'] = $users;
        } catch (Exception $ex) {
            $response['body']['errors'][] = $ex->getMessage();
            $response['status'] = 404;
        }
        
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate($this->userRepository->user->rules(), $this->userRepository->user->feedback());

            $attributes = $request->all();

            $attributes['password'] = Hash::make($attributes['password']);

            $response['body'] = $this->userRepository->store($attributes);
        } catch (Exception | ValidationException $ex) {
            if($ex instanceof ValidationException){
                foreach($ex->errors() as $errors){
                    foreach($errors as $error){
                        $errors_response[] = $error;
                    }
                }
            } else {
                $errors_response[] = $ex->getMessage();
            }
            $response['body']['errors'] = $errors_response;
            $response['status'] = 404;
        }
        
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try{
            if(empty($this->userRepository->user->id)){
                throw new Exception('Usuário informado não existe!');
            }

            $user = $this->userRepository->show();

            $user['user_type'] = $user->user_type;
            if(strlen($user->document) === 11){
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

            $response['body'] = $this->userRepository->show();
        } catch (Exception $ex) {
            $response['body']['errors'][] = $ex->getMessage();
            $response['status'] = 404;
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            if(empty($this->userRepository->user->id)){
                throw new Exception('Usuário informado não existe!');
            }

            $request->validate($this->userRepository->user->rules(), $this->userRepository->user->feedback());

            $attributes = $request->all();

            if(!empty($attributes['password'])){
                $attributes['password'] = Hash::make($attributes['password']);
            }

            $response['body'] = $this->userRepository->update($attributes);
        } catch (Exception | ValidationException $ex) {
            if($ex instanceof ValidationException){
                foreach($ex->errors() as $errors){
                    foreach($errors as $error){
                        $errors_response[] = $error;
                    }
                }
            } else {
                $errors_response[] = $ex->getMessage();
            }
            $response['body']['errors'] = $errors_response;
            $response['status'] = 404;
        }
        
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try{
            if(empty($this->userRepository->user->id)){
                throw new Exception('Usuário informado não existe!');
            }

            $response['body'] = $this->userRepository->destroy();
        } catch (Exception | ValidationException $ex) {
            if($ex instanceof ValidationException){
                foreach($ex->errors() as $errors){
                    foreach($errors as $error){
                        $errors_response[] = $error;
                    }
                }
            } else {
                $errors_response[] = $ex->getMessage();
            }
            $response['body']['errors'] = $errors_response;
            $response['status'] = 404;
        }
        return $response;
    }
}