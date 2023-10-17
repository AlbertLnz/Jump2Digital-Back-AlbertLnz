<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SkinModel;

class SkinController extends Controller
{
    public function read(){
        return SkinModel::all();
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
            $skin = SkinModel::create($request->all());
            return response(['skin' => $skin, 'message' => "Skin created!"], 200);
        }
    }

    public function update(Request $request, $id){
        $skin = SkinModel::find($id);
        
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
                $skin->update($request->all());
                return response(['Skin updated' => $skin, 'message' => "Skin updated!"], 200);
            }
        }else{
            return response(['error' => "We can't find any skin with this ID!"], 401);
        }

    }

    public function delete($id){
        $skin = SkinModel::find($id);
        if($skin->id === intval($id)){
            $skin->delete();
            return response(['message' => "Skin deleted!"], 200);
        }else{
            return response(['error' => "We can't find any skin with this ID!"], 401);
        }
    }

}
