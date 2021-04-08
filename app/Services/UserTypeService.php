<?php

namespace App\Services;

use App\Interfaces\IUserTypeRepository;
use App\Interfaces\IUserTypeService;
use Exception;
use Illuminate\Validation\ValidationException;

class UserTypeService implements IUserTypeService
{
    private IUserTypeRepository $userTypeRepository;

    public function __construct(
        IUserTypeRepository $userTypeRepository
    ) {
        $this->userTypeRepository = $userTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return $this->userTypeRepository->all();
    }
}