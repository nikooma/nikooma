<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Auth\UserManager;
use App\Model\Auth\group;
use App\Http\Controllers\FileManager;
use Session;
use App\Http\Controllers\app_code\Permissions;
use SoapClient;
use PDF;
use Excel;

class UserManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            
		$data['grplist'] = group::get_records();
		$data['datalist'] = UserManager::get_records();		
        return view('auth.users.usermanager',$data);
    }
	public function _edit_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           
		$data['grplist'] = group::get_records();
		$data['usergrplist']=UserManager::get_groups_by_id($id);
		$datalist=UserManager::get_record_by_id($id);
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('auth.users.useredit',$data);
    }
	public function _new_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            
		$data['grplist'] = group::get_records();
		$data['datalist'] = UserManager::get_records();			
		$data['status'] = '_new';
        return view('auth.users.useredit',$data);
    }
	public function _export(){
		$extype=Input::get('inp_extype');
		$ddlSort=Input::get('grp_ddlSort');
		$lstFields = Input::get('inp_lstFields');
		$sorttype = Input::get('inp_sorttype');
		if(count($lstFields)==0)
		{
			$data['error_warning']="حداقل باید یک ستون انتخاب شود.";
		}
		else {
			$fields='';
			foreach ($lstFields as $item){
				$lValue=explode('|',$item)[0];				
				$fields.= $lValue.",";
			}
			$fields=rtrim($fields,",");			
			if($extype=='pdf'){
				$datas['itemlist'] = UserManager::get_fields_records($fields,$ddlSort,$sorttype);
				$pdf = PDF::loadView('export.pdf.auth.manageusers', $datas,[],[
					'title' => 'manageusers',
					'format' => 'A4-L',
					'orientation' => 'L'
				]);
				return $pdf->stream('manageusers.pdf');
			}
			else if($extype=='excel'){
				$datas['itemlist'] = UserManager::get_fields_records($fields,$ddlSort,$sorttype);
				Excel::create('manageusers', function($excel) use ($datas) {

					$excel->sheet('کاربران', function($sheet) use ($datas) {

						$sheet->loadView('export.excel.auth.manageusers', $datas);

					});

				})->download('xlsx');
			}
		}
	}
	public function _import($request){
		$tmpfile=$_SERVER['DOCUMENT_ROOT']."/tmp/tmp132455.tmp";
		$file=$request->file('fleimport');   
		$filetype=$file->getClientMimeType();	
		$errstring="";
		if($filetype=='application/vnd.ms-excel' || $filetype=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
			//$scode=FileManager::UploadNewFile("fleimport",$tmpfile,"php",5000000);	
			$path = Input::file('fleimport')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {	
					$inserres=UserManager::insert_imported_data($value);									
					if($inserres!="0"){
						$errstring.="$inserres<br />";
					}															
				}					
				if($errstring==""){
					return "";
				}
				else{
					return $errstring;
				}
			}
			else{
				return "امکان دریافت فایل وجود ندارد";
			}
		}
		else{			
			return "برای ورود اطلاعات تنها می توانید از فایل های Excel استفاده نمایید.";
		}
	}
    public function _action_(Request $request){
        $data['error_warning'] = '';    
        $data['success']='';
        if (Session::token() != Input::get('_token'))
        {
            print_r("Access denied!");die;
        }		
		if(Input::get('hdExport')=="_export"){
			return $this->_export();
		}
		else if(Input::get('hdImport')=="_import"){			
			if ($request->hasFile('fleimport')) {
				 $data['error_warning']=$this->_import($request);
				 if($data['error_warning']==""){
					 $data['success']='اطلاعات با موفقیت بارگذاری گردید.';
				 }
			}
		}
		else{
			$hd_val=Input::get('inp_hdID');
			if(strlen($hd_val)>0){
				$insertVal = UserManager::update_record($hd_val);
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
						$res_val=UserManager::delete_record($item_id);
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
					$insertVal = UserManager::add_new_record();
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
		}	
		$data['grplist'] = group::get_records();
		$data['datalist'] = UserManager::get_records();	
        return view('auth.users.usermanager',$data);
    }
}
