<?php

namespace App\Http\Controllers\app_code;

date_default_timezone_set('Iran');

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\Auth\UserManager;
use App\Model\Callcenter\Ivr;
use App\Model\Callcenter\Queue;
use App\Model\Callcenter\Modules;
use App\Model\Callcenter\Outcalls;
use App\Model\Callcenter\Outbound;
use App\Model\Sound\Sounds;
use Session;

class GClass extends Controller
{
    //
	public static function get_new_id($tablename,$itemname) {
		$sql = "Select max(".$itemname.") as maxid From ".$tablename;
		$query = DB::select($sql);
		$newid=0;
		foreach ($query as $item){
			$newid = $item->maxid;
		}		
		$newid++;
		return $newid;
	}
	public static function faTOen($string) {
	    return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
	}
	public static function enTOfa($string) {
	    return strtr($string, array('0'=>'۰', '1'=>'۱', '2'=>'۲', '3'=>'۳', '4'=>'۴', '5'=>'۵', '6'=>'۶', '7'=>'۷', '8'=>'۸', '9'=>'۹'));
	}
	public static function getDestinationValue($destId) {
	    switch($destId){
			case "1":
				
			break;
		}
	}
	
	public static function execAPI($fspath,$command,$success)
	{
		$execomm=$fspath."/bin/fs_cli -x \"".$command."\" 2>&1";
		exec($execomm, $output, $return);
		$result=implode(" ",$output);
		if(strpos($result,$success)===0)
			return 1;
		else
			return 0;		
	}
	public static function initDestinations($destination,$context)
	{
		$destValue='';
		switch($destination){
			case 'toagent':
				$responsestring='';
				if($context=='0'){
					$datalist=UserManager::get_records();
				}
				else{
					$datalist=UserManager::get_record_by_context($context);
				}
				$responsestring='[';
				foreach ($datalist as $item){
					$responsestring.='{"item_id":"'.$item->sip_number.'",';
					$responsestring.='"item_value":"'.$item->name.' '.$item->u_lname.'('.$item->sip_number.')"},';			
				}	
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			case 'toivr':
				$responsestring='';
				if($context=='0'){
					$datalist=Ivr::get_records();
				}
				else{
					$datalist=Ivr::get_records();
				}
				$responsestring='[';
				foreach ($datalist as $item){
					$responsestring.='{"item_id":"'.$item->i_id.'",';
					$responsestring.='"item_value":"'.$item->i_name.'"},';			
				}	
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			case 'toqueue':
				$responsestring='';
				if($context=='0'){
					$datalist=Queue::get_records();
				}
				else{
					$datalist=Queue::get_records();
				}
				$responsestring='[';
				foreach ($datalist as $item){
					$responsestring.='{"item_id":"'.$item->q_routeid.'",';
					$responsestring.='"item_value":"'.$item->q_name.'"},';			
				}	
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			case 'tomodule':
				$responsestring='';
				if($context=='0'){
					$datalist=Modules::get_en_records();
				}
				else{
					$datalist=Modules::get_en_records();
				}
				$responsestring='[';
				foreach ($datalist as $item){
					$responsestring.='{"item_id":"'.$item->m_id.'",';
					$responsestring.='"item_value":"'.$item->m_name.'"},';			
				}	
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			case 'tooutcall':
				$responsestring='';
				if($context=='0'){
					$datalist=Outcalls::get_records();
				}
				else{
					$datalist=Outcalls::get_records();
				}
				$responsestring='[';
				foreach ($datalist as $item){
					$responsestring.='{"item_id":"'.$item->oc_id.'",';
					$responsestring.='"item_value":"'.$item->oc_name.'"},';			
				}	
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			case 'totrunk':
				$responsestring='';
				if($context=='0'){
					$datalist=Outbound::get_records();
				}
				else{
					$datalist=Outbound::get_records();
				}
				$responsestring='[';
				foreach ($datalist as $item){
					$responsestring.='{"item_id":"'.$item->o_id.'",';
					$responsestring.='"item_value":"'.$item->o_name.'"},';			
				}	
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			case 'playsound':
				$responsestring='';
				if($context=='0'){
					$datalist=Sounds::get_records();
				}
				else{
					$datalist=Sounds::get_records();
				}
				$responsestring='[';
				foreach ($datalist as $item){
					$responsestring.='{"item_id":"'.$item->s_fileaddr.'",';
					$responsestring.='"item_value":"'.$item->s_name.'"},';			
				}	
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			case 'hangup':
				$responsestring='';				
				$responsestring='[';				
					$responsestring.='{"item_id":"0",';
					$responsestring.='"item_value":"قطع تماس"},';						
				$responsestring=rtrim($responsestring,",")."]";
				return $responsestring;
			default:
				return '[]';
		}		
	}	
	public static function getDestinationName($destination)
	{		
		switch($destination){
			case 'toagent':				
				return "اتصال به کاربر";
			case 'toivr':				
				return "به منشی دیجیتال";
			case 'toqueue':
				return "به صف انتظار";
			case 'tomodule':
				return "به ماژول ها";
			case 'tooutcall':
				return "به تماس خارجی";
			case 'totrunk':
				return "به مسیر خروجی";
			case 'playsound':
				return "پخش صدا";
			case 'hangup':
				return "قطع تماس";
			default:
				return '[]';
		}		
	}	
	public static function encryptStringE($str,$code){
		// character table
		$chars='1234567890!@#$%^&*()qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM ,<.>/?;:"[{]}\|`~';
		// new code begin
		$newcode="";
		// we start
		for($i=1;$i<=999;$i++){
			if(substr($str,$i,$i) == ""){
				break;
			}
			else{
				$com=substr($str,$i,$i);
			}
			for($x=1;$x<=90;$x++){
				$cur=substr($chars,$x,$x);
				if($com == $cur){
					$newc=$x+$code;
					while($newc > 90){
						$newc -= 90;	
					}						
					$newcode="".$newcode."".substr($chars,$newc,$newc)."";
				}
			}
		}		
		return $newcode;
	}
	
