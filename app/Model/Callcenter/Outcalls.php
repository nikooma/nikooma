<?php

namespace App\Model\Callcenter;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
class Outcalls extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_outcalls left join tbl_outbound on tbl_outcalls.oc_outbound=tbl_outbound.o_id Where \"oc_id\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
    public static function get_records() {
		$sql = "Select * From tbl_outcalls left join tbl_outbound on tbl_outcalls.oc_outbound=tbl_outbound.o_id order by \"oc_id\"";
		$query = DB::select($sql);

		return $query;
	}    
	public static function get_new_id() {		
		$item_id=GClass::get_new_id("tbl_outcalls","oc_id");    
		return $item_id;
	}    
	public static function add_new_record(){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		        
        $txtTimeout=Validation::validateString(Input::get('inp_txtTimeout'));
        $ddlCodec=Input::get('inp_ddlCodec');      
		$ddlOutbound=Input::get('inp_ddlOutbound');     
		$bypassmedia=Input::get('inp_bypassmedia');     
		$confortnoise=Input::get('inp_confortnoise');   
        $ddlDestination=Input::get('grp_ddlDestination');   
		$ddlDestValue=Input::get('grp_ddlDestValue'); 		
		$txtMethod=Validation::validateString(Input::get('inp_txtMethod'));
		$item_id=GClass::get_new_id("tbl_outcalls","oc_id");	
        if (strlen($txtName) > 0){		
            try {                	
				$sql = "Insert Into \"tbl_outcalls\"(\"oc_name\",\"oc_timeout\",\"oc_bypassmedia\",\"oc_confortnoise\",\"oc_codec\",\"oc_outbound\",".
				"\"oc_afterdes\",\"oc_afterval\",\"oc_aftervalmet\",\"oc_id\")Values(".
				"'$txtName','$txtTimeout','$bypassmedia','$confortnoise','$ddlCodec','$ddlOutbound','$ddlDestination',".
				"'$ddlDestValue','$txtMethod','$item_id')";			
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
        $txtTimeout=Validation::validateString(Input::get('inp_txtTimeout'));
        $ddlCodec=Input::get('inp_ddlCodec');      
		$ddlOutbound=Input::get('inp_ddlOutbound');     
		$bypassmedia=Input::get('inp_bypassmedia');     
		$confortnoise=Input::get('inp_confortnoise');   
        $ddlDestination=Input::get('grp_ddlDestination');   
		$ddlDestValue=Input::get('grp_ddlDestValue'); 		
		$txtMethod=Validation::validateString(Input::get('inp_txtMethod'));  
		
        if (strlen($txtName) > 0){		
            try {      
				$sql = "Update \"tbl_outcalls\" set \"oc_name\"='$txtName',\"oc_timeout\"='$txtTimeout',\"oc_bypassmedia\"='$bypassmedia', \"oc_confortnoise\"='$confortnoise',\"oc_codec\"='$ddlCodec'".
					",\"oc_outbound\"='$ddlOutbound',\"oc_afterdes\"='$ddlDestination',\"oc_afterval\"='$ddlDestValue',\"oc_aftervalmet\"='$txtMethod' where \"oc_id\"='$item_id'";
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
			$sql = "Delete from tbl_outcalls Where \"oc_id\"='".$item_id."'";
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