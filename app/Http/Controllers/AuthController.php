<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Traits\APIResponse;


class AuthController extends Controller
{
    use APIResponse;
    
    public function login(){
       return $this->ok('Login successful');
    }
}
