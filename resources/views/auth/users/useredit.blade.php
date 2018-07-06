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
		<a href="/manageusers" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/manageusers" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			{{ __('callcenter.namefamily') }}:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->name:""); ?>' type="text" required MaxLength="50" />
			{{ __('callcenter.family') }}:
			<input id="txtFamily" name="inp_txtFamily" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->u_lname:""); ?>' type="text" required MaxLength="50" />
			{{ __('callcenter.username') }}:
			<input id="txtUserName" name="inp_txtUserName" class="form-control" type="text" value='<?php echo($status=="_edit"?$datalist[0]->username:""); ?>' required MaxLength="50" />		
			@if(Permissions::permissionCheck('23','06')==1)
			{{ __('callcenter.group') }}:							
			<select id="ddlgroups" class="form-control select2" style="width: 100%;" name="groups[]" multiple="multiple">								
				<?php foreach ($grplist as $item) { ?>
				<option value="<?php echo $item->id ?>"><?php echo $item->name; ?></option>	
				<?php }	?>
			</select>							
			@endif							
			{{ __('callcenter.password') }}:
			<input id="txtPass" name="inp_txtPass" class="form-control" type="password"  <?php echo($status=="_edit"?"":"required"); ?> MaxLength="50" />
			{{ __('callcenter.repassword') }}:
			<input id="txtPassRE" name="inp_txtPassRE" class="form-control" type="password" <?php echo($status=="_edit"?"":"required"); ?> MaxLength="50" />
			{{ __('callcenter.mobile') }}:
			<input id="txtMobile" name="inp_txtMobile" value='<?php echo($status=="_edit"?$datalist[0]->u_mobilenumber:""); ?>' class="form-control" type="text" required MaxLength="15" />
			{{ __('callcenter.email') }}:
			<input id="txteMail" name="inp_txteMail" value='<?php echo($status=="_edit"?$datalist[0]->email:""); ?>' class="form-control" type="text" required MaxLength="255" />                          
			<br />
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo($status=="_edit"?$datalist[0]->id:""); ?>' />    
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
		$(document).ready(function() {
			  $(".select2").select2();
		});
	</script>
	@if($status=="_edit")
		<script>			
			<?php 
			$grp='[';
			foreach ($usergrplist as $group){
				$grp.=$group->group_id.',';
			}
			$grp=rtrim($grp,",")."]";
			?>
			$(document).ready(function(){    
				$('#ddlgroups').val(<?php echo $grp; ?>); 						
				$('#ddlgroups').trigger('change');					
			});
		</script>
	@endif		
@endsection