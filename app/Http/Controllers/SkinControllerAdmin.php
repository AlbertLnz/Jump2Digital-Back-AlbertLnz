<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Skin;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\SpatieServices;
use App\Models\User;

class SkinControllerAdmin extends Controller
{

    protected $spatieServiceMethods;

    public function __construct()
    {
        $this->spatieServiceMethods = new SpatieServices;
    }

    public function read(){
        $user_role = Auth::user()->getRoleNames();
        $status = $this->spatieServiceMethods->validateUserRoleBeAnAdmin($user_role);

        if($status === 200){
            $skins = Skin::all();
            return response()->json(['skins' => $skins], 200);
        }else if($status === 403){
            return response()->json(['error' => "Unauthorized, you're not an admin"], 403);
        }else{
            return response()->json(['error' => "Unauthorized, you're not logged"], 401);
        }
    }

    public function readOne($id){
        $user_role = Auth::user()->getRoleNames();
        $status = $this->spatieServiceMethods->validateUserRoleBeAClient($user_role);

        if($status === 200){
            $skin = Skin::find($id);
            if($skin){
                return response(['skin' => $skin, 'message' => "Skin found!"], 200);
            }else{
                return response(['message' => "Skin NOT found!"], 404);
            }
        }else{
            return response()->json(['error' => "Unauthorized, you're not logged"], 401);
        }
    }

    public function create(Request $request){
        $user_role = Auth::user()->getRoleNames();
        $status = $this->spatieServiceMethods->validateUserRoleBeAnAdmin($user_role);

        if($status === 200){
            $validator = Validator::make($request->all(), [
                'name' => 'required | min:3',
                'types' => 'required | max:50',
                'price' => 'required | min:2',
                'color' => 'required | max: 20',
                'category' =>'required | max: 20',
                'design_pattern' =>'required | max: 20',
                'rarity' =>'required | max: 20',
            ]);
    
            if($validator->fails()){
                return response(['error' => $validator->errors()], 401);
            }else{
                $types = json_encode($request->input('types'));
                $request['types'] = $types;
                $skin = Skin::create($request->all());
                return response(['skin' => $skin, 'message' => "Skin created!"], 200);
            }
        }else if($status === 403){
            return response()->json(['error' => "Unauthorized, you're not an admin"], 403);
        }else{
            return response()->json(['error' => "Unauthorized, you're not logged"], 401);
        }
    }

    public function update(Request $request, $id){
        if (Auth::guard('api')->check()) {

            $user = User::find(Auth::guard('api')->user()->id);
            // ESTO NO FUNCIONA PORQUE NO HAY MIDDLEWARE!! -> $user_role = Auth::user()->getRoleNames();
            $status = $this->spatieServiceMethods->validateUserRoleBeAnAdmin([$user->role]); // lo he de guardar cómo array, para que la función funcione
    
            if($status === 200){
                $skin = Skin::find($id);
            
                if($skin->id === intval($id)){
                    $validator = Validator::make($request->all(), [
                        'name' => 'min:3',
                        'types' => 'max:50',
                        'price' => 'min:1',
                        'color' => 'max: 20',
                        'category' =>'max: 20',
                        'design_pattern' =>'max: 20',
                        'rarity' =>'max: 20',
                    ]);
                    if($validator->fails()){
                        return response(['error' => $validator->errors()], 401);
                    }else{
                        $skin->update($request->all());
                        return response(['Skin updated' => $skin, 'message' => "Skin updated!"], 200);
                    }
                }else{
                    return response(['error' => "We can't find any skin with this ID!"], 404);
                }
            }else{
                return response()->json(['error' => "Unauthorized, you're not an admin"], 403);
            }   
        }else{
            return response()->json(['error' => "Unauthorized, you're not logged"], 401);
        }
    }

    public function delete($id){
        $skin = Skin::find($id);
            if($skin->id === intval($id)){
                $skin->delete();
                return response(['message' => "Skin deleted!"], 200);
            }else{
                return response(['error' => "We can't find any skin with this ID!"], 404);
            }
    }

}
