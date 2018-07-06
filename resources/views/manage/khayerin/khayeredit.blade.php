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
        خیرین
        <small>خیرین</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">خیرین</a></li>
        <li class="active">مدیریت</li>
      </ol>  
@endsection

@section('maincontent')		
	<div class="box box-info">		
		<a href="/khayer" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/khayer" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}			
			نام:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->n_name:""); ?>' type="text" required MaxLength="50" />
			نام خانوادگی:
			<input id="txtFamily" name="inp_txtFamily" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->n_family:""); ?>' type="text" required MaxLength="50" />			
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
			تلفن تماس:
			<input id="txtTel" name="inp_txtTel" value='<?php echo($status=="_edit"?$datalist[0]->n_mobile:""); ?>' class="form-control" type="number" required MaxLength="20" />                          
			شغل:
			<input id="txtShoghl" name="inp_txtShoghl" value='<?php echo($status=="_edit"?$datalist[0]->n_elateniaz:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			آدرس:
			<input id="txtAddress" name="inp_txtAddress" value='<?php echo($status=="_edit"?$datalist[0]->n_vaziatejesmani:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
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

				$('#ddlJensiat').val(<?php echo $datalist[0]->n_jensiat; ?>); 						
				$('#ddlJensiat').trigger('change');
			});
		</script>
	@endif		
@endsection