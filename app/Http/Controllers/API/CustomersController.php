<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function getCustomersCount()
    {
        Log::critical(__CLASS__ . '::' . __FUNCTION__ . ' entered');
        Log::error(__CLASS__ . '::' . __FUNCTION__ . ' entered');
        Log::warning(__CLASS__ . '::' . __FUNCTION__ . ' entered');
        Log::notice(__CLASS__ . '::' . __FUNCTION__ . ' entered');
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' entered');
        Log::debug(__CLASS__ . '::' . __FUNCTION__ . ' entered');

        return response()->json(['number_of_customers' => Customer::count()], 200);
    }
}
