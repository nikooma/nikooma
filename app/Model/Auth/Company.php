<?php

namespace App\Model\Auth;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\app_code\GClass;

class Company extends Model
{
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_company Where \"co_id\"='".$item_id."'";
		$query = DB::select($sql);
		return $query;
	}
    public static function get_records() {
		$sql = "Select * From tbl_company order by \"co_id\"";
		$query = DB::select($sql);
		return $query;
	}    
	public static function add_new_record(){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),50);		
        $txtDesc=Validation::validateString(Input::get('inp_txtDesc'));   
		$item_id=GClass::get_new_id("tbl_company","co_id");		
        if (strlen($txtName) > 0){
			$gname = DB::table('tbl_company')->where('co_name', $txtName)->count();			
			if($gname>0)
				return "این شرکت قبلا افزوده شده است!";	
			try {						
				$sql = "Insert Into \"tbl_company\"(co_id,co_name,co_description)Values('$item_id','$txtName','$txtDesc')";
				$query = DB::insert($sql);					
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

        $txtName=Validation::validateString(Input::get('inp_txtName'),50);		
        $txtDesc=Validation::validateString(Input::get('inp_txtDesc'));  
		
        if (strlen($txtName) > 0){
			try {
				$sql = "Update tbl_company Set co_name='$txtName',co_description='$txtDesc' Where co_id='$item_id'";
				$query = DB::insert($sql);
			} catch (Exception $e) {
			 return $e->getMessage();
			}						
			return "0";
		}
		
		return "1";
	}
	
	public static function delete_record($item_id){
		
        try {
			$sql = "Delete from tbl_company Where \"co_id\"='".$item_id."'";
			$query = DB::delete($sql);
			if($query<=0){
				return "رکورد با شماره ".$item_id." یافت نشد.";
			}			
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
}
