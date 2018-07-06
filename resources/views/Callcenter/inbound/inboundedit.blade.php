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
		<a href="/inbounds" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/inbounds" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			{{ __('callcenter.inbound.name') }}:
			<input id="txtName" name="inp_txtName" value='<?php echo($status=="_edit"?$datalist[0]->iname:""); ?>' class="form-control" type="text" required MaxLength="100" />                            
			{{ __('callcenter.destinationnumber') }}:							
			<input id="txtDestNumber" value='<?php echo($status=="_edit"?$datalist[0]->idestinationnumber:""); ?>' name="inp_txtDestNumber" dir="ltr" class="form-control" type="text" required MaxLength="100" />                         
			سرور تلفنی:							
			<select id="ddlServers" class="form-control select2" style="width: 100%;" name="inp_ddlServers">
				<option value="0">---عمومی---</option>
				<?php foreach ($srvlist as $item) { ?>
				<option value="<?php echo $item->s_id ?>"><?php echo $item->s_name; ?></option>	
				<?php } ?>
			</select>
			{{ __('callcenter.destination') }}:                            
			<select name="grp_ddlDestination" id="ddlDestination"  class="form-control select2" style="width: 100%;">																
				<option value="toagent">{{ __('callcenter.toagent') }}</option>									
				<option value="toivr">{{ __('callcenter.toivr') }}</option>
				<option value="toqueue">{{ __('callcenter.toqueue') }}</option>
				<option value="tooutcall">{{ __('callcenter.tooutcall') }}</option>
				<option value="tovoicemail">{{ __('callcenter.tovoicemail') }}</option>
				<option value="tomodule">{{ __('callcenter.tomodule') }}</option>
				<option value="totrunk">{{ __('callcenter.totrunk') }}</option>
				<option value="totimeline">{{ __('callcenter.totimeline') }}</option>
				<option value="tonotification">{{ __('callcenter.tonotification') }}</option>
				<option value="todialplan">{{ __('callcenter.todialplan') }}</option>
				<option value="playsound">{{ __('callcenter.playsound') }}</option>
				<option value="hangup">{{ __('callcenter.hangup') }}</option>								
			</select>
			{{ __('callcenter.destinationvalue') }}:
			<select name="grp_ddlDestValue" id="ddlDestValue"  class="form-control select2" style="width: 100%;">								    								
			</select> 
			نام کاربری:
			<input id="txtUsername" value='<?php echo($status=="_edit"?$datalist[0]->username:""); ?>' name="inp_txtUsername" class="form-control" type="text" MaxLength="100" />                            
			کلمه عبور:
			<input id="txtPass" name="inp_txtPass" class="form-control" type="password" MaxLength="100" />                         							
			<br />
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
		$('#ddlServers').change(function(){
			$("#ddlDestination").change();
		});
		$('#ddlDestination').change(function(){
            $.ajax({
                type: "post",
                url: "{{ url('/') }}/init/getdest",
                data: {'coontext': $('#ddlServers').val(),'item_id': $('#ddlDestination').val(),'_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (response) {
					clearList("ddlDestValue"); 
                    var datas = response;                      
					if(datas.length>0){
						for (var j_q = 0; j_q < datas.length; j_q++) {                         
							var opt = document.createElement("option"); 							                  
							opt.value = datas[j_q].item_id;
							opt.text = datas[j_q].item_value;
							document.getElementById("ddlDestValue").options.add(opt);                                           
						}
						$("#ddlDestValue").val(document.getElementById("hdDesVal").value);  
						$("#ddlDestValue").trigger('change');						
						$("#ddlDestValue").change();
					}					
                }
            });
        });
		$(document).ready(function() {
			$('#ddlServers').trigger('change');		
			@if($status=="_edit")					  				
				$('#ddlServers').val(<?php echo $datalist[0]->context; ?>); 						
				$('#ddlServers').trigger('change');		
				$('#ddlDestination').val("<?php echo $datalist[0]->idestination; ?>"); 		
				$("#ddlDestination").trigger('change');
				$('#ddlDestValue').val("<?php echo $datalist[0]->idestinationvalue; ?>"); 		
				$("#ddlDestValue").trigger('change');
				
			@endif		
			$(".select2").select2();			
		});
	</script>	
@endsection