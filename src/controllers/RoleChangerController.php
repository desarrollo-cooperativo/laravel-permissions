<?php

namespace Cardumen\LaravelPermissions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class RoleChangerController extends Controller
{
	
	public function __construct()
    {
        $this->middleware(['web','auth']);
    }
    public function change(Request $request){
    	$request->user()->setActiveRole($request->input('role_id'));

    	return redirect('/inicio');
    }
}
