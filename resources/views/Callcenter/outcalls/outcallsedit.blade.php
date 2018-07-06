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
		<a href="/outcalls" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/outcalls" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			نام تماس:
			<input id="txtName" name="inp_txtName" value='<?php echo($status=="_edit"?$datalist[0]->oc_name:""); ?>' class="form-control" type="text" required MaxLength="100" />                            			
			زمان انقضاء تماس(ثانیه):
			<input id="txtTimeout" value='<?php echo($status=="_edit"?$datalist[0]->oc_timeout:"60"); ?>' name="inp_txtTimeout" dir="ltr" class="form-control" required type="number" MaxLength="100" />                         
			کد کننده تماس:
			<select id="ddlCodec" class="form-control select2" style="width: 100%;" name="inp_ddlCodec">
				<option value="PCMA">PCMA</option>
				<option value="PCMU">PCMU</option>
				<option value="OPUS">OPUS</option>
				<option value="iSAC">iSAC</option>
				<option value="CODEC2">CODEC2 2550bps 8000hz 20ms</option>
				<option value="SILK">SILK Skype Audio codec</option>
				<option value="iLBC@30i">iLBC@30i</option>
				<option value="Speex">Speex</option>
				<option value="BV32">BV32</option>
				<option value="BV16">BV16</option>
				<option value="Siren">Siren</option>
				<option value="CELT">CELT</option>
				<option value="DVI">DVI</option>
				<option value="GSM">GSM</option>
				<option value="G722">G722</option>
				<option value="G.726">G.726</option>
				<option value="LPC">LPC</option>
				<option value="G729">G729</option>
				<option value="L16">L16</option>				
			</select>
			مسیر خروجی:
			<select id="ddlOutbound" class="form-control select2" style="width: 100%;" name="inp_ddlOutbound">				
				<?php foreach ($outblist as $item) { ?>
				<option value="<?php echo $item->o_id ?>"><?php echo $item->o_name; ?></option>	
				<?php } ?>
			</select>
			<div class="row">
				<div class="col-sm-3">
					صرفنظر از مسیر صوتی:	
				</div>			
				<div class="col-sm-1 material-switch">
					<input id="bypassmedia" name="inp_bypassmedia" <?php echo ($status=="_edit" && $datalist[0]->oc_bypassmedia=="on"?"checked=\"checked\"":""); ?> type="checkbox"/>
					<label for="bypassmedia" class="label-primary"></label>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-sm-3">
					مسیر بدون نویز می باشد:	
				</div>			
				<div class="col-sm-1 material-switch">
					<input id="confortnoise" name="inp_confortnoise" <?php echo ($status=="_edit" && $datalist[0]->oc_confortnoise=="on"?"checked=\"checked\"":""); ?> type="checkbox"/>
					<label for="confortnoise" class="label-primary"></label>
				</div>
			</div>			
			پس از تماس:                            
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
			مقصد:
			<select name="grp_ddlDestValue" id="ddlDestValue"  class="form-control select2" style="width: 100%;">								    								
			</select> 
			متد:
			<input id="txtMethod" value='<?php echo($status=="_edit"?$datalist[0]->oc_aftervalmet:""); ?>' name="inp_txtMethod" class="form-control" type="text" MaxLength="100" />                            			
			<br />
			<br />						
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo($status=="_edit"?$datalist[0]->oc_id:""); ?>' /> 
			<input type="hidden" id="hdStatus" name="inp_hdStatus" value='<?php echo $status; ?>' />   
		  </form>    
			<script>
				$('#frmControls input[type=text] input[type=number]').on('change invalid', function() {
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
		$('#ddlDestination').change(function(){
            $.ajax({
                type: "post",
                url: "{{ url('/') }}/init/getdest",
                data: {'coontext': '0','item_id': $('#ddlDestination').val(),'_token': $('input[name=_token]').val()},
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
			$("#ddlDestination").trigger('change');
			@if($status=="_edit")					  							
				$('#ddlDestination').val("<?php echo $datalist[0]->oc_afterdes; ?>"); 		
				$("#ddlDestination").trigger('change');
				$('#ddlDestValue').val("<?php echo $datalist[0]->oc_afterval; ?>"); 		
				$("#ddlDestValue").trigger('change');				
			@endif				
			$(".select2").select2();
		});
	</script>	
@endsection