<?php

namespace App\Http\Controllers;

class Validation extends Controller
{
    public static function validateString($strVal,$len=0){
		$inp_val=htmlentities($strVal, ENT_QUOTES | ENT_IGNORE, "UTF-8");
		$inp_val=addslashes($inp_val);
		if($len==0){
			return filter_var($inp_val, FILTER_SANITIZE_STRING);	
		}
		else{
			if(strlen($strVal)<=$len){
				return filter_var($inp_val, FILTER_SANITIZE_STRING);	
			}
			else
			{
				return filter_var(substr($inp_val,$len), FILTER_SANITIZE_STRING);	
			}	
		}
	}
	public static function is_json($str){ 
		return json_decode($str) != null;
	}
}
