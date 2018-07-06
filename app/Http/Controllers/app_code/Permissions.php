<?php

namespace App\Http\Controllers\app_code;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use Auth;

class Permissions extends Controller
{	
	/*
	Permission default parts:
		1: view
		2: edit
		3: delete
		4: add
		5: export		
		another parts 
		c1: spy
		c2: add group to user in usermanagement
	*/
	public static function permissionCheck_u($page,$part,$user)
	{		
		
		//if($user=='majidmjz') return 1;
		$perm="R$page"."S$part";
		$permvalue='';
		if(is_null(session('PermissionValue','')) || session('PermissionValue','')==''){	
			$sql = "select dastrasi.dastrasi as perm from users inner join users_group on users.id=users_group.user_id ".
				   "inner join dastrasi on users_group.group_id=dastrasi.ga_group_id where users.username='$user'";
			$query = DB::select($sql);
			foreach($query as $item){
				$permvalue=$item->perm;
			}
			session()->forget('PermissionValue');
			session(['PermissionValue' => $permvalue]);
		}
		$perm="R$page"."S$part";
		$seperm=session('PermissionValue');
		if(strpos($seperm,$perm)=='')		
			return 0;
		else
			return 1;
	}
	public static function permissionCheck($page,$part)
	{		
		$user=Auth::user()->username;
		//if($user=='majidmjz') return 1;
		$perm="R$page"."S$part";
		$permvalue='';
		if(is_null(session('PermissionValue','')) || session('PermissionValue','')==''){	
			$sql = "select dastrasi.dastrasi as perm from users inner join users_group on users.id=users_group.user_id ".
				   "inner join dastrasi on users_group.group_id=dastrasi.grup_id where users.username='$user'";
			$query = DB::select($sql);
			foreach($query as $item){
				$permvalue=$item->perm;
			}						
			session()->forget('PermissionValue');
			session(['PermissionValue' => $permvalue]);
		}
		$perm="R$page"."S$part";
		$seperm=session('PermissionValue');		
		if(strpos($seperm,$perm)=='')		
			return 0;
		else
			return 1;
	}
}