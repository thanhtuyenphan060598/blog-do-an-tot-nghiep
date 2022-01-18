<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\GoogleProvider;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function __construct()
    {

    }


    /**
    * @see undefined
    * @method static \Laravel\Socialite\Two\InvalidStateException staless
    */
    public function SocialSignup($provider)
    {

        // Socialite will pick response data automatic

        $user = Socialite::driver($provider)->stateless()->user();
        if(!$user) {
            return response()->json(401);
        }
        $systemUser = User::firstOrCreate(
            ['google_id' => $user->id],
            [
                'name' => $user->name,
                'username' => 'google_'.$user->id,
                'email' => $user->email,
                'role_id'=> 2,
                'password' => Hash::make($user->id)
            ]
        );
        return response()->json(['user'=>$systemUser]);
    }
}
