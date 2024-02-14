<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function login(Request $request){
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:6'
        ]);
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'mensaje' => 'Usuario o contraseña incorrecta'
            ],401);
        }
        if($user->estado == 'Bloqueado'){
            return response()->json([
                'mensaje' => 'Usuario Bloqueado'
            ],203);
        }
        $abilities = $user->getAllPermissions()->pluck('name')->toArray();
        // Remover el atributo de permisos y roles del objeto user
        $user->unsetRelation('permissions');
        $user->unsetRelation('roles');
        $data['user'] = $user;
        $data['token'] = $user->createToken($user->name.'-AuthToken',$abilities)->plainTextToken;

        $response = [
            'estado' => 'success',
            'mensaje' => 'Inicio de sesión exitoso.',
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
    
        return response()->json([
            'estado' => 'success',
            'mensaje'=> 'logged out'
        ],200);
    }
}