	public static function unencryptString($str,$code){
		// character table
		$chars='1234567890!@#$%^&*()qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM ,<.>/?;:"[{]}\|`~';
		// new code begin
		$newcode="";
		// we start
		for($i=1;$i<=999;$i++){
			if(substr($str,$i,$i) == ""){
				break;
			}
			else{
				$com=substr($str,$i,$i);
			}
			for($x=1;$x<=90;$x++){
				$cur=substr($chars,$x,$x);
				if($com == $cur){
					$newc=$x-$code;
					while($newc < 0){
						$newc += 90;
					}
					$newcode="".$newcode."".substr($chars,$newc,$newc)."";
				}
			}
		}
		return $newcode;
	}
	
	public function get_destinations(Request $request){
        if($request->ajax()) {
            $error_warning='';
            $data = $request->all();
            $itoken = $data['_token'];
            $item_id = $data['item_id'];
			$coontext = $data['coontext'];
            try{
                $iNum = intval($item_id);
            } catch (Exception $e) {
			 print_r($e->getMessage());die;
			}
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
            $datalist=$this->initDestinations($item_id,$coontext);            
            print_r($datalist);die;
        }         
    }
	public static function get_actionvalue_text($action,$actionval){
		switch($action){
			case 'toagent':					
				$guser = DB::table('users')->where('sip_number', $actionval)->first();	
				if($guser==null)
					return "نامشخص(".$actionval.")";
				else
					return $guser->name." ".$guser->u_lname."($actionval)";
			case 'toivr':									
				$givr = DB::table('tbl_ivr')->where('i_id', $actionval)->first();	
				if($givr==null)
					return "نامشخص(".$actionval.")";
				else
					return $givr->i_name;
			case 'toqueue':									
				return "اتصال به صف";
			case 'tooutcall':									
				return "اتصال به تماس خروجی";
			case 'tovoicemail':									
				return "اتصال به پست صوتی";
			case 'tomodule':									
				$gmod = DB::table('tbl_modules')->where('m_id', $actionval)->first();	
				if($gmod==null)
					return "نامشخص(".$actionval.")";
				else
					return $gmod->m_name;
			case 'totrunk':									
				return "اتصال به مسیر خروجی";
			case 'totimeline':								
				return "شرایط زمانی";
			case 'tonotification':									
				return "اطلاعیه";
			case 'todialplan':									
				return "پلان تماس داخلی";
			case 'playsound':									
				$gmod = DB::table('tbl_sounds')->where('s_fileaddr', $actionval)->first();	
				if($gmod==null)
					return "نامشخص(".$actionval.")";
				else
					return $gmod->s_name;
			case 'hangup':									
				return "قطع تماس";
			default:
				return $action;
		}		
	}
	public static function get_action_text($action){
		switch($action){
			case 'toagent':									
				return "اتصال به کاربر";
			case 'toivr':									
				return "منشی دیجیتال";
			case 'toqueue':									
				return "اتصال به صف";
			case 'tooutcall':									
				return "اتصال به تماس خروجی";
			case 'tovoicemail':									
				return "اتصال به پست صوتی";
			case 'tomodule':									
				return "اتصال به ماژول";
			case 'totrunk':									
				return "اتصال به مسیر خروجی";
			case 'totimeline':								
				return "شرایط زمانی";
			case 'tonotification':									
				return "اطلاعیه";
			case 'todialplan':									
				return "پلان تماس داخلی";
			case 'playsound':									
				return "پخش صدا";
			case 'hangup':									
				return "قطع تماس";
			default:
				return $action;
		}		
	}
	public function get_action_name(Request $request){
		if($request->ajax()) {
            $error_warning='';
            $data = $request->all();
            $itoken = $data['_token'];
			$act = $data['item_id'];            			
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
            $responsestring='';
			switch($act){
				case 'toagent':					
					$responsestring='{"item_value":"اتصال به کاربر"}';					
					return $responsestring;
				case 'toivr':					
					$responsestring='{"item_value":"منشی دیجیتال"}';					
					return $responsestring;
				case 'toqueue':					
					$responsestring='{"item_value":"اتصال به صف"}';					
					return $responsestring;
				case 'tooutcall':					
					$responsestring='{"item_value":"اتصال به تماس خروجی"}';					
					return $responsestring;
				case 'tovoicemail':					
					$responsestring='{"item_value":"اتصال به پست صوتی"}';					
					return $responsestring;
				case 'tomodule':					
					$responsestring='{"item_value":"اتصال به ماژول"}';					
					return $responsestring;
				case 'totrunk':					
					$responsestring='{"item_value":"اتصال به مسیر خروجی"}';					
					return $responsestring;
				case 'totimeline':					
					$responsestring='{"item_value":"شرایط زمانی"}';					
					return $responsestring;
				case 'tonotification':					
					$responsestring='{"item_value":"اطلاعیه"}';					
					return $responsestring;
				case 'todialplan':					
					$responsestring='{"item_value":"پلان تماس داخلی"}';					
					return $responsestring;
				case 'playsound':					
					$responsestring='{"item_value":"پخش صدا"}';					
					return $responsestring;
				case 'hangup':					
					$responsestring='{"item_value":"قطع تماس"}';					
					return $responsestring;
				default:
					return '{}';
			}		   
            print_r($datalist);die;
        }      		
	}
	public static function event_socket_create($host, $port, $password) {
		$fp = fsockopen($host, $port, $errno, $errdesc) 
		   or die("Connection to $host failed");
		socket_set_blocking($fp,false);
		 
		if ($fp) {
			while (!feof($fp)) {
				$buffer = fgets($fp, 1024);
				usleep(100); //allow time for reponse
				if (trim($buffer) == "Content-Type: auth/request") {
				   fputs($fp, "auth $password\n\n");
				   break;
				}
			}
			return $fp;
		}
		else {
			return false;
		}           
	}
	 	 
