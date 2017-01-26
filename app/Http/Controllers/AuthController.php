<?php
/**
 * Created by PhpStorm.
 * User: resation
 * Date: 25.01.17
 * Time: 15:18
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers, GuardHelpers;

    public function auth(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)
        ) {
            $token = str_random(60);
            $user = $this->guard()->user();
            $user->api_token = $token;
            $user->save();
            return $token;
        } else {
            return abort(406);
        }
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}