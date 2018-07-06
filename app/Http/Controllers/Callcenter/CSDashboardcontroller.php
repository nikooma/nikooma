<?php

namespace App\Http\Controllers\Callcenter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Callcenter\CSDashboard;
use App\Model\Callcenter\Servers;
use Session;
use Auth;
use App\Http\Controllers\app_code\GClass;

class CSDashboardcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(){		
        $data['error_warning'] = '';
        $data['success'] = '';
        $data['useragent'] = GClass::UserAgents(Auth::user()->username);
		$clagent=GClass::ClearUserAgent(Auth::user()->username);
		$data['cluseragent'] = $clagent;
		$data['queuelist']=CSDashboard::get_queue_list($clagent);
        //$results = $this->model_catalog_category->getCategories($filter_data);    		
		$data['datalist'] = CSDashboard::get_records();
        return view('Callcenter.csdashboard.csdashboard',$data);
    }    
	public function _start(Request $request){
		if($request->ajax()) {
            $error_warning='';
            $data = Input::all();
            $itoken = $data['_token'];
            $item_id = $data['item_id'];
            try{
                $iNum = intval($item_id);
            } catch (Exception $e) {
			 print_r($e->getMessage());die;
			}
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
			$stresault=GClass::setCSAgentsStatus($item_id,'Available','Waiting');						
			$status=CSDashboard::get_last_status($item_id);
			$responsestring='';
            $responsestring='{';	
            $responsestring.='"resault":"'.$stresault.'"}';            
            print_r($responsestring);die;
        }     
	}
	public function _pause(Request $request){
		if($request->ajax()) {
            $error_warning='';
            $data = Input::all();
            $itoken = $data['_token'];
            $item_id = $data['item_id'];
            try{
                $iNum = intval($item_id);
            } catch (Exception $e) {
			 print_r($e->getMessage());die;
			}
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
			$stresault=GClass::setCSAgentsStatus($item_id,'On Break','Idle');						
			$responsestring='';
            $responsestring='{';	
            $responsestring.='"resault":"'.$stresault.'"}';            
            print_r($responsestring);die;
        }     
	}
	public function _stop(Request $request){
		if($request->ajax()) {
            $error_warning='';
            $data = Input::all();
            $itoken = $data['_token'];
            $item_id = $data['item_id'];
            try{
                $iNum = intval($item_id);
            } catch (Exception $e) {
			 print_r($e->getMessage());die;
			}
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
			$stresault=GClass::setCSAgentsStatus($item_id,'Logged Out','Idle');						
			$responsestring='';
            $responsestring='{';	
            $responsestring.='"resault":"'.$stresault.'"}';            
            print_r($responsestring);die;
        }     
	}
	public function _status(Request $request){
		if($request->ajax()) {
            $error_warning='';
            $data = Input::all();
            $itoken = $data['_token'];
            $item_id = $data['item_id'];
            try{
                $iNum = intval($item_id);
            } catch (Exception $e) {
			 print_r($e->getMessage());die;
			}
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
			$message="";
			$icode=0;
			$state="";
			$status="";
            $registration=CSDashboard::get_last_registration($item_id);
			
			if($registration=="false"){
				$message="در حال حاضر تلفن شما ثبت نشده است. لطفا از طریق تلفن خود وارد شوید";
				$status=CSDashboard::get_last_status($item_id);
				if($status!="Logged Out"){
					$stresault=GClass::setCSAgentsStatus($item_id,'Logged Out','Idle','system');		
				}
				$state="false";
				$icode=100;
			}
			else{
				$ip=GClass::getRealIpAddr();
				if($ip==$registration){
					$message="";
					$state="true";
					$icode=0;
				}
				else{
					$message="تلفن شما از طریق سیستم با آی پی $registration قبلا وارد شده است و شما از طریق این سیستم قادر به ورود نیستید.";
					$state="false";
					$status=CSDashboard::get_last_status($item_id);
					if($status!="Logged Out"){
						$stresault=GClass::setCSAgentsStatus($item_id,'Logged Out','Idle','system');		
					}	
					$icode=200;
				}
			}
			$status=CSDashboard::get_last_status($item_id);
			$members=CSDashboard::get_members_list($item_id);
			$responsestring='';
            $responsestring='{';
            $responsestring.='"code":"'.$icode.'",';    
			$responsestring.='"message":"'.$message.'",';
			$aglist=CSDashboard::get_agent_list($item_id);
			$callsanswered=0;
			$noanswercount=0;
			$allcalls=0;
			$lasttime = date('Y-m-d H:i:s');
			if($aglist!=null){
				$callsanswered=$aglist[0]->calls_answered;
				$noanswercount=$aglist[0]->no_answer_count;	
				$allcalls=intval($callsanswered)+intval($noanswercount);
				$lasttimeepoch=$aglist[0]->ready_time;
				$lasttime=date('Y-m-d H:i:s',$lasttimeepoch);
			}
			$holding=CSDashboard::get_holdingtime($item_id,$lasttime);						
			$responsestring.='"callsanswered":"'.$callsanswered.'",';
			$responsestring.='"noanswercount":"'.$noanswercount.'",';
			$responsestring.='"allcalls":"'.$allcalls.'",';
			$responsestring.='"holding":"'.$holding.'",';	
			$responsestring.='"members":{';
			if($members!=null){				
				$responsestring.='"queue":"'.$members[0]->queue.'",';
				$responsestring.='"uuid":"'.$members[0]->uuid.'",';
				$responsestring.='"callerid":"'.$members[0]->cid_number.'",';
				$responsestring.='"systemepoch":"'.$members[0]->system_epoch.'",';
				$responsestring.='"joinepoch":"'.$members[0]->joined_epoch.'",';
				$responsestring.='"bridgeepoch":"'.$members[0]->bridge_epoch.'",';										
				$responsestring.='"adsltel":"'.$members[0]->cp_AdslTel.'",';
				$responsestring.='"flname":"'.$members[0]->cp_FLName.'",';
				$responsestring.='"mobile":"'.$members[0]->cp_Mobile.'",';
				$responsestring.='"email":"'.$members[0]->cp_Email.'",';
				$responsestring.='"codemeli":"'.$members[0]->cp_CodeMeli.'",';
				$responsestring.='"city":"'.$members[0]->cp_City.'",';
				$responsestring.='"mdf":"'.$members[0]->cp_Mdf.'",';
				$responsestring.='"customertype":"'.$members[0]->cp_CustomerType.'",';
				$responsestring.='"ismesi":"'.$members[0]->cp_IsMesi.'",';
				$responsestring.='"activeservice":"'.$members[0]->cp_ActiveService.'",';
				$responsestring.='"reserveservice":"'.$members[0]->cp_ReservService.'",';
				$responsestring.='"isonline":"'.$members[0]->cp_IsOnline.'",';
				$responsestring.='"onlineip":"'.$members[0]->cp_OnlineIP.'",';
				$responsestring.='"ras":"'.$members[0]->cp_Ras.'",';
				$responsestring.='"islock":"'.$members[0]->cp_IsLock.'",';
				$responsestring.='"lockreason":"'.$members[0]->cp_LockReason.'",';
				$responsestring.='"staticip":"'.$members[0]->cp_StaticIP.'",';
				$responsestring.='"netusername":"'.$members[0]->cp_NetUsername.'",';
				$responsestring.='"netpassword":"'.$members[0]->cp_NetPassword.'",';
				$responsestring.='"firstlogin":"'.$members[0]->cp_FirstLogin.'",';
				$responsestring.='"timetoexp":"'.$members[0]->cp_TimeToExp.'",';
				$responsestring.='"credit":"'.$members[0]->cp_Credit.'",';
				$responsestring.='"deposit":"'.$members[0]->cp_Deposit.'",';
				$responsestring.='"activedate":"'.$members[0]->cp_ActiveDate.'",';
				$joining=intval($members[0]->bridge_epoch)-intval($members[0]->joined_epoch);
				if($joining<0){
					$joining=0;
				}
				$responsestring.='"jointime":"'.gmdate("H:i:s", $joining).'",';
				$responsestring.='"servicetype":"'.$members[0]->cp_ServiceType.'"';
			}
			$responsestring.='},';  
            $responsestring.='"status":"'.$status.'"}';            
            print_r($responsestring);die;
        }     
	}
    public function get_data(Request $request){
        if($request->ajax()) {
            $error_warning='';
            $data = Input::all();
            $itoken = $data['_token'];
            $item_id = $data['item_id'];
            try{
                $iNum = intval($item_id);
            } catch (Exception $e) {
			 print_r($e->getMessage());die;
			}
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
            $datalist=inbound::get_record_by_id($item_id);
            $responsestring='';
            foreach ($datalist as $item){
                $responsestring='{';
                $responsestring.='"iname":"'.$item->iname.'",';
                $responsestring.='"icode":"'.$item->icode.'",';
                $responsestring.='"idestinationnumber":"'.str_replace("\\","/",$item->idestinationnumber).'",';
                $responsestring.='"idestination":"'.$item->idestination.'",';                                              
				$responsestring.='"username":"'.$item->username.'",';  
				$responsestring.='"context":"'.$item->context.'",';  
                $responsestring.='"idestinationvalue":"'.$item->idestinationvalue.'"}';
            }
            print_r($responsestring);die;
        }           
    }
	public function get_destinations(Request $request){
        if($request->ajax()) {
            $error_warning='';
            $data = Input::all();
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
            $datalist=GClass::initDestinations($item_id,$coontext);            
            print_r($datalist);die;
        }         
    }
	public function _edit_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           
		$data['srvlist'] = Servers::get_records();		
		$datalist=inbound::get_record_by_id($id);
		$data['item_id'] = $id;
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('Callcenter.inbound.inboundedit',$data);
    }
	public function _new_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            	
		$data['item_id'] = inbound::get_new_id();	
		$data['srvlist'] = Servers::get_records();		
		$data['status'] = '_new';
		$data['datalist'] = inbound::get_records();
        return view('Callcenter.inbound.inboundedit',$data);
    }
    public function _action_(Request $request){
		$data['error_warning'] = '';    
        $data['success']='';
        if (Session::token() != Input::get('_token'))
        {
            print_r("Access denied!");die;
        }		
		$hd_status=Input::get('inp_hdStatus');
		if(strlen($hd_status)>0){
			if($hd_status=="_edit"){
				$hd_val=Input::get('inp_hdID');
				$insertVal = inbound::update_record($hd_val);
				if($insertVal=="0"){
					$data['success']="اطلاعات با موفقیت ذخیره گردید.";
				}
				else if($insertVal=="1"){
					$data['error_warning']="هیچ اطلاعاتی جهت ذخیره سازی وجود ندارد.";
				}
				else{
					$data['error_warning']=$insertVal;
				}
			}
			else if($hd_status=="_new"){
				$insertVal = inbound::add_new_record();
				if($insertVal=="0"){
					$data['success']="اطلاعات با موفقیت ذخیره گردید.";
				}
				else if($insertVal=="1"){
					$data['error_warning']="هیچ موردی انتخاب نشده است !";
				}
				else{
					$data['error_warning']=$insertVal;
				}
			}
		}
		else{
			$req=Input::get('selected');
			if(isset($req)){
				$err_suu='';
				foreach ($req as $item_id) {
					$res_val=inbound::delete_record($item_id);
					if (strlen($res_val) > 0){	
						$err_suu .= $res_val . "<br />";
					}
				}
				if (strlen($err_suu) > 0){	
					$data['error_warning']=$err_suu;
				}
				else{
					$data['success']="اطلاعات با موفقیت حذف گردید.";
				}
			}
		}                
		$data['datalist'] = inbound::get_records();	
        return view('Callcenter.inbound.inbound',$data);				
    }
}
