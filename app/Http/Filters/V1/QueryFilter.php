<?php 

namespace App\Http\Filters\V1;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


abstract Class QueryFilter {
    protected $request;
    protected $builder;
    protected $sortAttributes = [];
    public function __construct(Request $request){
        $this->request = $request;
    }

    protected function filter($arr){

        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $this->builder;
    }
    public function apply (Builder $builder)
    {
        $this->builder = $builder;


        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $builder;
    }

    public function sort($value){
        $sortAttributes = explode(',', $value);

        foreach($sortAttributes as $sortAttribute){
            $direction = 'asc';
            if($sortAttribute[0] == '-'){
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            if(!in_array($sortAttribute, $this->sortAttributes)){
                continue;
            }
            $this->builder->orderBy($sortAttribute, $direction);

        }

    }


}