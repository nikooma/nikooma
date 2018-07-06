<?php

namespace App\Model\Sound;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Validation;
use DB;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\app_code\GClass;
class Sounds extends Model
{    
    public static function get_record_by_id($item_id) {
		$sql = "Select * From tbl_sounds Where \"s_id\"='".$item_id."'";
		$query = DB::select($sql);

		return $query;
	}
    public static function get_records() {
		$sql = "Select * From tbl_sounds order by \"s_id\"";
		$query = DB::select($sql);

		return $query;
	}
	public static function add_new_record($request){			
        $txtName=Validation::validateString(Input::get('inp_txtName'),100);		        
        $file=$request->file('flesound');        		
		$filetype=$file->getClientMimeType();
		if($filetype=="audio/wav")
		{
			if (strlen($txtName) > 0){	
				$filename=rand(10000000,99999999);
				try {
					$uploads=config('switch.uploads');
					$scode=FileManager::UploadNewFile("flesound","$uploads/s_$filename.wav","php",5000000);
					if($scode==0)
					{
						$sql = "Insert Into \"tbl_sounds\"(\"s_name\",\"s_type\",\"s_filename\",\"s_fileaddr\")Values(".
							"'$txtName','$filetype','s_$filename.wav','$uploads/s_$filename.wav')";			
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
	
	public static function delete_record($item_id){
		
        try {
			$query = DB::table('tbl_sounds')->where('s_id', $item_id)->first();
			$filename=$query->s_fileaddr;	
			$code=FileManager::DeleteFile($filename);
			if($code==0){
				$sql = "Delete from tbl_sounds Where \"s_id\"='".$item_id."'";
				$query = DB::delete($sql);
				if($query<=0){
					return "رکورد با شماره ".$item_id." یافت نشد.";
				}
				if(exec("echo 'flush_all' | nc localhost 11211")!="OK"){
					return "خطا در اجرای دستور پاکسازی کش";
				}
			}
			else{
				return "حذف فایل صدا امکان پذیر نمی باشد(کد: $code)";
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return "";
	}
}