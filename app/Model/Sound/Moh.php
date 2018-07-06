<?php

namespace App\Model\Sound;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
class Moh extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_moh Where \"m_id\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
    public static function get_records() {
		$sql = "Select * From tbl_moh order by \"m_id\"";
		$query = DB::select($sql);

		return $query;
	}
	public static function get_sound_list($item_id) {
		$sql = "Select * From tbl_mohsounds Where ms_moh='$item_id' order by \"ms_id\" desc";
		$query = DB::select($sql);
		return $query;
	}
	public static function save_sounds($request){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		
		$item_id=Validation::validateString(Input::get('inp_hdID'),100);	
        $file=$request->file('flesound');        		
		$filetype=$file->getClientMimeType();
		echo $filetype;
		if($filetype=="audio/wav" || $filetype=="application/octet-stream")
		{
			if (strlen($txtName) > 0){	
				$filename=rand(10000000,99999999);
				try {
					$uploads=config('switch.moh');
					$fileaddress="$uploads/MOH_".$item_id."/$filename.wav";
					if (!file_exists("$uploads/MOH_".$item_id)) {
						mkdir("$uploads/MOH_".$item_id, 0777);
					}
					$scode=FileManager::UploadNewFile("flesound","$fileaddress","php",10000000);
					if($scode==0)
					{
						$sql = "Insert Into \"tbl_mohsounds\"(\"ms_moh\",\"ms_file\",\"ms_name\")Values(".
							"'$item_id','$fileaddress','$txtName')";			
						$query = DB::insert($sql); 
						if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
							return "خطا در اجرای دستور پاکسازی کش";
						}
					}
					else{
						return "امکان ذخیره سازی فایل وجود ندارد. لطفا با مدیر سیستم تماس بگیرید(کد:".$scode.")";
					}
				} catch (Exception $e) {
					return $e->getMessage();
				}
				return "0";
			}
		}
		else{
			return "فرمت صدا نادرس است. لطفا از صدا با فرمت wav استفاده نمایید.";
		}
		return "1";
	}
	public static function add_new_record($request){
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);
		$txtRate=Validation::validateString(Input::get('inp_txtRate'),100);
		$playshuffle=Validation::validateString(Input::get('inp_playshuffle'),100);
		$txtChannels=Validation::validateString(Input::get('inp_txtChannels'),100);
		$txtInterval=Validation::validateString(Input::get('inp_txtInterval'),100);
		if($txtInterval<20 || $txtInterval>120)
			return "زمان پخش هر صدا باید بین 20 تا 120 ثانیه باشد.";
		$mohid=GClass::get_new_id("tbl_moh","m_id");
		if (strlen($txtName) > 0){
			try {
				$foldername="MOH_$mohid";
				$sql = "Insert Into \"tbl_moh\"(\"m_name\",\"m_directory\",\"m_rate\",\"m_shuffle\",\"m_channels\",\"m_interval\",\"m_id\")Values(".
					"'$txtName','$foldername','$txtRate','$playshuffle','$txtChannels','$txtInterval','$mohid')";			
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
		$txtRate=Validation::validateString(Input::get('inp_txtRate'),100);
		$playshuffle=Validation::validateString(Input::get('inp_playshuffle'),100);
		$txtChannels=Validation::validateString(Input::get('inp_txtChannels'),100);
		$txtInterval=Validation::validateString(Input::get('inp_txtInterval'),100);
		
        if (strlen($txtName) > 0){
			try {
				$sql = "Update \"tbl_moh\" Set \"m_name\"='$txtName',\"m_rate\"='$txtRate',".
					"\"m_shuffle\"='$playshuffle',\"m_channels\"='$txtChannels',\"m_interval\"='$txtInterval' where \"m_id\"='$item_id'";

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
			$query = DB::table('tbl_moh')->where('m_id', $item_id)->first();
			$foldername=$query->m_directory;
			$mohid=$query->m_id;
			$mohpath=config('switch.moh');
			FileManager::delDirectory("$mohpath/$foldername");
			$sql = "Delete from tbl_mohsounds Where \"ms_moh\"='$mohid'";
			$query = DB::delete($sql);
			$sql = "Delete from tbl_moh Where \"m_id\"='".$item_id."'";
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