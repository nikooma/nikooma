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

class niazmandan extends Model
{    
    public static function get_record_by_id($item_id) {		
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tbl_niazmandan Where n_id='$item_id'";
		$query = DB::select($sql);
		return $query;
	}
	public static function get_takafol_by_id($item_id) {		
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tb_niazmandtakafol Where nt_id ='$item_id'";
		$query = DB::select($sql);
		return $query;
	}
	public static function get_takafol($item_id) {		
		if(Permissions::permissionCheck('23','01')==0)
			return abort(404);
		$sql = "Select * From tb_niazmandtakafol Where nt_codesarparast ='$item_id'";
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
		$sql = "Select * From tbl_niazmandan order by n_id";
		$query = DB::select($sql);
		return $query;
	}   
	public static function add_new_takafol_record($par_id){		
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		
        $txtMeli=Validation::validateString(Input::get('inp_txtMeli'),50);		
        $txtName=Validation::validateString(Input::get('inp_txtName'));
        $txtFamily=Validation::validateString(Input::get('inp_txtFamily'));		
        $txtPedar=Input::get('inp_txtPedar');                
        $txtTTavalod=Validation::validateString(Input::get('inp_txtTTavalod'));        
		$txtShoghl=Input::get('inp_txtShoghl');      
		$ddlDaramad=Input::get('inp_ddlDaramad');      
		$ddlBimeh=Input::get('inp_ddlBimeh');      
		$ddlTahsilat=Input::get('inp_ddlTahsilat');
		$txtMahalTahsil=Input::get('inp_txtMahalTahsil'); 
		$txtMaharat=Input::get('inp_txtMaharat');      
		$txtYaraneh=Input::get('inp_txtYaraneh');           
		$ddlHamsar=Input::get('inp_ddlHamsar');           		
		$txtDoreAmoozeshi=Input::get('inp_txtDoreAmoozeshi');     
		$txtSepordeh=Input::get('inp_txtSepordeh');
		$txtJesmani=Input::get('inp_txtJesmani');        		
		$item_id=GClass::get_new_id("tb_niazmandtakafol","nt_id");		
		$ddlJensiat=Input::get('inp_ddlJensiat'); 
		
		$sql = "select * from tbl_niazmandan where n_meli='$txtMeli'";
		$query = DB::select($sql);
		if(count($query)>0){
			return "شخص با کد ملی وارد شده قبلا در سیستم ثبت شده است.";	
		}		
        if (strlen($txtName) > 0 && strlen($txtMeli) > 0){		
            try {				                				
				$sql = "INSERT INTO tb_niazmandtakafol(nt_id, nt_name, nt_family, nt_pedar, nt_meli, nt_tavalod, ".
				"nt_shoghl, nt_daramad, nt_bimeh, nt_tahsil, nt_maharat, nt_yaraneh, nt_taahol,".
				"nt_jesmani,nt_jensiat,nt_codesarparast) VALUES ".
				"('$item_id','$txtName','$txtFamily','$txtPedar','$txtMeli','$txtTTavalod','$txtShoghl'".
				",'$ddlDaramad','$ddlBimeh','$ddlTahsilat','$txtMaharat','$txtYaraneh','$ddlHamsar'".
				",'$txtJesmani','$ddlJensiat','$par_id')";
				$query = DB::insert($sql);								                
				$groups=Input::get('groups'); 
				if(!empty($groups)){
					try {						
						$sql = "Delete From tbl_niazgroups Where ng_niazmand='$item_id'";
						$query = DB::delete($sql);							
					} catch (Exception $e) {
						return $e->getMessage();
					}
					foreach($groups as $group){
						try {			
							$sql = "Insert Into tbl_niazgroups(ng_niazmand,ng_group)Values($item_id,$group)";
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
	
	
	
	public static function add_new_record(){		
		if(Permissions::permissionCheck('23','05')==0)
			return abort(404);		
		
        $txtMeli=Validation::validateString(Input::get('inp_txtMeli'),50);		
        $txtName=Validation::validateString(Input::get('inp_txtName'));
        $txtFamily=Validation::validateString(Input::get('inp_txtFamily'));		
        $txtPedar=Input::get('inp_txtPedar');        
        $txtShenasnameh=Input::get('inp_txtShenasnameh');
        $txtTTavalod=Validation::validateString(Input::get('inp_txtTTavalod'));
        $txtMTavalod=Validation::validateString(Input::get('inp_txtMTavalod')); 	
		$txtShoghl=Input::get('inp_txtShoghl');      
		$ddlDaramad=Input::get('inp_ddlDaramad');      
		$ddlBimeh=Input::get('inp_ddlBimeh');      
		$ddlTahsilat=Input::get('inp_ddlTahsilat');      
		$txtMaharat=Input::get('inp_txtMaharat');      
		$txtYaraneh=Input::get('inp_txtYaraneh');      
		$ddlTahsilat=Input::get('inp_ddlTahsilat');      
		$ddlHamsar=Input::get('inp_ddlHamsar');      
		$txtMeliHamsar=Input::get('inp_txtMeliHamsar');      
		$txtShoghlHamsar=Input::get('inp_txtShoghlHamsar');      
		$ddlManzel=Input::get('inp_ddlManzel');      
		$txtAddressManzel=Input::get('inp_txtAddressManzel');      
		$txtPosti=Input::get('inp_txtPosti');      
		$txtTelManzel=Input::get('inp_txtTelManzel');      
		$txtTelHamrah=Input::get('inp_txtTelHamrah');      
		$txtElateNiaz=Input::get('inp_txtElateNiaz');      
		$txtJesmani=Input::get('inp_txtJesmani');      
		$ddlJensiat=Input::get('inp_ddlJensiat');     		
		$item_id=GClass::get_new_id("tbl_niazmandan","n_id");		

		
		$sql = "select * from tbl_niazmandan where n_meli='$txtMeli'";
		$query = DB::select($sql);
		if(count($query)>0){
			return "شخص با کد ملی وارد شده قبلا در سیستم ثبت شده است.";	
		}		
        if (strlen($txtName) > 0 && strlen($txtMeli) > 0){		
            try {				                				
				$sql = "INSERT INTO tbl_niazmandan(n_id, n_name, n_family, n_pedar, n_shenasnameh, n_meli, n_tarikhtavalod, ".
				"n_mahaltavalod, n_shoghl, n_daramad, n_bimeh, n_mizantahsilat, n_maharat, n_yaraneh, n_hamsar, n_melihamsar, ".
				"n_shoghlhamsar, n_noemanzel, n_addressmanzel, n_codeposti, n_telephone, n_mobile, n_elateniaz, n_vaziatejesmani,n_jensiat) VALUES ".
				"('$item_id','$txtName','$txtFamily','$txtPedar','$txtShenasnameh','$txtMeli','$txtTTavalod','$txtMTavalod','$txtShoghl'".
				",'$ddlDaramad','$ddlBimeh','$ddlTahsilat','$txtMaharat','$txtYaraneh','$ddlHamsar','$txtMeliHamsar','$txtShoghlHamsar'".
				",'$ddlManzel','$txtAddressManzel','$txtPosti','$txtTelManzel','$txtTelHamrah','$txtElateNiaz','$txtJesmani','$ddlJensiat')";
				$query = DB::insert($sql);								                
				$groups=Input::get('groups'); 
				if(!empty($groups)){
					try {						
						$sql = "Delete From tbl_niazgroups Where ng_niazmand='$item_id'";
						$query = DB::delete($sql);							
					} catch (Exception $e) {
						return $e->getMessage();
					}
					foreach($groups as $group){
						try {			
							$sql = "Insert Into tbl_niazgroups(ng_niazmand,ng_group)Values($item_id,$group)";
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
		
        $txtMeli=Validation::validateString(Input::get('inp_txtMeli'),50);		
        $txtName=Validation::validateString(Input::get('inp_txtName'));
        $txtFamily=Validation::validateString(Input::get('inp_txtFamily'));		
        $txtPedar=Input::get('inp_txtPedar');        
        $txtShenasnameh=Input::get('inp_txtShenasnameh');
        $txtTTavalod=Validation::validateString(Input::get('inp_txtTTavalod'));
        $txtMTavalod=Validation::validateString(Input::get('inp_txtMTavalod')); 	
		$txtShoghl=Input::get('inp_txtShoghl');      
		$ddlDaramad=Input::get('inp_ddlDaramad');      
		$ddlBimeh=Input::get('inp_ddlBimeh');      
		$ddlTahsilat=Input::get('inp_ddlTahsilat');      
		$txtMaharat=Input::get('inp_txtMaharat');      
		$txtYaraneh=Input::get('inp_txtYaraneh');      
		$ddlTahsilat=Input::get('inp_ddlTahsilat');      
		$ddlHamsar=Input::get('inp_ddlHamsar');      
		$txtMeliHamsar=Input::get('inp_txtMeliHamsar');      
		$txtShoghlHamsar=Input::get('inp_txtShoghlHamsar');      
		$ddlManzel=Input::get('inp_ddlManzel');      
		$txtAddressManzel=Input::get('inp_txtAddressManzel');      
		$txtPosti=Input::get('inp_txtPosti');      
		$txtTelManzel=Input::get('inp_txtTelManzel');      
		$txtTelHamrah=Input::get('inp_txtTelHamrah');      
		$txtElateNiaz=Input::get('inp_txtElateNiaz');      
		$txtJesmani=Input::get('inp_txtJesmani');         	
		$ddlJensiat=Input::get('inp_ddlJensiat');     	
        if (strlen($txtName) > 0 && strlen($txtMeli) > 0){		
            try {				                				
				$sql = "UPDATE tbl_niazmandan set n_name='$txtName', n_family='$txtFamily', n_pedar='$txtPedar', n_shenasnameh='$txtShenasnameh',".
				"n_meli='$txtMeli', n_tarikhtavalod='$txtTTavalod', n_mahaltavalod='$txtMTavalod', n_shoghl='$txtShoghl', n_daramad='$ddlDaramad',".
				"n_bimeh='$ddlBimeh', n_mizantahsilat='$ddlTahsilat', n_maharat='$txtMaharat', n_yaraneh='$txtYaraneh', n_hamsar='$ddlHamsar',".
				"n_melihamsar='$txtMeliHamsar', n_shoghlhamsar='$txtShoghlHamsar', n_noemanzel='$ddlManzel', n_addressmanzel='$txtAddressManzel',".
				"n_codeposti='$txtPosti', n_telephone='$txtTelManzel', n_mobile='$txtTelHamrah', n_elateniaz='$txtElateNiaz', ".
				"n_vaziatejesmani='$txtJesmani',n_jensiat='$ddlJensiat' WHERE n_id='$item_id'";
				$query = DB::insert($sql);								                
				$groups=Input::get('groups'); 
				if(!empty($groups)){
					try {						
						$sql = "Delete From tbl_niazgroups Where ng_niazmand='$item_id'";
						$query = DB::delete($sql);							
					} catch (Exception $e) {
						return $e->getMessage();
					}
					foreach($groups as $group){
						try {			
							$sql = "Insert Into tbl_niazgroups(ng_niazmand,ng_group)Values($item_id,$group)";
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
			$sql = "Delete from tbl_niazmandan Where n_id='$item_id'";
			$query = DB::delete($sql);			
			if($query<=0){
				return "رکورد با شماره $item_id یافت نشد.";
			}
			else{
				$sql = "Delete From tbl_niazgroups Where ng_niazmand='$item_id'";
				$query = DB::delete($sql);							
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
	public static function delete_takafol_record($item_id){		
		if(Permissions::permissionCheck('23','04')==0)
			return abort(404);
        try {						
			$sql = "Delete from tb_niazmandtakafol Where nt_id='$item_id'";
			$query = DB::delete($sql);			
			if($query<=0){
				return "رکورد با شماره $item_id یافت نشد.";
			}			
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
}