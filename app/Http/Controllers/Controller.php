<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /** @var  \App\User|\Illuminate\Auth\Authenticatable */
    protected $user;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
}
