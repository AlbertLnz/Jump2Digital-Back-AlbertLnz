<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\SkinServices;
use App\Http\Services\UserServices;
use App\Http\Services\SkinUserServices; 

class SkinController extends Controller
{
    protected $skinServiceMethods;
    protected $userServiceMethods;
    protected $skin_userServiceMethods;

    public function __construct()
    {
        $this->skinServiceMethods = new SkinServices;
        $this->userServiceMethods = new UserServices;
        $this->skin_userServiceMethods = new SkinUserServices;
    }

    public function availableSkins(){
        $all_game_skins = Skin::all()->count();
        $all_available_skins = Skin::where('bought', '=', false)->get();

        return response(['all_game_skins' => $all_game_skins, 'available_skins' => count($all_available_skins), 'all_available_skins' => $all_available_skins], 200);
    }

    public function buySkin($skin_id){
        
        $user = Auth::user();
        $user_wallet = $this->userServiceMethods->checkWalletValueOfUserByHisId($user->id);
        $user_skins_array = $this->skinServiceMethods->findSkinsIdThroughUserIdAndReturnSkinsIdInTheFormOfArray($user->id);
        $skin = $this->skinServiceMethods->findOneSkinByHisId($skin_id);
        
        if ($skin === 'Not found'){
            return response(['message' => "Skin not found!"], 404);

        }elseif (in_array($skin_id, $user_skins_array)){
            return response(['message' => "Skin already obtained by you!", 'skin' => $skin], 401);

        }elseif ($this->skinServiceMethods->checkIfSkinIsAvailableToBuyIt($skin_id)){
            return response(['message' => "Skin already obtained for other user. Try to bought it from himself!", 'skin' => $skin], 403);
        }
        elseif ($user_wallet < $skin->price){
            return response(['message' => "Skin NOT purchased! You don't have enough money in your wallet", 'wallet' => $user_wallet, 'skin_price' => $skin->price], 403);

        }elseif ($user_wallet >= $skin->price){
            $this->userServiceMethods->decrementOfWalletValueOfUserWhenBuySkin($user->id, $skin->price);
            $this->skinServiceMethods->updateSkinStateToBoughtIt($skin->id);
            $this->skin_userServiceMethods->establishRelationUserToSkin($user->id, $skin->id);

            $user_wallet_updated = $this->userServiceMethods->checkWalletValueOfUserByHisId($user->id);
            $skin_updated = $this->skinServiceMethods->findOneSkinByHisId($skin_id);
            return response(['message' => "Skin purchased!", 'wallet updated' => $user_wallet_updated, 'skin' => $skin_updated], 200);

        }else{
            return response(['message' => "Unknown error"], 500);
        }
    }

    public function userSkins(){ 
        $user = Auth::user();
        $relation_user_skins = $this->skin_userServiceMethods->relationUserWithHisAllSkins($user->id);
        return response(['message' => "Skins searched!", 'count_skins' => count($relation_user_skins), 'skins' => $relation_user_skins], 200);
    }

    public function changeSkinColor(Request $request){
        $skin_id = intval($request->skin_id);
        $validator = Validator::make($request->all(), [
            'skin_id' =>'required | integer',
            'color' =>'required | string',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()], 400);
        }

        if(!$this->skinServiceMethods->findOneSkinByHisId($skin_id)){
            return response(['message' => "Skin not found!"], 404);
        }

        if($this->skinServiceMethods->checkIfSkinIsAvailableToBuyIt($skin_id)){
            $user = Auth::user();
            $user_skins_array = $this->skinServiceMethods->findSkinsIdThroughUserIdAndReturnSkinsIdInTheFormOfArray($user->id);

            if(in_array($skin_id, $user_skins_array)){
                $this->skinServiceMethods->updateSkinColor($skin_id, $request->color);
                return response(['message' => "Color successfully changed!", 'skin' => Skin::find($skin_id)], 200);
            }else{
                return response(['message' => "The introduced skin_id is NOT yours, and therefore, you cannot modify it!"], 403);
            }
        }
        else{
            return response(['message' => "Skin not purchased by anyone, buy it to change its color!"], 403);
        }
    }

    public function deleteUserSkin($skin_id){
        $user_id = Auth::user()->id;
        $skin = $this->skinServiceMethods->findOneSkinByHisId($skin_id);
        $skin_user = $this->skin_userServiceMethods->relationUserWithHisOneSkin($user_id, $skin_id);

        if($skin){
            if($skin_user){
                $skin->delete();
                return response(['message' => "Skin deleted correctly!" , "skin" => $skin], 200);
            }else{
                return response(['message' => "You cannot delete a skin that is not yours!"], 403);
            }
        }else{
            return response(['message' => "Skin not found!"], 404);
        }
    }

}
