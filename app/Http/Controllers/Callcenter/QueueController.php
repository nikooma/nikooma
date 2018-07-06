<?php

namespace App\Http\Controllers\Callcenter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Callcenter\Queue;
use App\Model\Sound\Sounds;
use App\Model\Sound\Moh;
use App\Model\Auth\UserManager;
use Session;
use App\Http\Controllers\app_code\GClass;
use App\Http\Controllers\app_code\Permissions;

class QueueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }		
    public function _index_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            				
		$data['datalist'] = Queue::get_records();		
        return view('Callcenter.queue.queue',$data);
    }
	public function _edit_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           
		$data['sndlist'] = Sounds::get_records();
		$data['mohlist'] = Moh::get_records();
		$datalist=Queue::get_record_by_id($id);
		$data['item_id'] = $id;
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('Callcenter.queue.queueedit',$data);
    }
	public function _agents_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           
		$data['userlist'] = UserManager::get_records();
		$datalist=Queue::get_record_by_id($id);
		$data['item_id'] = $id;
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('Callcenter.queue.queueagents',$data);
    }
	public function _new_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            
		$data['sndlist'] = Sounds::get_records();
		$data['mohlist'] = Moh::get_records();
		$data['item_id'] = Queue::get_new_id();			
		$data['status'] = '_new';
		$data['datalist'] = Queue::get_records();
        return view('Callcenter.queue.queueedit',$data);
    }
	public function _listagents_(Request $request){	
		if($request->ajax()) {
            $error_warning='';
            $data = $request->all();
            $itoken = $data['_token'];  
			$queue=$data['Queue']; 
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
			$agents=Queue::get_agent_by_queue($queue);	
			$responsestring='[';
			foreach ($agents as $item){				
				$responsestring.='{"t_useragent":"'.$item->name.' '.$item->u_lname.'('.$item->sip_number.')'.'",';				
				$responsestring.='"t_level":"'.$item->t_level.'",';
				$responsestring.='"t_position":"'.$item->t_position.'",';
				$responsestring.='"t_queue":"'.$item->t_queue.'",';
				$responsestring.='"t_id":"'.$item->t_id.'"},';			
			}	
			$responsestring=rtrim($responsestring,',')."]";
			return $responsestring;
		}
		print_r("Access denied!");die;
	}
	public function _removeagents_(Request $request){	
		if($request->ajax()) {
            $error_warning='';
            $data = $request->all();
            $itoken = $data['_token'];      
			$agent = $data['Item_id'];      
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
			$sresp=Queue::delete_agent($agent);
			if($sresp=="0"){
				$agents=Queue::get_agent_by_queue($data['Queue']);				
				$responsestring='[';
				foreach ($agents as $item){				
					$responsestring.='{"t_useragent":"'.$item->name.' '.$item->u_lname.'('.$item->sip_number.')'.'",';				
					$responsestring.='"t_level":"'.$item->t_level.'",';
					$responsestring.='"t_position":"'.$item->t_position.'",';
					$responsestring.='"t_queue":"'.$item->t_queue.'",';
					$responsestring.='"t_id":"'.$item->t_id.'"},';			
				}	
				$responsestring=rtrim($responsestring,',')."]";
			}
			else{
				$responsestring='{"error":"1","message":"'.$sresp.'"}';
			}
			return $responsestring;
		}	
		print_r("Access denied!");die;
	}
	public function _editagents_(Request $request){	
		if($request->ajax()) {
            $error_warning='';
            $data = $request->all();
            $itoken = $data['_token'];          			
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }
			$sresp=Queue::add_new_agent($data);
			if($sresp=="0"){
				$agents=Queue::get_agent_by_queue($data['Queue']);				
				$responsestring='[';
				foreach ($agents as $item){				
					$responsestring.='{"t_useragent":"'.$item->name.' '.$item->u_lname.'('.$item->sip_number.')'.'",';									
					$responsestring.='"t_level":"'.$item->t_level.'",';
					$responsestring.='"t_position":"'.$item->t_position.'",';
					$responsestring.='"t_queue":"'.$item->t_queue.'",';
					$responsestring.='"t_id":"'.$item->t_id.'"},';			
				}	
				$responsestring=rtrim($responsestring,',')."]";
			}
			else{
				$responsestring='{"error":"1","message":"'.$sresp.'"}';
			}
			return $responsestring;
		}	
		print_r("Access denied!");die;
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
				$insertVal = Queue::update_record($hd_val);
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
				$insertVal = Queue::add_new_record();
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
					$res_val=Queue::delete_record($item_id);
					if (strlen($res_val) == "0"){	
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
		$data['datalist'] = Queue::get_records();	
        return view('Callcenter.queue.queue',$data);
    }
}
