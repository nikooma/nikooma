<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Manage\niazmandan;
use App\Model\Auth\group;
use App\Http\Controllers\FileManager;
use Session;
use App\Http\Controllers\app_code\Permissions;
use PDF;
use Excel;

class niazmandanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function _index_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            
		$data['datalist'] = niazmandan::get_records();		
        return view('manage.niazmandan.niazmandan',$data);
    }
	
	public function _takafol_edit_(Request $request,$id,$t_id){
        $data['error_warning'] = '';
        $data['success'] = '';            		
		$data['status'] = '_new';
		$data['takafol_id'] = $id;
        
		$datalist=niazmandan::get_takafol_by_id($t_id);
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('manage.niazmandan.takafoledit',$data);
    }
	public function _edit_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';           
		$data['grplist'] = group::get_records();
		$data['usergrplist']=niazmandan::get_groups_by_id($id);
		$datalist=niazmandan::get_record_by_id($id);
		if($datalist==null){
			return abort(500);
		}
		else{
			$data['datalist'] = $datalist;
		}		
		$data['status'] = '_edit';
        return view('manage.niazmandan.niazmandanedit',$data);
    }
	public function _new_(Request $request){
        $data['error_warning'] = '';
        $data['success'] = '';            
		$data['grplist'] = group::get_records();
		$data['datalist'] = niazmandan::get_records();			
		$data['status'] = '_new';
        return view('manage.niazmandan.niazmandanedit',$data);
    }
	public function _takafol_new_(Request $request,$id){
        $data['error_warning'] = '';
        $data['success'] = '';            		
		$data['status'] = '_new';
		$data['takafol_id'] = $id;
        return view('manage.niazmandan.takafoledit',$data);
    }
	public function _takafol_(Request $request,$id){		
        $data['error_warning'] = '';
        $data['success'] = '';            
		$data['datalist'] = niazmandan::get_takafol($id);		
		$data['status'] = '_new';
		$data['takafol_id'] = $id;
		$sarparast=niazmandan::get_record_by_id($id);
		$data['tak_parent'] =$sarparast[0]->n_name." ".$sarparast[0]->n_family;
        return view('manage.niazmandan.takafol',$data);
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
				$datas['itemlist'] = niazmandan::get_fields_records($fields,$ddlSort,$sorttype);
				$pdf = PDF::loadView('export.pdf.auth.manageusers', $datas,[],[
					'title' => 'manageusers',
					'format' => 'A4-L',
					'orientation' => 'L'
				]);
				return $pdf->stream('manageusers.pdf');
			}
			else if($extype=='excel'){
				$datas['itemlist'] = niazmandan::get_fields_records($fields,$ddlSort,$sorttype);
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
					$inserres=niazmandan::insert_imported_data($value);									
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
	
	public function _niaz_takafol_getdata(Request $request){
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
			$niazmand=niazmandan::get_takafol_by_id($item_id);	
			if($niazmand!=null){
				$resp = "{\"nt_name\":\"".$niazmand[0]->nt_name."\",\"nt_family\":\"".$niazmand[0]->nt_family."\",\"nt_pedar\":\"".$niazmand[0]->nt_pedar."\",".
				"\"nt_meli\":\"".$niazmand[0]->nt_meli."\",\"nt_tavalod\":\"".$niazmand[0]->nt_tavalod."\",\"nt_shoghl\":\"".$niazmand[0]->nt_shoghl."\",\"nt_daramad\":\"".$niazmand[0]->nt_daramad."\",".
				"\"nt_bimeh\":\"".$niazmand[0]->nt_bimeh."\",\"nt_tahsil\":\"".$niazmand[0]->nt_tahsil."\",\"nt_maharat\":\"".$niazmand[0]->nt_maharat."\",\"nt_yaraneh\":\"".$niazmand[0]->nt_yaraneh."\",\"nt_taahol\":\"".$niazmand[0]->nt_taahol."\",".								
				"\"nt_jesmani\":\"".$niazmand[0]->nt_jesmani."\",\"nt_jensiat\":\"".$niazmand[0]->nt_jensiat."\"}";
				return $resp;
			}			
			return "{}";
		}
	}
	public function _niaz_getdata(Request $request){
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
			$niazmand=niazmandan::get_record_by_id($item_id);	
			if($niazmand!=null){
				$resp = "{\"n_name\":\"".$niazmand[0]->n_name."\",\"n_family\":\"".$niazmand[0]->n_family."\",\"n_pedar\":\"".$niazmand[0]->n_pedar."\",\"n_shenasnameh\":\"".$niazmand[0]->n_shenasnameh."\",".
				"\"n_meli\":\"".$niazmand[0]->n_meli."\",\"n_tarikhtavalod\":\"".$niazmand[0]->n_tarikhtavalod."\",\"n_mahaltavalod\":\"".$niazmand[0]->n_mahaltavalod."\",\"n_shoghl\":\"".$niazmand[0]->n_shoghl."\",\"n_daramad\":\"".$niazmand[0]->n_daramad."\",".
				"\"n_bimeh\":\"".$niazmand[0]->n_bimeh."\",\"n_mizantahsilat\":\"".$niazmand[0]->n_mizantahsilat."\",\"n_maharat\":\"".$niazmand[0]->n_maharat."\",\"n_yaraneh\":\"".$niazmand[0]->n_yaraneh."\",\"n_hamsar\":\"".$niazmand[0]->n_hamsar."\",".
				"\"n_melihamsar\":\"".$niazmand[0]->n_melihamsar."\",\"n_shoghlhamsar\":\"".$niazmand[0]->n_shoghlhamsar."\",\"n_noemanzel\":\"".$niazmand[0]->n_noemanzel."\",\"n_addressmanzel\":\"".$niazmand[0]->n_addressmanzel."\",".
				"\"n_codeposti\":\"".$niazmand[0]->n_codeposti."\",\"n_telephone\":\"".$niazmand[0]->n_telephone."\",\"n_mobile\":\"".$niazmand[0]->n_mobile."\",\"n_elateniaz\":\"".$niazmand[0]->n_elateniaz."\",".
				"\"n_vaziatejesmani\":\"".$niazmand[0]->n_vaziatejesmani."\",\"n_jensiat\":\"".$niazmand[0]->n_jensiat."\"}";
				return $resp;
			}			
			return "{}";
		}
	}
	
	public function _takafol_action_(Request $request,$id){
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
				$insertVal = niazmandan::update_takafol_record($hd_val);
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
						$res_val=niazmandan::delete_takafol_record($item_id);
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
					$insertVal = niazmandan::add_new_takafol_record($id);
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
		$data['datalist'] = niazmandan::get_takafol($id);				
		$data['takafol_id'] = $id;
		$sarparast=niazmandan::get_record_by_id($id);
		$data['tak_parent'] =$sarparast[0]->n_name." ".$sarparast[0]->n_family;
        return view('manage.niazmandan.takafol',$data);
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
				$insertVal = niazmandan::update_record($hd_val);
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
						$res_val=niazmandan::delete_record($item_id);
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
					$insertVal = niazmandan::add_new_record();
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
		$data['datalist'] = niazmandan::get_records();	
        return view('manage.niazmandan.niazmandan',$data);
    }
}
