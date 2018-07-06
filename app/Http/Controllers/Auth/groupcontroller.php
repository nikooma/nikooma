<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Auth\group;
use Session;

class groupcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(){
        $data['error_warning'] = '';
        $data['success'] = '';     
		$data['datalist'] = group::get_records();	
        return view('auth.group',$data);
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
            $datalist=group::get_record_by_id($item_id);
            $responsestring='';
            foreach ($datalist as $item){
                $responsestring='{';
                $responsestring.='"g_id":"'.$item->g_id.'",';
                $responsestring.='"g_name":"'.$item->g_name.'",';                                                          
                $responsestring.='"g_description":"'.$item->g_description.'"}';
            }
            print_r($responsestring);die;
        }           
    }
    public function _action_(Request $request){
        $data['error_warning'] = '';    
        $data['success']='';
        if (Session::token() != Input::get('_token'))
        {
            print_r("Access denied!");die;
        }
        if ($request->has('act')) {
            $qstring = $request->input('act');
            if($qstring=="add"){
                $hd_val=Input::get('inp_hdID');
                if(strlen($hd_val)>0){
                    $insertVal = group::update_record($hd_val);
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
                    $insertVal = group::add_new_record();
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
            }
            else if($qstring=="delete"){
                $err_suu="";
                $req=Input::get('selected');
                if(isset($req)){
                    foreach ($req as $item_id) {    
                        $res_val=group::delete_record($item_id);
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
                    $data['error_warning']="هیچ اطلاعاتی جهت حذف انتخاب نشده است.";
                }
            }    
        }          
        
		$data['datalist'] = group::get_records();
        return view('auth.group',$data);
    }
}
