<?php

namespace App\Http\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SkinUserServices{

    public function establishRelationUserToSkin($user_id, $skin_id){
        DB::table('skin_user')->insert([
            "user_id" => intval($user_id),
            'skin_id' => intval($skin_id),
        ]);
    }

    public function relationUserWithHisAllSkins($user_id){
        return DB::table('skin_user')->where('user_id', $user_id)->get();
    }

    public function relationUserWithHisOneSkin($user_id, $skin_id){
        DB::table('skin_user')->where('user_id', $user_id)->where('skin_id', $skin_id)->first();
    }

}

?>