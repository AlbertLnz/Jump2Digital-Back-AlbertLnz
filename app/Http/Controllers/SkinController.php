<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SkinController extends Controller
{
    public function availableSkins(){

        $all_game_skins = Skin::all()->count();
        $all_available_skins = Skin::where('bought', '=', false)->get();

        return response(['all_game_skins' => $all_game_skins, 'available_skins' => count($all_available_skins), 'all_available_skins' => $all_available_skins], 200);
    }

    public function buySkin($skin_id){
        
        $user = Auth::user();
        $user_skins = DB::table('skin_user')->where('user_id', $user->id)->pluck('skin_id')->toArray();;
        $skin = Skin::find($skin_id);

        if($skin===null){
            return response(['message' => "Skin not found!"], 404);
        }

        if(in_array($skin_id, $user_skins)){
            return response(['message' => "Skin already obteined!", 'skin' => $skin], 401);
        }
        
        if($user->wallet >= $skin->price){
            User::where('id', $user->id)->decrement('wallet', $skin->price);
            Skin::where('id', $skin->id)->update(['bought' => true]);
    
            DB::table('skin_user')->insert([
                "user_id" => intval($user->id),
                'skin_id' => intval($skin->id),
            ]);
        }else{
            return response(['message' => "Skin NOT purchase! You don't have enough money in your wallet", 'wallet' => $user->wallet, 'skin_price' => $skin->price], 401);
        }

        $skin = Skin::find($skin_id); // skin updated! (bought = true)
        $user = User::find(Auth::user()->id); // user updated! (wallet = wallet - skin_price)
        return response(['message' => "Skin purchased!", 'wallet updated' => $user->wallet, 'skin' => $skin], 200);
    }

    public function userSkins(){ 
        $user_skins = DB::table('skin_user')->where('user_id', Auth::user()->id)->get();
        return response(['message' => "Skins searched!", 'count_skins' => count($user_skins), 'skins' => $user_skins], 200);
    }

    public function changeSkinColor(Request $request){
        $skin_id = intval($request->skin_id);
        $validator = Validator::make($request->all(), [
            'skin_id' =>'required | integer',
            'color' =>'required | string',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()], 406);
        }

        if(!Skin::find($skin_id)){
            return response(['message' => "Skin not found!"], 404);
        }

        if(DB::table('skin_user')->where('skin_id', $skin_id)->first()){
            $skin_id_db = DB::table('skin_user')->where('skin_id', $skin_id)->first()->skin_id;

            if($skin_id === $skin_id_db){
                Skin::where('id', $skin_id)->update(['color' => $request->color]); 
                return response(['message' => "Color cambiado existosamente!", 'skin' => Skin::find($skin_id)], 200);
            }else{
                return response(['message' => "La skin_id introducida NO es tuya y por lo tanto, no la puedes modificar!"], 403);
            }

        }else{
            return response(['message' => "Skin no comprada por nadie, comprala para cambiarle el color!"], 403);
        }
    }

    public function deleteUserSkin($skin_id){
        $skin = Skin::find($skin_id);
        $user_id = Auth::user()->id;
        $skin_user = DB::table('skin_user')->where('user_id', $user_id)->where('skin_id', $skin_id)->first();

        if($skin){
            if($skin_user){
                $skin->delete();
                return response(['message' => "Skin deleted correctly!" , "skin" => $skin], 200);
            }else{
                return response(['message' => "No puedes eliminar una skin que no es tuya!!"], 403);
            }
        }else{
            return response(['message' => "Skin not found!"], 404);
        }
    }

}
