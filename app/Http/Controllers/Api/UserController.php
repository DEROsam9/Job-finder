<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function index(Request $request){

       $users= $this->userRepository->paginate($request->get('limit', 20));

        return response()->json([
            "message" => "User fetched successfully.",
                'data' => $users,
            ], 200);
    }

    public function store(Request $request){
        $validate = $request->validate([
            "name" => "required|string",
            "email"=> "required|email|unique:users",
            "phone_number"=>"nullable|string",
            "password"=>"required"
        ]);

        $user = $this->userRepository->create($validate);

        return response()->json([
            "message" => "User created successfully.",
            "data"=>$user
        ], 201);
    }

    public function update(Request $request,$id){
        $validated = $request -> validate([
            "name" => "nullable|string",
            "email"=> "nullable|email|unique:users,email,".$id,
            "phone_number"=>"nullable|string",
        ]);

        $user = $this->userRepository->update($validated, $id);

        return response()->json([
            "message" => "User updated successfully.",
            "data" =>$user
        ],201);
    }

    public function show($id){
        $user = $this->userRepository->find($id);

        if(!$user){
            return response()->json([
                "message" => "User not Found"
            ],404);
        }

        return response()->json(['data'=>$user]);
    }

    public function destroy($id){
        $user = $this->userRepository->find($id);

        if(!$user){
            return response()->json([
                "message" => "User not Found"
            ],404);
        }
        $deleted = $this->userRepository->delete($id);

        if($deleted){
            return response()->json(['message'=>'User Deleted']);
        }
    }
}
