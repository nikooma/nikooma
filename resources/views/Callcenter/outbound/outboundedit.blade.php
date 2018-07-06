<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />	
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
		.material-switch > input[type="checkbox"] {
			display: none;   
		}

		.material-switch > label {
			cursor: pointer;
			height: 0px;
			position: relative; 
			width: 40px;  
		}

		.material-switch > label::before {
			background: rgb(0, 0, 0);
			box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
			border-radius: 8px;
			content: '';
			height: 16px;
			margin-top: -8px;
			position:absolute;
			opacity: 0.3;
			transition: all 0.4s ease-in-out;
			width: 40px;
		}
		.material-switch > label::after {
			background: rgb(255, 255, 255);
			border-radius: 16px;
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			content: '';
			height: 24px;
			left: -4px;
			margin-top: -8px;
			position: absolute;
			top: -4px;
			transition: all 0.3s ease-in-out;
			width: 24px;
		}
		.material-switch > input[type="checkbox"]:checked + label::before {
			background: inherit;
			opacity: 0.5;
		}
		.material-switch > input[type="checkbox"]:checked + label::after {
			background: inherit;
			left: 20px;
		}
	</style>
@endsection

@section('pageheadercontent')
      <h1>
        مسیرهای خروجی
        <small>مرکز تماس</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">مرکزتماس</a></li>
        <li class="active">مسیرهای خروجی</li>
      </ol>   
@endsection

@section('maincontent')		
	<div class="box box-info">		
		<a href="/outbounds" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/outbounds" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			{{ __('callcenter.inbound.name') }}:
			<input id="txtName" name="inp_txtName" value='<?php echo($status=="_edit"?$datalist[0]->o_name:""); ?>' class="form-control" type="text" required MaxLength="100" />                            			
			زمان انقضاء:							
			<input id="txtTimout" value='<?php echo($status=="_edit"?$datalist[0]->o_timeout:""); ?>' name="inp_txtTimout" dir="ltr" class="form-control" type="number" MaxLength="100" />                         
			آدرس مقصد:							
			<input id="txtIPAddr" value='<?php echo($status=="_edit"?$datalist[0]->o_ipaddress:""); ?>' name="inp_txtIPAddr" dir="ltr" class="form-control" type="text" required MaxLength="100" />                         			
			<div class="row">
				<div class="col-sm-3">
					نیاز به احراز هویت:
				</div>			
				<div class="col-sm-1 material-switch">
					<input id="registerneed" name="inp_registerneed" <?php echo ($status=="_edit" && $datalist[0]->o_registering=="on"?"checked=\"checked\"":""); ?> type="checkbox"/>
					<label for="registerneed" class="label-primary"></label>
				</div>
			</div>
			زمان سعی مجدد(میلی ثانیه):
			<input id="txtReply" value='<?php echo($status=="_edit"?$datalist[0]->o_timetorepeate:""); ?>' name="inp_txtReply" class="form-control" type="number" MaxLength="100" />
			نام کاربری:
			<input id="txtUsername" value='<?php echo($status=="_edit"?$datalist[0]->o_username:""); ?>' name="inp_txtUsername" class="form-control" type="text" MaxLength="100" />                            
			کلمه عبور:
			<input id="txtPass" name="inp_txtPass" value='<?php echo($status=="_edit"?$datalist[0]->o_password:""); ?>' class="form-control" type="password" MaxLength="100" />                         							
			آدرس پراکسی:							
			<input id="txtProxy" value='<?php echo($status=="_edit"?$datalist[0]->o_proxy:""); ?>' name="inp_txtProxy" dir="ltr" class="form-control" type="text" MaxLength="100" />                         
			آدرس پراکسی احراز هویت:							
			<input id="txtRegProxy" value='<?php echo($status=="_edit"?$datalist[0]->o_registerproxy:""); ?>' name="inp_txtRegProxy" dir="ltr" class="form-control" type="text" MaxLength="100" />                         								
			<div class="row">
				<div class="col-sm-3">
					ارسال شماره ی تماس گیرنده در کانال:	
				</div>			
				<div class="col-sm-1 material-switch">
					<input id="calleridinfrom" name="inp_calleridinfrom" <?php echo ($status=="_edit" && $datalist[0]->o_calleridinfrom=="on"?"checked=\"checked\"":""); ?> type="checkbox"/>
					<label for="calleridinfrom" class="label-primary"></label>
				</div>
			</div>
			پروتکل احراز هویت:							
			<select id="ddlProtocol" class="form-control" style="width: 100%;" name="inp_ddlProtocol">								
				<option value="udp">UDP</option>									
				<option value="tcp">TCP</option>								
			</select>	
			زمان PING:							
			<input id="txtPing" value='<?php echo($status=="_edit"?$datalist[0]->o_ping:""); ?>' name="inp_txtPing" dir="ltr" class="form-control" type="text" MaxLength="100" />                         			
			<br />
			<br />						
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }} <i class="fa fa-save"></i></button>
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo($status=="_edit"?$datalist[0]->o_id:""); ?>' /> 
			<input type="hidden" id="hdStatus" name="inp_hdStatus" value='<?php echo $status; ?>' />   
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
	    
@endsection