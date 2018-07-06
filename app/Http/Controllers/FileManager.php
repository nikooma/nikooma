<?php

namespace App\Http\Controllers;

class FileManager extends Controller
{
    public static function makeDirectory($path, $mode = 0777, $recursive = false, $force = false)
    {
    	if(!file_exists($path)) {
	        if ($force)
	        {
	            return @mkdir($path, $mode, $recursive);
	        }
	        else
	        {
	            return mkdir($path, $mode, $recursive);
	        }
    	}
    }
	public static function delDirectory($dir)
    {
    	 if (is_dir($dir)) { 
		 $objects = scandir($dir); 
		 foreach ($objects as $object) { 
		   if ($object != "." && $object != "..") { 
			 if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
		   } 
		 } 
		 reset($objects); 
		 rmdir($dir); 
	   } 
    }
	public static function DeleteFile($filename){
		if(file_exists($filename)){
			unlink($filename);
			if (file_exists($filename)) {
				return 100;
			}
			return 0;
		} 
		else {
			return 500;
		}
	}
	public static function UploadNewFile($upname,$filePath,$extBlock,$maxsize){		
		$target_file = $filePath;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$uploadOk = 1;			
		}
		else{
			return "400";
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			return "500";//file exist or no file exist
		}
		// Check file size
		if ($_FILES[$upname]["size"] > $maxsize) {
			return "300"; //file is too long
		}
		// Allow certain file formats
		if(strpos($extBlock, $imageFileType) !== false){
			return "700"; //blocked content
		}
		if (move_uploaded_file($_FILES[$upname]["tmp_name"], $target_file)) {
			return 0;
		} else {
			return "200";
		}		
	}
}