	public static function event_socket_request($fp, $cmd) {
		if ($fp) {    
			fputs($fp, $cmd."\n\n");    
			usleep(100); //allow time for reponse
			 
			$response = "";
			$i = 0;
			$contentlength = 0;
			while (!feof($fp)) {
				$buffer = fgets($fp, 4096);
				if ($contentlength > 0) {
				   $response .= $buffer;
				}
				
				if ($contentlength == 0) { //if contentlenght is already don't process again
					if (strlen(trim($buffer)) > 0) { //run only if buffer has content
						$temparray = explode(":", trim($buffer));
						if ($temparray[0] == "Content-Length") {
						   $contentlength = trim($temparray[1]);
						}
					}
				}
				
				usleep(100); //allow time for reponse
				
				//optional because of script timeout //don't let while loop become endless
				if ($i > 10000) { break; } 
				
				if ($contentlength > 0) { //is contentlength set
					//stop reading if all content has been read.
					if (strlen($response) >= $contentlength) {  
					   break;
					}
				}
				$i++;
			}			 
			return $response;
		}
		else {
			echo "no handle";
		}
	}
	public static function runCommand($comm,$res){
		$password = config('switch.switchpass');
		$port = config('switch.switchport');
		$host = config('switch.switchhost');
		$fp = GClass::event_socket_create($host, $port, $password);		
		$response = GClass::event_socket_request($fp, "api $comm");
		fclose($fp); 
		$length = strlen($res);
		$nres=(substr($response, 1, $length) === $res);
		if($nres==1)
			return 1;			
		else
			return $response; 
	}
	public static function UserAgents($username){
		$sql = "Select concat(users.sip_number,'@',tbl_sipservers.s_domain)as userag from users left join tbl_sipservers on users.usercontext=tbl_sipservers.s_id Where users.username='$username'";
		$query = DB::select($sql);
		foreach ($query as $item){
			return $item->userag;
		}		
		return '';
	}
	public static function ClearUserAgent($username){
		$sql = "Select sip_number from users Where username='$username'";
		$query = DB::select($sql);
		foreach ($query as $item){
			return $item->sip_number;
		}		
		return '';
	}
	public static function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	public static function setCSAgentsStatus($agent,$status,$state,$ref='user'){
		$sql = "Select * from tbl_agentsio Where a_agent='$agent' order by a_datetime desc limit 1";
		$query = DB::select($sql);
		$lastact="Logged Out";	
		$lastactdate=0;
		$nowtime=date("Y-m-d H:i:s");
		$lastdate="2000-01-01 00:00:01";
		if($query!=null){
			$lastact=$query[0]->a_action;
			$lastdate=$query[0]->a_datetime;
			$timeFirst=strtotime($lastdate);
			$lastactdate=strtotime($nowtime)-$timeFirst;
		}		
		if($lastact=="Logged Out"){
			$lastactdate=0;
		}
		$sql = "Insert Into tbl_agentsio(a_agent,a_datetime,a_action,a_totalsecends,a_actref,a_lastaction,a_lastacttime)".
			"Values('$agent','$nowtime','$status','$lastactdate','$ref','$lastact','$lastdate')";
		$query = DB::insert($sql);
		$acres=GClass::runCommand("callcenter_config agent set status $agent '$status'","+OK");
		if($acres=="1"){
			$acres=GClass::runCommand("callcenter_config agent set state $agent '$state'","+OK");
			return $acres;				
		}
		else{
			return $acres;
		}
	}
	public static function getCSAgentsStatus($agent){
		return GClass::runCommand("callcenter_config agent set status $agent '$status'","+OK");		
	}
	public static function setAgentsIO($agent){
		
	}
}
