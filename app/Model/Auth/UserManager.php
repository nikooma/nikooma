<?php

namespace App\Model\Auth;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
use App\Http\Controllers\resources\manageusers;
use App\Http\Controllers\app_code\Permissions;

class UserManager extends Model
{    
    public static function get_record_by_id($item_id) {		
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From users Where users.id='$item_id'";
		$query = DB::select($sql);
		return $query;
	}
	public static function get_fields_records($fields,$sort,$sorttype) {
        $sql = "select ".$fields." from users order by ".$sort." ".$sorttype;
        $query = DB::select($sql);

        return $query;
    }
	public static function insert_imported_data($value) {
		try {				
			$sip_server=$value->sipserver;								
			$sip_number=$value->sipnumber;
			$username=$value->username;
			$item_id=GClass::get_new_id("users","id");			
			$name=$value->firstname;
			$email=$value->email;
			if($email==null || $email==""){
				return "پست الکترونیک نمی تواند خالی باشد <br />";
			}
			$query = DB::table('tbl_sipservers')->where('s_id', $sip_server)->first();
			if(!is_null($query)){
				$hkey=md5("$sip_number:".$query->s_domain.":123");
				$sql = "select * from users where username='$username' or sip_number='$sip_number' or email='$email'";
				$query = DB::select($sql);
				if(count($query)>0){
					return "اطلاعات تکراری می باشند:username='$username' یا sip_number='$sip_number' یا email='$email'";	
				}	
				User::create([
						'name' => $name,
						'email' => $email,
						'password' => bcrypt("123"),					
					]);	
				$sql = "Update users Set u_timeout='".$value->queuecalltimeout."',u_rejects='".$value->queuemaxrejects."',u_wrapuptime='".$value->queuewrapuptime."',".
					"u_rejecttime='".$value->queuerejectdelaytime."',u_noanswer='".$value->queuenoanswerdelaytime."',u_dnd='".$value->queuednddelaytime.
					"',id='$item_id',u_mobilenumber='".$value->mobilenumber."',u_lname='".$value->lastname."',username='$username',".
					"u_image='../images/avatar.png',sip_number='$sip_number',hkey='$hkey',usercontext='$value->sipserver' Where name='$name' and email='$email'";								
				$query = DB::insert($sql);					
				if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
					return "خطا در اجرای دستور پاکسازی کش";
				}
				return "0";		
			}
			else{
				return "دامین موجود نیست: $username <br />";
			}			
		} catch (Exception $e) {
			return $e->getMessage();
		}
    }	
	public static function get_groups_by_id($item_id) {
		$sql = "Select * From users_group Where user_id='$item_id'";
		$query = DB::select($sql);
		return $query;
	}	
    public static function get_records() {			
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From users order by id";
		$query = DB::select($sql);
		return $query;
	}    
	public static function add_new_record(){		
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		
        $txtName=Validation::validateString(Input::get('inp_txtName'),50);		
        $txtFamily=Validation::validateString(Input::get('inp_txtFamily'));
        $txtUserName=Validation::validateString(Input::get('inp_txtUserName'));		
        $txtPass=Input::get('inp_txtPass');        
        $txtPassRE=Input::get('inp_txtPassRE');
        $txtMobile=Validation::validateString(Input::get('inp_txtMobile'));
        $txteMail=Validation::validateString(Input::get('inp_txteMail')); 		
		$item_id=GClass::get_new_id("users","id");		
		
		$sql = "select * from users where username='$txtUserName' or email='$txteMail'";
		$query = DB::select($sql);
		if(count($query)>0){
			return "نام کاربری، پست الکترونیک و یا تلفن SIP قبلا وجود دارد.";	
		}		
        if (strlen($txtName) > 0 && strlen($txtPass) > 0){		
            try {				
                User::create([
                    'name' => $txtName,
                    'email' => $txteMail,
                    'password' => bcrypt($txtPass),					
                ]);							
				$sql = "Update users Set id='$item_id',u_mobilenumber='$txtMobile',u_lname='$txtFamily',username='$txtUserName',".
					"u_image='../images/avatar.png' Where name='$txtName' and email='$txteMail'";
				$query = DB::insert($sql);								
                if(!is_dir("userprofile/user$item_id"))
                    $result = FileManager::makeDirectory("userprofile/user$item_id");
				$groups=Input::get('groups'); 
				if(!empty($groups)){
					try {						
						$sql = "Delete From users_group Where user_id='$item_id'";
						$query = DB::delete($sql);							
					} catch (Exception $e) {
						return $e->getMessage();
					}
					foreach($groups as $group){
						try {			
							$uig_id=GClass::get_new_id("users_group","id");
							$sql = "Insert Into users_group(user_id,group_id,id)Values($item_id,$group,$uig_id)";
							$query = DB::insert($sql);	
						} catch (Exception $e) {
							return $e->getMessage();
						}
					}
				}				
			} catch (Exception $e) {
			    return $e->getMessage();
			}			
			return "0";			
		}		
		return "1";
	}
	public static function update_record($item_id){	
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		
        $txtName=Validation::validateString(Input::get('inp_txtName'),50);		
        $txtFamily=Validation::validateString(Input::get('inp_txtFamily'));
        $txtUserName=Validation::validateString(Input::get('inp_txtUserName'));		
        $txtPass=Input::get('inp_txtPass');        
        $txtPassRE=Input::get('inp_txtPassRE');
        $txtMobile=Validation::validateString(Input::get('inp_txtMobile'));
        $txteMail=Validation::validateString(Input::get('inp_txteMail')); 		
		$item_id=GClass::get_new_id("users","id");		
		
        if (strlen($txtName) > 0 && strlen($txtPass) > 0){		
            try {				                				
				$sql = "Update users Set id='$item_id',u_mobilenumber='$txtMobile',u_lname='$txtFamily',username='$txtUserName',".
					"u_image='../images/avatar.png' Where name='$txtName' and email='$txteMail'";
				$query = DB::insert($sql);								
                if(!is_dir("userprofile/user$item_id"))
                    $result = FileManager::makeDirectory("userprofile/user$item_id");
				$groups=Input::get('groups'); 
				if(!empty($groups)){
					try {						
						$sql = "Delete From users_group Where user_id='$item_id'";
						$query = DB::delete($sql);							
					} catch (Exception $e) {
						return $e->getMessage();
					}
					foreach($groups as $group){
						try {			
							$uig_id=GClass::get_new_id("users_group","id");
							$sql = "Insert Into users_group(user_id,group_id,id)Values($item_id,$group,$uig_id)";
							$query = DB::insert($sql);	
						} catch (Exception $e) {
							return $e->getMessage();
						}
					}
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
			if($item_id=="1") 
				return "شما نمی توانید کاربر مدیر سیستم را حذف کنید!";					
			$sql = "Delete from users Where id='$item_id'";
			$query = DB::delete($sql);			
			if($query<=0){
				return "رکورد با شماره $item_id یافت نشد.";
			}
			else{
				$sql = "Delete From users_group Where user_id='$item_id'";
				$query = DB::delete($sql);							
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
}