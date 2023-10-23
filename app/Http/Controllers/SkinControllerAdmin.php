<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Skin;

class SkinControllerAdmin extends Controller
{
    public function read(){
        return Skin::all();
    }

    public function readOne($id){
        $skin = Skin::find($id);
        if($skin){
            return response(['skin' => $skin, 'message' => "Skin found!"], 200);
        }
        return response(['message' => "Skin NOT found!"], 404);
    }

    public function create(Request $request){

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
    }

    public function update(Request $request, $id){
        $skin = Skin::find($id);
        
        if($skin->id === intval($id)){
            $validator = Validator::make($request->all(), [
                'name' => 'min:3',
                'types' => 'max:50',
                'price' => 'min:2',
                'color' => 'max: 20',
                'category' =>'max: 20',
                'design_pattern' =>'max: 20',
                'rarity' =>'max: 20',
            ]);
            if($validator->fails()){
                return response(['error' => $validator->errors()], 401);
            }else{
                $types = json_encode($request->input('types'));
                $request['types'] = $types;
                $skin->update($request->all());
                return response(['Skin updated' => $skin, 'message' => "Skin updated!"], 200);
            }
        }else{
            return response(['error' => "We can't find any skin with this ID!"], 404);
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
