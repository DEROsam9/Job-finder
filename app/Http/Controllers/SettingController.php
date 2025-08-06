<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(){
        $data=Setting::first();
        return response()->json([
            "message"=>"success",
            "data"=>$data
        ]);
    }
    public function store(Request  $request){
        $validate= $request->validate([
            "name"=>"required",
            "email"=>"required|email",
            "phone"=>"required",
            "location"=>"required",
            "address"=>"required",
           
        ]);
        $data=Setting::create([
            "name"=>$validate['name'],
            "email"=>$validate['email'],
            "kra_pin"=>$request->kra_pin,
            "phone"=>$validate['phone'],
            "location"=>$validate['location'],
            "address"=>$validate['address'],
            "email_configs"=>$request->email_configs,
            "logo"=>$request->logo

        ]);
        return response()->json([
            "message"=>"created successfully",
            "data"=>$data
        ]);
    }
    public function show($id){
        $data= Setting::find($id);
        if($id){
            return response()->json([
                "message"=>"successful",
                "data"=>$data
            ]);
        }else{
            return response()->json([
                "message"=>"failed or id doesnt exist"],200);
        }

    }
    
    
    public function update( Request $request, $id){
        $data= Setting::find($id);
        if($id){
            $data->update([
                "name"=>$request->name,
                "email"=>$request->email,
                "kra_pin"=>$request->kra_pin,
                "phone"=>$request->phone,
                "location"=>$request->location,
                "address"=>$request->address,
                "email_configs"=>$request->email_configs,
                "logo"=>$request->logo
            ]);
            return response()->json([
                "message"=>"successfully updated",
               "data" =>$data
            ]);
        }

    }
    public function destroy($id){
        $data=Setting::find($id);
        if($data){
        $data->delete();
    return response()->json([
        "message"=>"data deleted."
                                ]);
    }
    else{
        return response()->json([
            "message"=>"failed to deleted."]);
    }


    }
}
