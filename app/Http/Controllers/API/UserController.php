<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function getUserList()
    {
        $data = User::all();
        return response()->json($data, 200);
    }
}
