<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json(['status'=>true,'data' => auth()->user()],200);
    }
}
