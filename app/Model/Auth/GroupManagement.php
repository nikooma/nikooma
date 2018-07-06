<?php

namespace App\Model\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Setting;
use DB;

class GroupManagement extends Model
{      
    public static function get_panels() {		
		$query=config('permissions.panels');
		return $query;
	}    
	public static function get_pviews() {		
		$query=config('permissions.views');
		return $query;
	}  
	public static function get_permissions($group_id) {		
		$query = DB::table('dastrasi')->where('grup_id', $group_id)->first();
		if(!is_null($query))
			return $query->dastrasi;	
		else 
			return "";
	} 
	public static function add_new_record($group_id,$access_id){			
		$query = DB::table('dastrasi')->where('grup_id', $group_id)->first();
		$accrole='';
		if(!is_null($query)){
			$accrole=$query->dastrasi;
		}		
		$roles=explode("_",$access_id);				
		if(sizeof($roles)==2){
			$role=$roles[0];
			$access=$roles[1];			
			if($access=="ALLOW"){					
				if(strpos($accrole,";$role;")==""){
					$accrole=rtrim($accrole,";").";$role;";
				}
			}
			elseif($access=="DALLOW"){
				if(strpos($accrole,";$role;")!=""){
					$accrole=str_replace("$role;","",$accrole);
					if(substr($accrole,strlen($accrole)-1)!=";"){
						$accrole.=";";
					}
				}
			}
			if(is_null($query)){
				try {						
					$sql = "Insert Into dastrasi(grup_id,dastrasi)Values('$group_id','$accrole')";
					$query = DB::insert($sql);	
				} catch (Exception $e) {
					return $e->getMessage();
				}				
			}
			else{
				try {						
					$sql = "Update dastrasi set dastrasi='$accrole' where grup_id='$group_id'";
					$query = DB::insert($sql);	
				} catch (Exception $e) {
					return $e->getMessage();
				}	
			}	
			return 0;
		}
		return 1;
	}
	
}