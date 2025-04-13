<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Constants\Constants;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        $usersData = $this->userRepository->getAllUsers();
        return ApiResponseClass::sendResponse(true, $usersData->toArray(), Constants::SUCCESS);
    }
}
