<?php

namespace App\Http\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserServices{

    public function checkWalletValueOfUserByHisId($user_id){
        return User::where('id', $user_id)->value('wallet');
    }

    public function decrementOfWalletValueOfUserWhenBuySkin($user_id, $skin_price){
        User::where('id', $user_id)->decrement('wallet', $skin_price);
    }

}

?>