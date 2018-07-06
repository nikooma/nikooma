<?php

namespace App\Http\Controllers\Callcenter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Callcenter\inbound;
use App\Model\Callcenter\Servers;
use Session;
use App\Http\Controllers\app_code\GClass;

class inboundcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(){
        $data['error_warning'] = '';
        $data['success'] = '';
        //$data['datalist'] = array();
        //$results = $this->model_catalog_category->getCategories($filter_data);    		
		$data['datalist'] = inbound::get_records();
        return view('Callcenter.inbound.inbound',$data);
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
