<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Permission;
use App\Models\UserPermission;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            "name"=> "required",
            "email"=> "required|string",
            "password"=> "required|string|confirmed",
            "role_id"=> "required"
        ]);

        $user = new User(
            [
            "name" => $request->name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
            "role_id"=>$request->get('role_id')
            ]
        );

        $user->save();
        $token = $user->createToken('Token')->accessToken;
        return response()->json([
            "message"=> "User Created Successfully",
            "bearer"=>$token
        ]);


    }


    // login the user
    public function login(Request $request)
    {
        $data = [
            "name"=>$request->name,
            "password"=>$request->password
        ];
        $user = $request->user();

        if(auth()->attempt($data))
        {
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json([
                "token"=>$token
            ], 200);
        }
        else
        {
            return response()->json(["message"=> "Unauthoazied"], 401);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response([
            "message"=> "Loggedout!"
        ]);
    }


    // edit profile
    public function editUser(Request $request, $id)
    {
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return response()->json([
            "message"=> "Updated"
        ]);

    }

    // delete profile
    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            "message"=> "deleted"
        ]);
    }

    // adding permission to user

  

}
