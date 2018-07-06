<?php

namespace App\Http\Controllers\Sound;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Sound\Moh;
use Session;
use App\Http\Controllers\app_code\GClass;

class MohController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            		
		$data['datalist'] = Moh::get_records();				
        return view('Sound.moh.moh',$data);
    }
	public function _edit_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           						
		$datalist=Moh::get_record_by_id($id);
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('Sound.moh.mohedit',$data);
    }
	public function _new_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            		
		$data['datalist'] = Moh::get_records();	
		$data['status'] = '_new';
        return view('Sound.moh.mohedit',$data);
    }
	public function _new_sound_($id){
        $data['error_warning'] = '';
        $data['success'] = '';            		
		$data['soundlist'] = Moh::get_sound_list($id);
		$data['status'] = '_sound';
		$data['item_id'] = $id;
        return view('Sound.moh.mohsounds',$data);
    }
	public function _save_sound(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';   
		$insertval=Moh::save_sounds($request);
		if($insertval!="0"){
			$data['error_warning'] = $insertval;
		}
		$item_id=intval(Input::get('inp_hdID'));
		$data['soundlist'] = Moh::get_sound_list($item_id);		
		$data['item_id'] = $item_id;
		$data['status'] = '_sound';
        return view('Sound.moh.mohsounds',$data);
    }
    public function _action_(Request $request){
        $data['error_warning'] = '';    
        $data['success']='';
        if (Session::token() != Input::get('_token'))
        {
            print_r("Access denied!");die;
        }		
		$hd_val=Input::get('inp_hdID');
		if(strlen($hd_val)>0){
			$insertVal = Moh::update_record($hd_val);
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
		else{
			$req=Input::get('selected');
			if(isset($req)){
				$err_suu='';
				foreach ($req as $item_id) {
					$res_val=Moh::delete_record($item_id);
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
				$insertVal = Moh::add_new_record($request);
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
		$data['datalist'] = Moh::get_records();	
        return view('Sound.moh.moh',$data);
    }
}
