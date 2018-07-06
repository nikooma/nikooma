<?php

namespace App\Http\Controllers\Callcenter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Callcenter\Ivr;
use App\Model\Sound\Sounds;
use Session;
use App\Http\Controllers\app_code\GClass;
use App\Http\Controllers\app_code\Permissions;

class IvrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            				
		$data['datalist'] = Ivr::get_records();		
        return view('Callcenter.ivr.ivr',$data);
    }
	public function _edit_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           
		$data['sndlist'] = Sounds::get_records();
		$datalist=Ivr::get_record_by_id($id);
		$data['item_id'] = $id;
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('Callcenter.ivr.ivredit',$data);
    }
	public function _new_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            
		$data['sndlist'] = Sounds::get_records();
		$data['item_id'] = Ivr::get_new_id();			
		$data['status'] = '_new';
		$data['datalist'] = Ivr::get_records();
        return view('Callcenter.ivr.ivredit',$data);
    }
	public function getDigitActions(Request $request){		
        $error_warning='';
        $data = Input::all();
        $itoken = $data['_token'];
        $item_id = $data['item_id'];
        if (Session::token() != $itoken)
        {
            print_r("Access denied!");die;
        }
        $ivract=Ivr::get_ivr_actions($item_id);
        $responsestring='[';
        foreach ($ivract as $item){
            $responsestring.='{';
            $responsestring.='"a_id":"'.$item->a_id.'",';
            $responsestring.='"a_digit":"'.$item->a_digit.'",';
			$responsestring.='"a_dest":"'.$item->a_dest.'",';
			$responsestring.='"a_desttext":"'.GClass::get_action_text($item->a_dest).'",';
			$responsestring.='"a_destvalue":"'.$item->a_destvalue.'",';
			$responsestring.='"a_destvaluetext":"'.GClass::get_actionvalue_text($item->a_dest,$item->a_destvalue).'",';
            $responsestring.='"a_method":"'.$item->a_method.'"},';
        }
        $responsestring=rtrim($responsestring,',').']';
        print_r($responsestring);die;
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
				$insertVal = Ivr::update_record($hd_val);
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
				$insertVal = Ivr::add_new_record();
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
					$res_val=Ivr::delete_record($item_id);
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
		$data['datalist'] = Ivr::get_records();	
        return view('Callcenter.ivr.ivr',$data);
    }
}
