<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\APIResponse;

class ApiController extends Controller
{
    use ApiResponse;
    public function include(string $relation) : bool{
        
        $param = request()->get('include');
        if(!$param){
            return false;
        }
        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relation), $includeValues);
       
    }
}
