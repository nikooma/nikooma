<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Auth\GroupManagement;
use App\Model\Auth\group;
use Session;

class GroupManagementController extends Controller
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
		$data['grplist'] = group::get_records();
		$data['panels'] = GroupManagement::get_panels();	
		$data['pviews'] = GroupManagement::get_pviews();	
        return view('auth.groupmanagement',$data);
    }    
	public function update_roles(Request $request){
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
			$dperms = GroupManagement::get_permissions($item_id);	
			$perms=explode(";",$dperms);
			$responsestring='['; 
			foreach($perms as $perm){
				if($perm!="")
					$responsestring.='"'.$perm.'",';
			}
			$responsestring=rtrim($responsestring,",")."]";
			return $responsestring;
		}
	}
    public function save_data(Request $request){
        if($request->ajax()) {
            $error_warning='';
            $data = Input::all();
            $itoken = $data['_token'];
            $item_id = $data['item_id'];
			$group = $data['group'];
            try{
                $iNum = intval($item_id);
            } catch (Exception $e) {
			 print_r($e->getMessage());die;
			}
            if (Session::token() != $itoken)
            {
                print_r("Access denied!");die;
            }          
			GroupManagement::add_new_record($group,$item_id);
            $responsestring='';            
            $responsestring='{';
            $responsestring.='"status":"OK",';                                                        
            $responsestring.='"message":""}';            
            print_r($responsestring);die;
        }           
    }    
}
