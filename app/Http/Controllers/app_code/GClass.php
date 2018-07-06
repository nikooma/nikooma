<?php

namespace App\Http\Controllers\app_code;

date_default_timezone_set('Iran');

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\Auth\UserManager;
use Session;

class GClass extends Controller
{
    //
	public static function get_new_id($tablename,$itemname) {
		$sql = "Select max(".$itemname.") as maxid From ".$tablename;
		$query = DB::select($sql);
		$newid=0;
		foreach ($query as $item){
			$newid = $item->maxid;
		}		
		$newid++;
		return $newid;
	}
	public static function faTOen($string) {
	    return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
	}
	public static function enTOfa($string) {
	    return strtr($string, array('0'=>'۰', '1'=>'۱', '2'=>'۲', '3'=>'۳', '4'=>'۴', '5'=>'۵', '6'=>'۶', '7'=>'۷', '8'=>'۸', '9'=>'۹'));
	}
<<<<<<< HEAD
	public static function getDestinationValue($destId) {
	    switch($destId){
			case "1":
				
			break;
		}
	}
		
=======
	
>>>>>>> 712a6e1edd6ba224e09eec66dca17a1c18d7ad66
	public static function encryptStringE($str,$code){
		// character table
		$chars='1234567890!@#$%^&*()qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM ,<.>/?;:"[{]}\|`~';
		// new code begin
		$newcode="";
		// we start
		for($i=1;$i<=999;$i++){
			if(substr($str,$i,$i) == ""){
				break;
			}
			else{
				$com=substr($str,$i,$i);
			}
			for($x=1;$x<=90;$x++){
				$cur=substr($chars,$x,$x);
				if($com == $cur){
					$newc=$x+$code;
					while($newc > 90){
						$newc -= 90;	
					}						
					$newcode="".$newcode."".substr($chars,$newc,$newc)."";
				}
			}
		}		
		return $newcode;
	}
	
	public static function unencryptString($str,$code){
		// character table
		$chars='1234567890!@#$%^&*()qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM ,<.>/?;:"[{]}\|`~';
		// new code begin
		$newcode="";
		// we start
		for($i=1;$i<=999;$i++){
			if(substr($str,$i,$i) == ""){
				break;
			}
			else{
				$com=substr($str,$i,$i);
			}
			for($x=1;$x<=90;$x++){
				$cur=substr($chars,$x,$x);
				if($com == $cur){
					$newc=$x-$code;
					while($newc < 0){
						$newc += 90;
					}
					$newcode="".$newcode."".substr($chars,$newc,$newc)."";
				}
			}
		}
		return $newcode;
	}
	
	public static function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
}
