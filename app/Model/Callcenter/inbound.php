<?php

namespace App\Model\Callcenter;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
class inbound extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_inbounds left join tbl_sipservers on tbl_inbounds.context=tbl_sipservers.s_id Where \"icode\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
    public static function get_records() {
		$sql = "Select * From tbl_inbounds left join tbl_sipservers on tbl_inbounds.context=tbl_sipservers.s_id  order by \"icode\"";
		$query = DB::select($sql);

		return $query;
	}    
	public static function get_new_id() {		
		$item_id=GClass::get_new_id("tbl_inbounds","icode");    
		return $item_id;
	}    
	public static function add_new_record(){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		        
        $txtDestNumber=Validation::validateString(Input::get('inp_txtDestNumber'));
        $ddlDestination=Input::get('grp_ddlDestination');      
		$txtUsername=Input::get('inp_txtUsername');     
		$txtPass=Input::get('inp_txtPass');     
		$ddlServers=Input::get('inp_ddlServers');   
        $ddlDestValue=Input::get('grp_ddlDestValue');   
		$item_id=GClass::get_new_id("tbl_inbounds","icode");	
        if (strlen($txtName) > 0){		
            try {                	
				$sql = "Insert Into \"tbl_inbounds\"(\"context\",\"username\",\"password\",\"iname\",\"icode\",\"idestinationnumber\",\"idestination\",\"idestinationvalue\")Values(".
					"'$ddlServers','$txtUsername','".md5($txtPass)."','$txtName','$item_id',E'$txtDestNumber','$ddlDestination','$ddlDestValue')";			
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
        $txtDestNumber=Validation::validateString(Input::get('inp_txtDestNumber'));
        $ddlDestination=Input::get('grp_ddlDestination');        
		$txtUsername=Input::get('inp_txtUsername');     
		$txtPass=Input::get('inp_txtPass');   
		$ddlServers=Input::get('inp_ddlServers');   
        $ddlDestValue=Input::get('grp_ddlDestValue');   
		
        if (strlen($txtName) > 0){		
            try {      
				if(strlen($txtPass)>0){
					$sql = "Update \"tbl_inbounds\" set \"context\"='$ddlServers',\"password\"='".md5($txtPass)."',\"username\"='$txtUsername', \"iname\"='$txtName',\"idestinationnumber\"='$txtDestNumber'".
						",\"idestination\"='$ddlDestination',\"idestinationvalue\"=E'$ddlDestValue' where \"icode\"='$item_id'";
				}
				else{
					$sql = "Update \"tbl_inbounds\" set \"context\"='$ddlServers',\"username\"='$txtUsername', \"iname\"='$txtName',\"idestinationnumber\"=E'$txtDestNumber'".
						",\"idestination\"='$ddlDestination',\"idestinationvalue\"='$ddlDestValue' where \"icode\"='$item_id'";
				}
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
			$sql = "Delete from tbl_inbounds Where \"icode\"='".$item_id."'";
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