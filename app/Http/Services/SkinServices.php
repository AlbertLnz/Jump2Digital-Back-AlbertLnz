<?php

namespace App\Http\Services;
use App\Models\Skin;
use Illuminate\Support\Facades\DB;

class SkinServices{

    public function findOneSkinByHisId($skin_id){
        $skin = Skin::find($skin_id);
        return $skin === null ? "Not found" : $skin;
    }

    public function findSkinsIdThroughUserIdAndReturnSkinsIdInTheFormOfArray($user_id){
        return DB::table('skin_user')->where('user_id', $user_id)->pluck('skin_id')->toArray();
    }

    public function updateSkinStateToBoughtIt($skin_id){
        Skin::where('id', $skin_id)->update(['bought' => true]);        
    }

    public function checkIfSkinIsAvailableToBuyIt($skin_id){
        return Skin::where('id', $skin_id)->value('bought');
    }

    public function updateSkinColor($skin_id, $color){
        Skin::where('id', $skin_id)->update(['color' => $color]); 
    }

}

?>