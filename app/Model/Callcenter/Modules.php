<?php

namespace App\Model\Callcenter;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
use Zipper;

class Modules extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_modules Where \"m_id\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
	public static function get_status_by_id($item_id) {
		$query = DB::table('tbl_modules')->where('m_id', $item_id)->first();
		return $query->enabled_t3245;
	}
	public static function get_desval_by_id($item_id) {
		$sql = "Select * From tbl_modulesvalue Where \"mv_module\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
	public static function update_status_by_id($status,$item_id) {
		$sql = "Update tbl_modules Set enabled_t3245='$status' Where m_id='$item_id'";
		$query = DB::insert($sql);
		if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
			return "خطا در اجرای دستور پاکسازی کش";
		}
	}
    public static function get_records() {
		$sql = "Select * From tbl_modules order by \"m_id\"";
		$query = DB::select($sql);

		return $query;
	}
	public static function get_en_records() {
		$sql = "Select * From tbl_modules where enabled_t3245='1' order by \"m_id\"";
		$query = DB::select($sql);

		return $query;
	}
	public static function add_new_actions($request){			
        $actions=Input::get('modactions');		                
		$inp_hdID=Validation::validateString(Input::get("inp_hdID"));    
		if (sizeof($actions) > 0){		
            try {      
				$sql = "Delete from tbl_modulesvalue Where \"mv_module\"='$inp_hdID'";
				$query = DB::delete($sql);
				foreach($actions as $acts){
					$act=explode(",",$acts);					
					$paramval=$act[0];
					$action=$act[1];
					$actionvalue=$act[2];
					$method=$act[3];
					$sql = "Insert Into tbl_modulesvalue(mv_module,mv_value,mv_dest,mv_destvalue,mv_destmethod)Values(".
						"'$inp_hdID','$paramval','$action','$actionvalue','$method')";
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
	}
	public static function add_new_record($request){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		        
        $file=$request->file('flemodule');        		
		$filetype=$file->getClientMimeType();
		$item_id=GClass::get_new_id("tbl_modules","m_id");    
		if($filetype=="application/x-zip-compressed")
		{
			if (strlen($txtName) > 0){
				$filename=rand(10000000,99999999);
				//try {
					$pmodules=config('switch.modules');
					$tmpfile="$pmodules/$filename.zip";
					if (!file_exists("$pmodules/")) {
						mkdir("$pmodules/", 0777, true);
					}					
					$scode=FileManager::UploadNewFile("flemodule",$tmpfile,"php",5000000);					
					if($scode==0)
					{		
						Zipper::make("$tmpfile")->extractTo("modules/$filename");			
					    unlink($tmpfile);
						$installpack="$pmodules/$filename/install.lua";
						$uninstallpack="$pmodules/$filename/uninstall.lua";
						$modoulepack="$pmodules/$filename/module.lua";
						$fileright=1;
						if (!file_exists($installpack)) {
							$fileright=0;
						}
						if (!file_exists($uninstallpack)) {
							$fileright=0;
						}
						if (!file_exists($modoulepack)) {
							$fileright=0;
						}						
						if($fileright==0){
							$rmpath="$pmodules/$filename";							
							exec("rm -rf $rmpath");
							return "فایل انتخاب شده نامعتبر می باشد.";
						}
						$resault=GClass::runCommand("luarun $pmodules/$filename/install.lua $item_id ".str_replace(" ","%32",$txtName)." $filename","+OK");
						sleep(2);
					}
					else{
						return "امکان ذخیره سازی فایل وجود ندارد. لطفا با مدیر سیستم تماس بگیرید(کد:".$scode.")";
					}
				/*} catch (Exception $e) {
					return $e->getMessage();
				}*/
				return "0";
			}
		}
		else{
			return "فرمت صدا نادرس است. لطفا از صدا با فرمت wav استفاده نمایید.";
		}
		return "1";
	}	
	
	public static function delete_record($item_id){
		
        try {
			$query = DB::table('tbl_modules')->where('m_id', $item_id)->first();
			$filename=$query->m_filename;	
			$pmodules=config('switch.modules');
			echo("$pmodules/$filename");
			FileManager::delDirectory("$pmodules/$filename");
			$sql = "Delete from tbl_modulesvalue Where \"mv_module\"='$item_id'";
			$query = DB::delete($sql);
			$sql = "Delete from tbl_modules Where \"m_id\"='$item_id'";
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