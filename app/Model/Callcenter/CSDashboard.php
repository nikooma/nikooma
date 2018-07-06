<?php

namespace App\Model\Callcenter;

date_default_timezone_set('Iran');

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
class CSDashboard extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_inbounds left join tbl_sipservers on tbl_inbounds.context=tbl_sipservers.s_id Where \"icode\"='$item_id'";
		$query = DB::select($sql);

		return $query;
	}
	public static function get_queue_list($item_id) {
		$sql = "Select * From tbl_queuetiers left join tbl_queues on tbl_queuetiers.t_queue=tbl_queues.q_routeid Where tbl_queuetiers.t_useragent='$item_id' order by tbl_queues.q_name desc";
		$query = DB::select($sql);

		return $query;
	}
	public static function get_agent_list($item_id) {
		$sql = "SELECT * FROM tbl_agentlist where name='$item_id'";
		$query = DB::select($sql);

		return $query;
	}
	public static function get_holdingtime($item_id,$lastreadytime) {
		$sql = "SELECT sum(a_totalsecends)as totalhold FROM tbl_agentsio where ".
			"a_agent='$item_id' and a_datetime>'$lastreadytime' and a_lastaction='On Break'";
		$query = DB::select($sql);
		if($query!=null){
			return $query[0]->totalhold;
		}
		else{
			return "0";
		}
		return $query;
	}
	public static function get_members_list($item_id) {
		$sql = "SELECT * FROM tbl_members left join mod_crmprofile_customersprofile on tbl_members.session_uuid=mod_crmprofile_customersprofile.cp_uuid Where serving_agent='$item_id'";
		$query = DB::select($sql);
		return $query;
	}
	public static function get_last_registration($userag) {
		$query = DB::select("SELECT * FROM public.tbl_sipregistration where concat(user_id,'@',domain)='$userag' order by regtime desc limit 1");		
		if($query==null){
			return "false";
		}
		$start = date_create($query[0]->regtime);
		$end = date_create(date('Y-m-d H:i:s'));
		$diff=date_diff($end,$start);	
		$total=($diff->i*60)+$diff->s;
		if($total>61){
			return "false";
		}
		else{
			return $query[0]->userip;
		}
	}   
	public static function get_last_status($userag) {
		$query = DB::select("SELECT * FROM tbl_agentsio WHERE a_agent='$userag' order by a_datetime desc limit 1");
		if($query==null){
			return "Logged Out";
		}
		return $query[0]->a_action;
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