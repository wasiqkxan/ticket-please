<?php

namespace App\Http\Filters\V1;

use Illuminate\Http\Request;

class AuthorFilter extends QueryFilter {
    protected $sortAttributes = ['status', 'title','name','id', 'created_at', 'updated_at'];
    // Define your filter methods here
    public function id($value) {
        $str = explode(',', $value);
       return $this->builder->whereIn('id', $str);
    }

    public function include($value) {
        return $this->builder->with($value);
    }

    public function title($value){
        $str_title = str_replace('*', '%', $value);
        return $this->builder->where('title', 'like', $str_title);
    }

    public function name($value){
        $str_title = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $str_title);
    }

    public function created_at($value){
        $str_date = explode(',', $value);
        if(count($str_date)){
            return $this->builder->wherebetween('created_at', $str_date);
        }

        return $this->builder->whereDate('created_at', $value);
    }
    public function updated_at($value){
        $str_date = explode(',', $value);
        if(count($str_date)){
            return $this->builder->wherebetween('updated_at', $str_date);
        }

        return $this->builder->whereDate('updated_at', $value);
    }
}
?>
