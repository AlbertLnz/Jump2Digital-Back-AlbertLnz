<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkinController extends Controller
{
    public function availableSkins(){

        $all_game_skins = Skin::all()->count();
        $all_available_skins = Skin::where('stock', '>', 0)->get();

        return response(['all_game_skins' => $all_game_skins, 'available_skins' => count($all_available_skins), 'all_available_skins' => $all_available_skins], 200);
    }

    public function buySkin($skin_id){
        
        $user = Auth::user();
        $user_skins = DB::table('skin_user')->where('user_id', $user->id)->pluck('skin_id')->toArray();;
        $skin = Skin::find($skin_id);

        if(in_array($skin_id, $user_skins)){
            return response(['message' => "Skin already obteined!", 'skin' => $skin], 401);
        }
        
        if($user->wallet >= $skin->price){
            User::where('id', $user->id)->decrement('wallet', $skin->price);
            Skin::where('id', $skin->id)->decrement('stock', 1);
    
            DB::table('skin_user')->insert([
                "user_id" => intval($user->id),
                'skin_id' => intval($skin->id),
            ]);
        }else{
            return response(['message' => "Skin NOT purchase! You don't have enough money in your wallet", 'wallet' => $user->wallet, 'skin_price' => $skin->price], 401);
        }

        $skin = Skin::find($skin_id); // skin updated! (stock - 1)
        $user = User::find(Auth::user()->id); // user updated! (wallet - skin_price)
        return response(['message' => "Skin purchased!", 'wallet updated' => $user->wallet, 'skin' => $skin], 200);
    }


}
