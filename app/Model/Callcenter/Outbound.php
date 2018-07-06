<?php

namespace App\Model\Callcenter;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
class Outbound extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_outbound Where \"o_id\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
    public static function get_records() {
		$sql = "Select * From tbl_outbound order by \"o_id\"";
		$query = DB::select($sql);

		return $query;
	}    
	public static function get_new_id() {		
		$item_id=GClass::get_new_id("tbl_outbound","o_id");    
		return $item_id;
	}    
	public static function add_new_record(){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		        
        $txtTimout=Input::get('inp_txtTimout');      
		$txtIPAddr=Input::get('inp_txtIPAddr');     
		$txtProxy=Input::get('inp_txtProxy');     
		$registerneed=Input::get('inp_registerneed');   
        $txtReply=Input::get('inp_txtReply');  
		$txtUsername=Input::get('inp_txtUsername');   
        $txtPass=Input::get('inp_txtPass'); 
		$txtRegProxy=Input::get('inp_txtRegProxy'); 
		$calleridinfrom=Input::get('inp_calleridinfrom'); 
		$ddlProtocol=Input::get('inp_ddlProtocol'); 
		$txtPing=Input::get('inp_txtPing'); 		
		$item_id=GClass::get_new_id("tbl_outbound","o_id");	
		
		if($txtTimout=="")$txtTimout="0";
		if($txtReply=="")$txtReply="0";
		
        if (strlen($txtName) > 0){		
            try {                	
				$sql = "Insert Into \"tbl_outbound\"(\"o_id\",\"o_name\",\"o_timeout\",\"o_ipaddress\",\"o_proxy\",".
				"\"o_registering\",\"o_username\",\"o_password\",\"o_timetorepeate\",\"o_registerproxy\",\"o_calleridinfrom\",\"o_registertransport\",\"o_ping\")Values(".
					"'$item_id','$txtName','$txtTimout','$txtIPAddr','$txtProxy','$registerneed','$txtUsername',".
					"'$txtPass','$txtReply','$txtRegProxy','$calleridinfrom','$ddlProtocol','$txtPing')";			
				$query = DB::insert($sql);
				if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
					return "خطا در اجرای دستور پاکسازی کش";
				}                
			} catch (Exception $e) {
			    return $e->getMessage();
			}
			return "0";
		}
		return "1";
	}
	public static function update_record($item_id){	
		try{
			$id_check = intval($item_id);
			if($id_check<=0) return "1";
		} catch (Exception $ex) {
			return $ex->getMessage();
		}

        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		        
        $txtTimout=Input::get('inp_txtTimout');      
		$txtIPAddr=Input::get('inp_txtIPAddr');     
		$txtProxy=Input::get('inp_txtProxy');     
		$registerneed=Input::get('inp_registerneed');   
        $txtReply=Input::get('inp_txtReply');  
		$txtUsername=Input::get('inp_txtUsername');   
        $txtPass=Input::get('inp_txtPass'); 
		$txtRegProxy=Input::get('inp_txtRegProxy'); 
		$calleridinfrom=Input::get('inp_calleridinfrom'); 
		$ddlProtocol=Input::get('inp_ddlProtocol'); 
		$txtPing=Input::get('inp_txtPing'); 	
		if($txtTimout=="")$txtTimout="0";
		if($txtReply=="")$txtReply="0";
        if (strlen($txtName) > 0){		
            try {      
				$sql = "Update \"tbl_outbound\" set \"o_name\"='$txtName',\"o_timeout\"='$txtTimout', \"o_ipaddress\"='$txtIPAddr',\"o_proxy\"='$txtProxy'".
					",\"o_registering\"='$registerneed',\"o_username\"='$txtUsername',\"o_password\"='$txtPass',\"o_timetorepeate\"='$txtReply',".
					"\"o_registerproxy\"='$txtRegProxy',\"o_calleridinfrom\"='$calleridinfrom',\"o_registertransport\"='$ddlProtocol',\"o_ping\"='$txtPing' where \"o_id\"='$item_id'";
				$query = DB::insert($sql);   
				if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
					return "خطا در اجرای دستور پاکسازی کش";
				}
			} catch (Exception $e) {
			    return $e->getMessage();
			}
			return "0";
		}
		return "1";
	}
	
	public static function delete_record($item_id){
		
        try {
			$sql = "Delete from tbl_outbound Where \"o_id\"='".$item_id."'";
			$query = DB::delete($sql);
			if($query<=0){
				return "رکورد با شماره ".$item_id." یافت نشد.";
			}
			if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
				return "خطا در اجرای دستور پاکسازی کش";
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
}