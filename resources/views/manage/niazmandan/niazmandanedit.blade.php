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
        <small>نیازمندان</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">نیازمندان</a></li>
        <li class="active">مدیریت</li>
      </ol>  
@endsection

@section('maincontent')		
	<div class="box box-info">		
		<a href="/niazmandan" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/niazmandan" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			کدملی:
			<input id="txtMeli" name="inp_txtMeli" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->n_meli:""); ?>' type="number" required MaxLength="10" />
			نام:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->n_name:""); ?>' type="text" required MaxLength="50" />
			نام خانوادگی:
			<input id="txtFamily" name="inp_txtFamily" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->n_family:""); ?>' type="text" required MaxLength="50" />
			نام پدر
			<input id="txtPedar" name="inp_txtPedar" class="form-control" type="text" value='<?php echo($status=="_edit"?$datalist[0]->n_pedar:""); ?>' required MaxLength="50" />		
			جنسیت:
			<select id="ddlJensiat" class="form-control" style="width: 100%;" name="inp_ddlJensiat">												
				<option value="1">آقا</option>	
				<option value="2">خانم</option>	
			</select>
			@if(Permissions::permissionCheck('23','06')==1)
			{{ __('callcenter.group') }}:							
			<select id="ddlgroups" class="form-control select2" style="width: 100%;" name="groups[]" multiple="multiple">								
				<?php foreach ($grplist as $item) { ?>
				<option value="<?php echo $item->id ?>"><?php echo $item->name; ?></option>	
				<?php }	?>
			</select>							
			@endif							
			شماره شناسنامه
			<input id="txtShenasnameh" name="inp_txtShenasnameh" class="form-control" type="text"  value='<?php echo($status=="_edit"?$datalist[0]->n_shenasnameh:""); ?>' MaxLength="10" />
			تاریخ تولد:
			<input id="txtTTavalod" name="inp_txtTTavalod" class="form-control datepicker" type="text" value='<?php echo($status=="_edit"?$datalist[0]->n_tarikhtavalod:""); ?>' required MaxLength="50" />
			محل تولد:
			<input id="txtMTavalod" name="inp_txtMTavalod" value='<?php echo($status=="_edit"?$datalist[0]->n_mahaltavalod:""); ?>' class="form-control" type="text" MaxLength="15" />
			شغل:
			<input id="txtShoghl" name="inp_txtShoghl" value='<?php echo($status=="_edit"?$datalist[0]->n_shoghl:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
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
			تخصص و مهارت:
			<input id="txtMaharat" name="inp_txtMaharat" value='<?php echo($status=="_edit"?$datalist[0]->n_maharat:""); ?>' class="form-control" type="text" MaxLength="255" />                          
			میزان یارانه:
			<input id="txtYaraneh" name="inp_txtYaraneh" value='<?php echo($status=="_edit"?$datalist[0]->n_yaraneh:""); ?>' class="form-control" type="number" required MaxLength="10" />                          
			وضعیت تاهل:
			<select id="ddlHamsar" class="form-control" style="width: 100%;" name="inp_ddlHamsar">												
				<option value="1">متاهل</option>	
				<option value="2">مجرد</option>	
			</select>
			کدملی همسر:
			<input id="txtMeliHamsar" name="inp_txtMeliHamsar" value='<?php echo($status=="_edit"?$datalist[0]->n_melihamsar:""); ?>' class="form-control" type="number" MaxLength="10" />                          
			شغل همسر:
			<input id="txtShoghlHamsar" name="inp_txtShoghlHamsar" value='<?php echo($status=="_edit"?$datalist[0]->n_shoghlhamsar:""); ?>' class="form-control" type="text" MaxLength="255" />                          
			نوع منزل:
			<select id="ddlManzel" class="form-control" style="width: 100%;" name="inp_ddlManzel">												
				<option value="1">شخصی</option>	
				<option value="2">اجاره ای</option>	
			</select>
			آدرس منزل:
			<input id="txtAddressManzel" name="inp_txtAddressManzel" value='<?php echo($status=="_edit"?$datalist[0]->n_addressmanzel:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			کد پستی منزل:
			<input id="txtPosti" name="inp_txtPosti" value='<?php echo($status=="_edit"?$datalist[0]->n_codeposti:""); ?>' class="form-control" type="number" required MaxLength="10" />                          
			تلفن منزل:
			<input id="txtTelManzel" name="inp_txtTelManzel" value='<?php echo($status=="_edit"?$datalist[0]->n_telephone:""); ?>' class="form-control" type="number" MaxLength="20" />                          
			تلفن همراه:
			<input id="txtTelHamrah" name="inp_txtTelHamrah" value='<?php echo($status=="_edit"?$datalist[0]->n_mobile:""); ?>' class="form-control" type="number" MaxLength="20" />                          
			علت نیاز:
			<input id="txtElateNiaz" name="inp_txtElateNiaz" value='<?php echo($status=="_edit"?$datalist[0]->n_elateniaz:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			وضعیت جسمانی:
			<input id="txtJesmani" name="inp_txtJesmani" value='<?php echo($status=="_edit"?$datalist[0]->n_vaziatejesmani:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			<br />
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo($status=="_edit"?$datalist[0]->n_id:""); ?>' />    
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
			<?php 
			$grp='[';
			foreach ($usergrplist as $group){
				$grp.=$group->ng_group.',';
			}
			$grp=rtrim($grp,",")."]";
			?>
			$(document).ready(function(){    
				$('#ddlgroups').val(<?php echo $grp; ?>); 						
				$('#ddlgroups').trigger('change');			

				$('#ddlDaramad').val(<?php echo $datalist[0]->n_daramad; ?>); 						
				$('#ddlDaramad').trigger('change');			
				
				$('#ddlBimeh').val(<?php echo $datalist[0]->n_bimeh; ?>); 						
				$('#ddlBimeh').trigger('change');			
				
				$('#ddlTahsilat').val(<?php echo $datalist[0]->n_mizantahsilat;; ?>); 						
				$('#ddlTahsilat').trigger('change');			
				
				$('#ddlHamsar').val(<?php echo $datalist[0]->n_hamsar; ?>); 						
				$('#ddlHamsar').trigger('change');			
				
				$('#ddlManzel').val(<?php echo $datalist[0]->n_noemanzel; ?>); 						
				$('#ddlManzel').trigger('change');			
				
				$('#ddlJensiat').val(<?php echo $datalist[0]->n_jensiat; ?>); 						
				$('#ddlJensiat').trigger('change');
			});
		</script>
	@endif		
@endsection