<?php

namespace App\Model\Manage;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
use App\Http\Controllers\app_code\Permissions;

class khayer extends Model
{    
    public static function get_record_by_id($item_id) {		
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tbl_niazmandan Where n_id='$item_id'";
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
		$sql = "Select * From tbl_niazgroups Where ng_niazmand='$item_id'";
		$query = DB::select($sql);
		return $query;
	}	
    public static function get_records() {			
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tbl_khayer order by kh_id";
		$query = DB::select($sql);
		return $query;
	}   
	
	public static function add_new_record(){		
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		        
        $txtName=Validation::validateString(Input::get('inp_txtName'));
        $txtFamily=Validation::validateString(Input::get('inp_txtFamily'));		        
		$ddlJensiat=Input::get('inp_ddlJensiat');     	
		$txtTel=Input::get('inp_txtTel');     	
		$txtShoghl=Input::get('inp_txtShoghl');     	
		$txtAddress=Input::get('inp_txtAddress'); 		
		$item_id=GClass::get_new_id("tbl_khayer","kh_id");
					
        if (strlen($txtName) > 0 && strlen($txtFamily) > 0){		
            try {				                				
				$sql = "INSERT INTO tbl_khayer(kh_id, kh_name, kh_family, kh_jensiat, kh_mobile, kh_shoghl, kh_address) VALUES ".
				"('$item_id','$txtName','$txtFamily','$ddlJensiat','$txtTel','$txtShoghl','$txtAddress')";
				$query = DB::insert($sql);								                
				$groups=Input::get('groups'); 
				if(!empty($groups)){
					try {						
						$sql = "Delete From tbl_khayergroup Where kg_khayerid='$item_id'";
						$query = DB::delete($sql);							
					} catch (Exception $e) {
						return $e->getMessage();
					}
					foreach($groups as $group){
						try {			
							$sql = "Insert Into tbl_khayergroup(kg_khayerid,kg_groupid)Values($item_id,$group)";
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
		        
        $txtName=Validation::validateString(Input::get('inp_txtName'));
        $txtFamily=Validation::validateString(Input::get('inp_txtFamily'));		        
		$ddlJensiat=Input::get('inp_ddlJensiat');     	
		$txtTel=Input::get('inp_txtTel');     	
		$txtShoghl=Input::get('inp_txtShoghl');     	
		$txtAddress=Input::get('inp_txtAddress'); 		
					
        if (strlen($txtName) > 0 && strlen($txtFamily) > 0){		
            try {				                				
				$sql = "UPDATE tbl_khayer Set kh_name='$txtName', kh_family='$txtFamily', kh_jensiat='$ddlJensiat', ".
					"kh_mobile='$txtTel', kh_shoghl='$txtShoghl', kh_address='$txtAddress' WHERE kh_id='$item_id'";
				$query = DB::insert($sql);								                
				$groups=Input::get('groups'); 
				if(!empty($groups)){
					try {						
						$sql = "Delete From tbl_khayergroup Where kg_khayerid='$item_id'";
						$query = DB::delete($sql);							
					} catch (Exception $e) {
						return $e->getMessage();
					}
					foreach($groups as $group){
						try {			
							$sql = "Insert Into tbl_khayergroup(kg_khayerid,kg_groupid)Values($item_id,$group)";
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
			$sql = "Delete from tbl_khayer Where kh_id='$item_id'";
			$query = DB::delete($sql);			
			if($query<=0){
				return "رکورد با شماره $item_id یافت نشد.";
			}
			else{
				$sql = "Delete From tbl_khayergroup Where kg_khayerid='$item_id'";
				$query = DB::delete($sql);							
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
	
}