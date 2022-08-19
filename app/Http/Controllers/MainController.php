<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    /**
     * @return mixed
     */
    public function home()
    {
        return Auth::user()->userHomeAction;
    }
}
