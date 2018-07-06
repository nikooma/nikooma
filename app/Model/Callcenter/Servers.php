<?php

namespace App\Model\Callcenter;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
class Servers extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_sipservers Where \"s_id\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
    public static function get_records() {
		$sql = "Select * From tbl_sipservers order by \"s_id\"";
		$query = DB::select($sql);

		return $query;
	}    
	public static function get_new_id() {		
		$item_id=GClass::get_new_id("tbl_sipservers","s_id");    
		return $item_id;
	}    
	public static function add_new_record(){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		        
        $txtِDomain=Validation::validateString(Input::get('inp_txtِDomain'));       
		$item_id=GClass::get_new_id("tbl_sipservers","s_id");	
        if (strlen($txtName) > 0){		
            try {                	
				$sql = "Insert Into \"tbl_sipservers\"(\"s_id\",\"s_name\",\"s_domain\")Values(".
					"'$item_id','$txtName','$txtِDomain')";			
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
        $txtِDomain=Validation::validateString(Input::get('inp_txtِDomain'));    
		
        if (strlen($txtName) > 0){		
            try {      					
				$sql = "Update \"tbl_sipservers\" set \"s_name\"='$txtName',\"s_domain\"='$txtِDomain' where \"s_id\"='$item_id'";
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
			$sql = "Delete from tbl_sipservers Where \"s_id\"='".$item_id."'";
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