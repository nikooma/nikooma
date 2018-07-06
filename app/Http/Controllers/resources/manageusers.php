<?php

namespace App\Http\Controllers\resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use File;
use App\Http\Controllers\app_code\GClass;

class manageusers extends Controller
{
    public static function generateDirectory($sipid,$password){
		$xmlpath=resource_path()."/xml";
		$dirpath=config('switch.app')."/conf/directory/aras";
		$directoryxml = File::get($xmlpath."/directory.xml");
		$directoryxml=str_replace("{SIPID}",$sipid,$directoryxml);
		$directoryxml=str_replace("{PASSWORD}",$password,$directoryxml);
		if(File::exists($dirpath."/".$sipid.".xml"))
			File::delete($dirpath."/".$sipid.".xml");
		File::put($dirpath."/".$sipid.".xml", $directoryxml);
		$res=GClass::execAPI(config('switch.app'),"reloadxml","+OK");
		return $res;
	}
	public static function deleteResource($respath){	
		if(File::exists($dirpath=config('switch.app').$respath))
			File::delete($dirpath=config('switch.app').$respath);
		if(File::exists($dirpath=config('switch.app').$respath))
			return 0;
		else
			return 1;
	}
}
