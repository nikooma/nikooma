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
        {{ __('callcenter.manageusers.title') }}
        <small>کاربران</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">کاربران</a></li>
        <li class="active">مدیریت کاربران</li>
      </ol>    
@endsection

@section('maincontent')		
	<div class="box box-info">		
		<a href="/server" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/server" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			نام سرور:
			<input id="txtName" name="inp_txtName" value='<?php echo($status=="_edit"?$datalist[0]->s_name:""); ?>' class="form-control" type="text" required MaxLength="100" />                            
			دامنه:							
			<input id="txtِDomain" value='<?php echo($status=="_edit"?$datalist[0]->s_domain:""); ?>' name="inp_txtِDomain" dir="ltr" class="form-control" type="text" required MaxLength="255" />                         
			
			<br />						
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo($status=="_edit"?$datalist[0]->icode:""); ?>' /> 
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
	<script src='/bower_components/select2/dist/js/select2.min.js'></script>
    <script>
		function clearList(dList){            
            obj = document.getElementById(dList);
            while (obj.options.length) {
                obj.remove(0);
            }                      
        }		
		$(document).ready(function() {		
			$(".select2").select2();
		});
	</script>	
@endsection