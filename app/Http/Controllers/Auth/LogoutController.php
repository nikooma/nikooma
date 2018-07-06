<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LogoutController extends Controller
{
    public function _index_(){
		session()->forget('PermissionValue'); //***important***: in the Illuminate/Foundation/Auth/AuthenticatesUsers.php in function showLoginForm add this line
		Auth::logout();
		return redirect()->route('login');
	}
}
