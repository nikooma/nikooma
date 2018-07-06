<?php

namespace App\Model\Callcenter;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\app_code\GClass;
use App\Http\Controllers\app_code\Permissions;

class Queue extends Model
{    
    public static function get_record_by_id($item_id) {
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tbl_queues Where q_routeid='$item_id'";
		$query = DB::select($sql);
		return $query;
	}	
	public static function get_agent_by_queue($queue) {
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From users left join tbl_queuetiers on users.sip_number=tbl_queuetiers.t_useragent Where tbl_queuetiers.t_queue='$queue' order by tbl_queuetiers.t_id desc";
		$query = DB::select($sql);
		return $query;
	}		
	public static function get_agent_by_name($agent,$queue) {
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tbl_queuetiers Where t_useragent='$agent' and t_queue='$queue'";
		$query = DB::select($sql);
		return $query;
	}			
    public static function get_records() {		
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tbl_queues order by q_routeid";
		$query = DB::select($sql);
		return $query;
	}    
	public static function get_new_id() {		
		$item_id=GClass::get_new_id("tbl_queues","q_routeid");    
		return $item_id;
	}    
	public static function add_new_record(){
		$serverip=config('switch.serverip');
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		
        $txtName=Validation::validateString(Input::get('inp_txtName'),50);		
        $ddlConSound=Validation::validateString(Input::get('inp_ddlConSound'));
        $ddlMOH=Validation::validateString(Input::get('inp_ddlMOH'));
		$ddlStrategy=Validation::validateString(Input::get('inp_ddlStrategy'));
		$txtMaxwaittime=Validation::validateString(Input::get('inp_txtMaxwaittime'));
		$txtMaxwaitnoagent=Validation::validateString(Input::get('inp_txtMaxwaitnoagent'));
		$txtMaxwaitnoagentriched=Validation::validateString(Input::get('inp_txtMaxwaitnoagentriched'));
        $Tierrulenoagentnowait=Input::get('inp_Tierrulenoagentnowait');        
        $Abandonedresumeallowed=Input::get('inp_Abandonedresumeallowed');
        $txtDiscardabandonedafter=Validation::validateString(Input::get('inp_txtDiscardabandonedafter'));
        $ddlAnnouncesound=Validation::validateString(Input::get('inp_ddlAnnouncesound')); 
		$txtAnnouncefrequency=Validation::validateString(Input::get('inp_txtAnnouncefrequency'));
		$txtMaxlen=Validation::validateString(Input::get('inp_txtMaxlen'));
		
		$ddlSDestination=Validation::validateString(Input::get('grp_ddlSDestination'));
		$ddlSDestValue=Validation::validateString(Input::get('inp_ddlSDestValue'));
		$Smethod=Validation::validateString(Input::get('Smethod'));
		
		$ddlDDestination=Validation::validateString(Input::get('grp_ddlDDestination'));
		$ddlDDestValue=Validation::validateString(Input::get('inp_ddlDDestValue'));
		$Dmethod=Validation::validateString(Input::get('Dmethod'));
		
		$ddlMDestination=Validation::validateString(Input::get('grp_ddlMDestination'));
		$ddlMDestValue=Validation::validateString(Input::get('inp_ddlMDestValue'));
		$Mmethod=Validation::validateString(Input::get('Mmethod'));
		
		$q_id=Input::get('inp_hdID');		
		
		$sql = "select * from tbl_queues where q_name='$txtName'";
		$query = DB::select($sql);
		if(count($query)>0){
			return "نام وارد شده وجود دارد. لطفا از نام دیگری استفاده نمایید";	
		}		
        if (strlen($txtName) > 0){		
            try {              
				if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
					return "خطا در اجرای دستور پاکسازی کش";
				}
				$sql = "Insert Into tbl_queues(q_name,q_startsound,q_mohsound,q_strategy,q_maxwaittime,q_maxwaitnoagent,".
					"q_maxwaitnoagentriched,q_tierrulenoagentnowait,q_abandonedresumeallowed,q_discardabandonedafter,q_announcesound".
					",q_announcefrequency,q_maxlen,q_aftersuccess,q_aftersuccessvalue,q_aftersuccessmethod,q_afterfailed,q_afterfailedvalue".
					",q_afterfailedmethod,q_aftermax,q_aftermaxvalue,q_aftermaxmethod,q_routeid)Values(".
					"'$txtName','$ddlConSound','$ddlMOH','$ddlStrategy','$txtMaxwaittime','$txtMaxwaitnoagent','$txtMaxwaitnoagentriched',".
					"'$Tierrulenoagentnowait','$Abandonedresumeallowed','$txtDiscardabandonedafter','$ddlAnnouncesound','$txtAnnouncefrequency',".
					"'$txtMaxlen','$ddlSDestination','$ddlSDestValue','$Smethod','$ddlDDestination','$ddlDDestValue','$Dmethod','$ddlMDestination',".
					"'$ddlMDestValue','$Mmethod','$q_id')";
				$query = DB::insert($sql);	
				if(GClass::runCommand("reloadxml","+OK [Success]")==1){				
					$response=GClass::runCommand("callcenter_config queue load Queue$q_id@$serverip","+OK");
					if($response==1){
						return "0";
					}
					else{
						return $response;
					}
				}
				else{
					return "درحال حاضر امکان ارتباط با سرور تلفنی وجود ندارد.";
				}
			} catch (Exception $e) {
			    return $e->getMessage();
			}						
		}		
		return "1";
	}
	public static function update_record($item_id){	
		$serverip=config('switch.serverip');
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
        $ddlMOH=Validation::validateString(Input::get('inp_ddlMOH'));
		$ddlStrategy=Validation::validateString(Input::get('inp_ddlStrategy'));
		$txtMaxwaittime=Validation::validateString(Input::get('inp_txtMaxwaittime'));
		$txtMaxwaitnoagent=Validation::validateString(Input::get('inp_txtMaxwaitnoagent'));
		$txtMaxwaitnoagentriched=Validation::validateString(Input::get('inp_txtMaxwaitnoagentriched'));
        $Tierrulenoagentnowait=Input::get('inp_Tierrulenoagentnowait');        
        $Abandonedresumeallowed=Input::get('inp_Abandonedresumeallowed');
        $txtDiscardabandonedafter=Validation::validateString(Input::get('inp_txtDiscardabandonedafter'));
        $ddlAnnouncesound=Validation::validateString(Input::get('inp_ddlAnnouncesound')); 
		$txtAnnouncefrequency=Validation::validateString(Input::get('inp_txtAnnouncefrequency'));
		$txtMaxlen=Validation::validateString(Input::get('inp_txtMaxlen'));
		
		$ddlSDestination=Validation::validateString(Input::get('grp_ddlSDestination'));
		$ddlSDestValue=Validation::validateString(Input::get('inp_ddlSDestValue'));
		$Smethod=Validation::validateString(Input::get('Smethod'));
		
		$ddlDDestination=Validation::validateString(Input::get('grp_ddlDDestination'));
		$ddlDDestValue=Validation::validateString(Input::get('inp_ddlDDestValue'));
		$Dmethod=Validation::validateString(Input::get('Dmethod'));
		
		$ddlMDestination=Validation::validateString(Input::get('grp_ddlMDestination'));
		$ddlMDestValue=Validation::validateString(Input::get('inp_ddlMDestValue'));
		$Mmethod=Validation::validateString(Input::get('Mmethod'));		
		
		$sql = "select * from tbl_queues where q_name='$txtName'";
		$query = DB::select($sql);
		if(count($query)>1){
			return "نام وارد شده وجود دارد. لطفا از نام دیگری استفاده نمایید";	
		}		
        if (strlen($txtName) > 0){		
            try {       
				if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
					return "خطا در اجرای دستور پاکسازی کش";
				}
				$sql = "Update tbl_queues Set q_name='$txtName',q_startsound='$ddlConSound',q_mohsound='$ddlMOH',q_strategy='$ddlStrategy',".
				"q_maxwaittime='$txtMaxwaittime',q_maxwaitnoagent='$txtMaxwaitnoagent',q_maxwaitnoagentriched='$txtMaxwaitnoagentriched',".
				"q_tierrulenoagentnowait='$Tierrulenoagentnowait',q_abandonedresumeallowed='$Abandonedresumeallowed',".
				"q_discardabandonedafter='$txtDiscardabandonedafter',q_announcesound='$ddlAnnouncesound',q_announcefrequency='$txtAnnouncefrequency',".
				"q_maxlen='$txtMaxlen',q_aftersuccess='$ddlSDestination',q_aftersuccessvalue='$ddlSDestValue',q_aftersuccessmethod='$Smethod',".
				"q_afterfailed='$ddlDDestination',q_afterfailedvalue='$ddlDDestValue',q_afterfailedmethod='$Dmethod',q_aftermax='$ddlMDestination',".
				"q_aftermaxvalue='$ddlMDestValue',q_aftermaxmethod='$Mmethod' where q_routeid='$item_id'";
				$query = DB::insert($sql);	
				if(GClass::runCommand("reloadxml","+OK [Success]")==1){				
					$response=GClass::runCommand("callcenter_config queue reload Queue$item_id@$serverip","+OK");
					if($response==1){
						return "0";
					}
					else{
						return $response;
					}
				}
				else{
					return "درحال حاضر امکان ارتباط با سرور تلفنی وجود ندارد.";
				}
			} catch (Exception $e) {
			    return $e->getMessage();
			}
		}
		return "1";		
	}	
	public static function delete_agent($agent_id) {
		$serverip=config('switch.serverip');
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
			return "خطا در اجرای دستور پاکسازی کش";
		}
		$query = DB::table('tbl_queuetiers')->where('t_id', $agent_id)->first();
		$agent=$query->t_useragent;	
		$queue=$query->t_queue;	
		$sql = "Delete from tbl_queuetiers Where t_id='$agent_id'";
		$query = DB::delete($sql);	
		
		if(GClass::runCommand("reloadxml","+OK [Success]")==1){		
			$errString="";			
			$response=GClass::runCommand("callcenter_config tier del Queue$queue@$serverip $agent@$serverip","+OK");
			if($response!=1){						
				$errString.=$response;
			}
			if($errString==""){				
				return "0";
			}
			else
			{				
				return $errString;
			}
		}
		else{
			return "درحال حاضر امکان ارتباط با سرور تلفنی وجود ندارد.";
		}		
	}	
	public static function delete_record($item_id){
		$serverip=config('switch.serverip');
		$errstring="";
		if(Permissions::permissionCheck('23','04')==0)
			return abort(404);
        try {			
			if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
				return "خطا در اجرای دستور پاکسازی کش";
			}
			$sql = "Delete from tbl_queues Where q_routeid='$item_id'";
			$query = DB::delete($sql);						
			if($query<=0){
				return "رکورد با شماره $item_id یافت نشد.";
			}	
			$sql = "Select * From tbl_queuetiers Where t_queue='$item_id'";
			$query = DB::select($sql);
			foreach($query as $rows){
				$response=GClass::runCommand("callcenter_config tier del Queue$t_queue@$serverip ".$rows->t_useragent."@$serverip","+OK");
				if($response!=1)
				{
					$errstring.="مشکل در حذف ردیف صف: ".$response;
				}
			}
			if(GClass::runCommand("reloadxml","+OK [Success]")==1){				
				$response=GClass::runCommand("callcenter_config queue unload Queue".$item_id."@$serverip","+OK");
				if($response==1){
					return "0";
				}
				else{
					return $response;
				}
			}
			else{
				return "درحال حاضر امکان ارتباط با سرور تلفنی وجود ندارد.";
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
	public static function add_new_agent($data){
		$serverip=config('switch.serverip');
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		
        $Agent=Validation::validateString(Input::get('Agent'),50);		        
		$Level=Validation::validateString(Input::get('Level'));
        $Position=Validation::validateString(Input::get('Position'));            
		$Queue=Validation::validateString(Input::get('Queue'));     
		
		$sql = "select * from tbl_queuetiers where t_useragent='$Agent' and t_queue='$Queue'";
		$query = DB::select($sql);
		if(count($query)>0){
			return "اپراتور انتخاب شده قبلا به صف اضافه شده است";	
		}
        if (strlen($Agent) > 0){		
            try {        
				if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
					return "خطا در اجرای دستور پاکسازی کش";
				}
				$sql = "Insert Into tbl_queuetiers(t_useragent,t_level,t_position,t_queue)Values('$Agent','$Level',".
					"'$Position','$Queue')";
				$query = DB::insert($sql);	
				if(GClass::runCommand("reloadxml","+OK [Success]")==1){		
					$errString="";					
					$response=GClass::runCommand("callcenter_config tier add Queue$Queue@$serverip $Agent@$serverip $Level $Position","+OK");
					if($response!=1){						
						$errString.=$response;
					}
					if($errString==""){
						return "0";
					}
					else
					{
						$sql = "Delete from tbl_queuetiers Where t_useragent='$Agent' and t_queue='$Queue'";
						$query = DB::delete($sql);		
						return $errString;
					}
				}
				else{
					return "درحال حاضر امکان ارتباط با سرور تلفنی وجود ندارد.";
				}
			} catch (Exception $e) {
			    return $e->getMessage();
			}						
		}		
		return "1";
	}
}