<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css"/>		
    <style>
		.center-frame{
			width: 60%;
			margin:0 auto;
			display:table;
			font-family:BMitra;
		}
		.select2-selection{
			height:35px;
			text-align:right;
		}
		.select2-results__option{
			text-align:right;
		}
	</style>
@endsection

@section('pageheadercontent')
      <h1>
        نیازمندان
        <small>افراد تحت تکفل</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">نیازمندان</a></li>
        <li class="active">افراد تحت تکفل</li>
      </ol>  
@endsection

@section('maincontent')		
	<div class="box box-info">		
		<a href="/niazmandan/takafol/<?php echo $takafol_id; ?>" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/niazmandan/takafol/<?php echo $takafol_id; ?>" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			کدملی:
			<input id="txtMeli" name="inp_txtMeli" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->nt_meli:""); ?>' type="number" required MaxLength="10" />
			نام:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->nt_name:""); ?>' type="text" required MaxLength="50" />
			نام خانوادگی:
			<input id="txtFamily" name="inp_txtFamily" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->nt_family:""); ?>' type="text" required MaxLength="50" />
			نام پدر
			<input id="txtPedar" name="inp_txtPedar" class="form-control" type="text" value='<?php echo($status=="_edit"?$datalist[0]->nt_pedar:""); ?>' required MaxLength="50" />		
			جنسیت:
			<select id="ddlJensiat" class="form-control" style="width: 100%;" name="inp_ddlJensiat">												
				<option value="1">آقا</option>	
				<option value="2">خانم</option>	
			</select>											
			تاریخ تولد:
			<input id="txtTTavalod" name="inp_txtTTavalod" class="form-control datepicker" type="text" value='<?php echo($status=="_edit"?$datalist[0]->nt_tavalod:""); ?>' required MaxLength="50" />			
			شغل:
			<input id="txtShoghl" name="inp_txtShoghl" value='<?php echo($status=="_edit"?$datalist[0]->nt_shoghl:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			میزان درآمد:
			<select id="ddlDaramad" class="form-control" style="width: 100%;" name="inp_ddlDaramad">												
				<option value="1">زیر 100 هزار</option>	
				<option value="2">بین 100 تا 200 هزار</option>	
				<option value="3">بین 200 تا 300 هزار</option>	
				<option value="4">بین 300 تا 500 هزار</option>	
				<option value="5">بالای 500 هزار</option>	
			</select>		
			نوع بیمه:
			<select id="ddlBimeh" class="form-control" style="width: 100%;" name="inp_ddlBimeh">												
				<option value="1">بدون بیمه</option>	
				<option value="2">تامین اجتماعی</option>	
				<option value="3">نیروهای مسلح</option>	
				<option value="4">فرهنگیان</option>	
				<option value="5">سایرموارد</option>	
			</select>	
			میزان تحصیلات:
			<select id="ddlTahsilat" class="form-control" style="width: 100%;" name="inp_ddlTahsilat">												
				<option value="1">بی سواد</option>	
				<option value="2">زیر دیپلم</option>	
				<option value="3">دیپلم</option>	
				<option value="4">کاردانی</option>	
				<option value="5">کارشناسی</option>	
				<option value="6">کارشناسی ارشد</option>	
				<option value="7">دکتری</option>	
			</select>
			محل تحصیل:
			<input id="txtMahalTahsil" name="inp_txtMahalTahsil" value='<?php echo($status=="_edit"?$datalist[0]->nt_mahaltahsil:""); ?>' class="form-control" type="text" MaxLength="255" />			
			تخصص و مهارت:
			<input id="txtMaharat" name="inp_txtMaharat" value='<?php echo($status=="_edit"?$datalist[0]->nt_maharat:""); ?>' class="form-control" type="text" MaxLength="255" />                          
			میزان یارانه:
			<input id="txtYaraneh" name="inp_txtYaraneh" value='<?php echo($status=="_edit"?$datalist[0]->nt_yaraneh:""); ?>' class="form-control" type="number" required MaxLength="10" />                          
			وضعیت تاهل:
			<select id="ddlHamsar" class="form-control" style="width: 100%;" name="inp_ddlHamsar">												
				<option value="1">متاهل</option>	
				<option value="2">مجرد</option>	
			</select>		
			دوره های آموزشی:
			<input id="txtDoreAmoozeshi" name="inp_txtAddressManzel" value='<?php echo($status=="_edit"?$datalist[0]->nt_dorehamoozeshi:""); ?>' class="form-control" type="text" required MaxLength="255" />                          		
			وضعیت جسمانی:
			<input id="txtJesmani" name="inp_txtJesmani" value='<?php echo($status=="_edit"?$datalist[0]->nt_jesmani:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			سپرده بانکی:
			<input id="txtSepordeh" name="inp_txtSepordeh" value='<?php echo($status=="_edit"?$datalist[0]->nt_sepordehbanki:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			<br />
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo($status=="_edit"?$datalist[0]->nt_id:""); ?>' /> 
			<input type="hidden" id="hdParID" name="inp_hdParID" value='<?php echo $takafol_id; ?>' />			
		  </form>    
			<script>
				$('#frmControls input[type=text]').on('change invalid', function() {
					var textfield = $(this).get(0);
					textfield.setCustomValidity('');                                
					if (!textfield.validity.valid) {
					textfield.setCustomValidity('{{ __('callcenter.infoadditem') }}');  
					}
				});

			</script>        
		</div>
		<!-- /.box-body -->
	  </div>
@endsection

@section('footerscript')
	<script src='/bower_components/select2/dist/js/select2.min.js'></script>
	<script src="/bower_components/bootstrap-jalali-datepicker/bootstrap-datepicker.min.js"></script>    	
    <script>
		$(document).ready(function() {
			$(".select2").select2();			  	
		});
	</script>
	@if($status=="_edit")
		<script>			
			$(document).ready(function(){    
				$('#ddlDaramad').val(<?php echo $datalist[0]->nt_daramad; ?>); 						
				$('#ddlDaramad').trigger('change');			
				
				$('#ddlBimeh').val(<?php echo $datalist[0]->nt_bimeh; ?>); 						
				$('#ddlBimeh').trigger('change');			
				
				$('#ddlTahsilat').val(<?php echo $datalist[0]->nt_tahsil;; ?>); 						
				$('#ddlTahsilat').trigger('change');			
				
				$('#ddlHamsar').val(<?php echo $datalist[0]->nt_taahol; ?>); 						
				$('#ddlHamsar').trigger('change');			
				
				$('#ddlJensiat').val(<?php echo $datalist[0]->nt_jensiat; ?>); 						
				$('#ddlJensiat').trigger('change');
			});
		</script>
	@endif		
@endsection