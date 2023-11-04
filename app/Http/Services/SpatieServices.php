<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\DB;

class SpatieServices{

    public function validateUserRoleBeAnAdmin($role){

        if($role[0] === 'admin'){
            return 200;
        }else if($role[0] === 'client'){
            return 403;
        }else{
            return 401;
        }
    }

    public function validateUserRoleBeAClient($role){
        if($role[0] === 'admin' || $role[0] === 'client'){
            return 200;
        }else{
            return 401;
        }
    }

}

?>