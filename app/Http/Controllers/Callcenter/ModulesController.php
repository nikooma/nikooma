<?php

namespace App\Http\Controllers\Callcenter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Callcenter\Modules;
use Session;
use App\Http\Controllers\app_code\GClass;

class ModulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            		
		$data['datalist'] = Modules::get_records();		
		//echo (GClass::runCommand("luarun /var/www/laravel/public/modules/1000000/module.lua","544"));
        return view('Callcenter.modules.modules',$data);
    }
	public function _editdest(Request $request,$id){
		$data['error_warning'] = '';
        $data['success'] = '';           		
		$datalist=Modules::get_desval_by_id($id);
		$data['datalist'] = $datalist;	
		$data['item_id'] = $id;	
		$data['status'] = '_edit';
        return view('Callcenter.modules.modulesdest',$data);
	}
	public function _destactions(Request $request){
		$error_warning='';
        $data = Input::all();
        $itoken = $data['_token'];
        $item_id = $data['item_id'];
        $destact=Modules::get_desval_by_id($item_id);
        $responsestring='[';
        foreach ($destact as $item){
            $responsestring.='{';
            $responsestring.='"mv_id":"'.$item->mv_id.'",';
            $responsestring.='"mv_module":"'.$item->mv_module.'",';			
			$responsestring.='"mv_value":"'.$item->mv_value.'",';
			$responsestring.='"mv_dest":"'.$item->mv_dest.'",';
			$responsestring.='"mv_desttext":"'.GClass::get_action_text($item->mv_dest).'",';
			$responsestring.='"mv_destvalue":"'.$item->mv_destvalue.'",';
			$responsestring.='"a_destvaluetext":"'.GClass::get_actionvalue_text($item->mv_dest,$item->mv_destvalue).'",';
            $responsestring.='"mv_destmethod":"'.$item->mv_destmethod.'"},';
        }
        $responsestring=rtrim($responsestring,',').']';
        print_r($responsestring);die;
	}
	
	public function _status(Request $request,$id){
		$status=Modules::get_status_by_id($id);
		if($status=="0"){
			Modules::update_status_by_id("1",$id);
		}
		else{
			Modules::update_status_by_id("0",$id);
		}
		$data['error_warning'] = '';
        $data['success'] = '';            		
		$data['datalist'] = Modules::get_records();			
        return view('Callcenter.modules.modules',$data);
	}
	public function _edit_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           		
		$data['usergrplist']=Modules::get_groups_by_id($id);
		$datalist=Modules::get_record_by_id($id);
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('Callcenter.modules.modulesedit',$data);
    }
	public function _new_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            		
		$data['datalist'] = Modules::get_records();			
		$data['status'] = '_new';
        return view('Callcenter.modules.modulesedit',$data);
    }
    public function _action_(Request $request){
        $data['error_warning'] = '';    
        $data['success']='';
        if (Session::token() != Input::get('_token'))
        {
            print_r("Access denied!");die;
        }		
	
		$req=Input::get('selected');
		if(isset($req)){
			$err_suu='';
			foreach ($req as $item_id) {
				$res_val=Modules::delete_record($item_id);
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
		else{								
			if ($request->hasFile('flemodule')) {
				$insertVal = Modules::add_new_record($request);
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
			else if(Input::get('inp_hdID')!==null){
				$insertVal = Modules::add_new_actions($request);
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
		$data['datalist'] = Modules::get_records();			
        return view('Callcenter.modules.modules',$data);
    }
}
