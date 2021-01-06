<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use App\Models\Socialite as Social;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::INICIO;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectProvider($driver){
        $drivers=['facebook','google'];
        if(in_array($driver,$drivers)){
            return Socialite::driver($driver)->redirect();
        }
        else{
            return redirect()->route("login")->with("mensaje",$driver." no es una aplicación válida para iniciar sesion" );
        }
    }
    public function handleProviderCallback(Request $request , $driver){
        if($request->get("error")){
            return redirect()->route("login")->with("mensaje","ocurrió un error al Iniciar Sesion con ".$driver);
        }
        $user = Socialite::driver($driver)->user();
        
        $social = Social::where("id_social",$user->getId())
        ->where("nombre_social",$driver)->first();
        if(!$social){
            $usuario = User::where("email",$user->getEmail())->first();
            if(!$usuario){
                $usuario=User::create([
                    "name"=>$user->getName(),
                    "email"=>$user->getEmail()
                ]);
            }
            $social=Social::create([
                "id_users"=>$usuario->id,
                "id_social"=>$user->getId(),
                "nombre_social"=>$driver,
                "nombre"=>$user->getName(),
                "email"=>$user->getEmail(),
                "avatar"=>$user->getAvatar()."&access_token=".$user->token
            ]);
        }
        auth()->login($social->user);
        return redirect()->route("inicio");
    }

}


