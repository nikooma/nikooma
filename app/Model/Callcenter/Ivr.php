<?php

namespace App\Model\Callcenter;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\app_code\GClass;
use App\Http\Controllers\app_code\Permissions;

class Ivr extends Model
{    
    public static function get_record_by_id($item_id) {
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select tbl_ivr.*, isn.s_id as insound, esnd.s_id as errsound, exsn.s_id as exitsound ".
				"From tbl_ivr ".
				"LEFT JOIN tbl_sounds as isn ON tbl_ivr.i_insound=isn.s_id ".
				"LEFT JOIN tbl_sounds as esnd ON tbl_ivr.i_errsound=esnd.s_id ".
				"LEFT JOIN tbl_sounds as exsn ON tbl_ivr.i_exitsound=exsn.s_id where tbl_ivr.i_id='$item_id'";
		$query = DB::select($sql);
		return $query;
	}	
		
	public static function get_ivr_actions($item_id) {
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * from tbl_ivraction where a_ivr='$item_id' order by a_digit";
		$query = DB::select($sql);
		return $query;
	}	
	
    public static function get_records() {		
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select tbl_ivr.*, isn.s_name as insound, esnd.s_name as errsound, exsn.s_name as exitsound ".
				"From tbl_ivr ".
				"LEFT JOIN tbl_sounds as isn ON tbl_ivr.i_insound=isn.s_id ".
				"LEFT JOIN tbl_sounds as esnd ON tbl_ivr.i_errsound=esnd.s_id ".
				"LEFT JOIN tbl_sounds as exsn ON tbl_ivr.i_exitsound=exsn.s_id order by tbl_ivr.i_id";
		$query = DB::select($sql);
		return $query;
	}    
	public static function get_new_id() {		
		$item_id=GClass::get_new_id("tbl_ivr","i_id");    
		return $item_id;
	}    
	public static function add_new_record(){		
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		
        $txtName=Validation::validateString(Input::get('inp_txtName'),50);		
        $ddlConSound=Validation::validateString(Input::get('inp_ddlConSound'));
        $ddlErrSound=Validation::validateString(Input::get('inp_ddlErrSound'));
		$ddlExSound=Validation::validateString(Input::get('inp_ddlExSound'));
		$txtMaxAttemp=Validation::validateString(Input::get('inp_txtMaxAttemp'));
        $txtOverflow=Input::get('inp_txtOverflow');        
        $txtInterTime=Input::get('inp_txtInterTime');
        $txtMaxOverflow=Validation::validateString(Input::get('inp_txtMaxOverflow'));
        $txtDigits=Validation::validateString(Input::get('inp_txtDigits')); 
		$txtAllowed=Validation::validateString(Input::get('inp_txtAllowed'));
		
		$i_id=Input::get('inp_hdID');
		if(!isset($_POST['ivractions'])){
			return "منشی باید دارای حداقل یک گام باشد";
		}
		$ivrActions=Input::get('ivractions');
		
		$sql = "select * from tbl_ivr where i_name='$txtName'";
		$query = DB::select($sql);
		if(count($query)>0){
			return "نام وارد شده وجود دارد. لطفا از نام دیگری استفاده نمایید";	
		}		
        if (strlen($txtName) > 0){		
            try {                								
				$sql = "Insert Into tbl_ivr(i_id,i_name,i_insound,i_errsound,i_exitsound,i_maxattemp,i_waitforinput,i_maxenterdigittime,i_maxwaitattemp,i_digitlen,i_alloweddigits)Values(".
					"'$i_id','$txtName','$ddlConSound','$ddlErrSound','$ddlExSound','$txtMaxAttemp','$txtOverflow','$txtInterTime','$txtMaxOverflow','$txtDigits','$txtAllowed')";
				$query = DB::insert($sql);	
				foreach($ivrActions as $acts){
					$actions=explode(",",$acts);
					$digit=$actions[0];
					$action=$actions[1];
					$actionvalue=$actions[2];
					$method=$actions[3];
					$sql = "Insert Into tbl_ivraction(a_digit,a_dest,a_destvalue,a_method,a_ivr)Values(".
						"'$digit','$action','$actionvalue','$method','$i_id')";
					$query = DB::insert($sql);	
				}		
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
		if(Permissions::permissionCheck('23','03')==0)
			return abort(404);
		try{
			$id_check = intval($item_id);
			if($id_check<=0) return "1";
		} catch (Exception $ex) {
			return $ex->getMessage();
		}

        $txtName=Validation::validateString(Input::get('inp_txtName'),50);		
        $ddlConSound=Validation::validateString(Input::get('inp_ddlConSound'));
        $ddlErrSound=Validation::validateString(Input::get('inp_ddlErrSound'));
		$ddlExSound=Validation::validateString(Input::get('inp_ddlExSound'));
		$txtMaxAttemp=Validation::validateString(Input::get('inp_txtMaxAttemp'));
        $txtOverflow=Input::get('inp_txtOverflow');        
        $txtInterTime=Input::get('inp_txtInterTime');
        $txtMaxOverflow=Validation::validateString(Input::get('inp_txtMaxOverflow'));
        $txtDigits=Validation::validateString(Input::get('inp_txtDigits')); 	
		$txtAllowed=Validation::validateString(Input::get('inp_txtAllowed'));		
		if(!isset($_POST['ivractions'])){
			return "منشی باید دارای حداقل یک گام باشد";
		}
		$ivrActions=Input::get('ivractions');
		
		$sql = "select * from tbl_ivr where i_name='$txtName'";
		$query = DB::select($sql);
		if(count($query)>1){
			return "نام وارد شده وجود دارد. لطفا از نام دیگری استفاده نمایید";	
		}		
        if (strlen($txtName) > 0){		
            try {                								
				$sql = "Update tbl_ivr Set i_name='$txtName',i_insound='$ddlConSound',i_errsound='$ddlErrSound',".
					"i_exitsound='$ddlExSound',i_maxattemp='$txtMaxAttemp',i_waitforinput='$txtOverflow',i_maxenterdigittime='$txtInterTime'".
					",i_maxwaitattemp='$txtMaxOverflow',i_digitlen='$txtDigits',i_alloweddigits='$txtAllowed' Where i_id='$item_id'";
				$query = DB::insert($sql);	
				$sql = "Delete from tbl_ivraction Where a_ivr='$item_id'";
				$query = DB::delete($sql);	
				foreach($ivrActions as $acts){
					$actions=explode(",",$acts);
					$digit=$actions[0];
					$action=$actions[1];
					$actionvalue=$actions[2];
					$method=$actions[3];
					$sql = "Insert Into tbl_ivraction(a_digit,a_dest,a_destvalue,a_method,a_ivr)Values(".
						"'$digit','$action','$actionvalue','$method','$item_id')";
					$query = DB::insert($sql);	
				}		
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
		if(Permissions::permissionCheck('23','04')==0)
			return abort(404);
        try {			
			$sql = "Delete from tbl_ivr Where i_id='$item_id'";
			$query = DB::delete($sql);			
			$sql = "Delete from tbl_ivraction Where a_ivr='$item_id'";
				$query = DB::delete($sql);
			if($query<=0){
				return "رکورد با شماره $item_id یافت نشد.";
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