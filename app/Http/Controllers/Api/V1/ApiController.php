<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function include(string $relation) : bool{
        
        $param = request()->get('include');
        if(!$param){
            return false;
        }
        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relation), $includeValues);
       
    }
}
