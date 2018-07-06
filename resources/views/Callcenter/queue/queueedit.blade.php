<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css"/>	
    <style>
		.row{
			margin-left: 0;
			margin-right: 0;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		.center-frame{
			width: 70%;
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
		.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
		  position: relative;
		  min-height: 1px;
		  padding-left: 5px;
		  padding-right: 5px;
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
        صف انتظار
        <small>مرکز تماس</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">مرکز تماس</a></li>
        <li class="active">صف انتظار</li>
      </ol>      
@endsection

@section('maincontent')
	<div class="box box-info">		
		<a href="/queues" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/queues" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			نام صف:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->q_name:""); ?>' type="text" required MaxLength="100" />
			صدای اتصال:
			<select id="ddlConSound" class="form-control select2" required style="width: 100%;" name="inp_ddlConSound">								
				<option value="0" selected="selected">---بدون صدای اتصال---</option>	
				<?php foreach ($sndlist as $item) { ?>
				<option value="<?php echo $item->s_id ?>"><?php echo $item->s_name; ?></option>	
				<?php }	?>
			</select>		
			آهنگ انتظار:
			<select id="ddlMOH" class="form-control select2" required style="width: 100%;" name="inp_ddlMOH">								
				<?php foreach ($mohlist as $item) { ?>
				<option value="<?php echo $item->m_id ?>"><?php echo $item->m_name; ?></option>	
				<?php }	?>
			</select>		
			استراتژی اتصال:
			<select id="ddlStrategy" class="form-control" style="width: 100%;" required name="inp_ddlStrategy">								
				<option value="ring-all">ارسال تماس برای همه</option>									
				<option value="longest-idle-agent">اپراتور با زمان تنفس بالا</option>				
				<option value="top-down" selected="selected">تماس به نوبت</option>
				<option value="agent-with-least-talk-time">اپراتور با کمترین زمان مکالمه</option>
				<option value="agent-with-fewest-calls">اپراتور با کمترین تعداد پاسخگویی</option>
				<option value="sequentially-by-agent-order">تماس به ترتیب ردیف صف ها</option>
				<option value="random">تماس تصادفی</option>				
			</select>		
			حداکثر انتظار(ثانیه):	
			<input id="txtMaxwaittime" name="inp_txtMaxwaittime" class="form-control" type="number" value='<?php echo($status=="_edit"?$datalist[0]->q_maxwaittime:""); ?>' required MaxLength="10" />
			حداکثر انتظار بدون پاسخگو(ثانیه):	
			<input id="txtMaxwaitnoagent" name="inp_txtMaxwaitnoagent" class="form-control" type="number" value='<?php echo($status=="_edit"?$datalist[0]->q_maxwaitnoagent:""); ?>' required MaxLength="10" />
			طول حداکثر انتظار بدون پاسخگو(ثانیه):	
			<input id="txtMaxwaitnoagentriched" name="inp_txtMaxwaitnoagentriched" class="form-control" type="number" value='<?php echo($status=="_edit"?$datalist[0]->q_maxwaitnoagentriched:""); ?>' required MaxLength="10" />				
			<div class="row">
				<div class="col-sm-3">
					نبود پاسخگو عدم انتظار:
				</div>			
				<div class="col-sm-1 material-switch">
					<input id="tierrulenoagentnowait" name="inp_Tierrulenoagentnowait" <?php echo ($status=="_edit" && $datalist[0]->q_tierrulenoagentnowait=="on"?"checked=\"checked\"":""); ?> type="checkbox"/>
					<label for="tierrulenoagentnowait" class="label-primary"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					انتظار بازگشت:
				</div>			
				<div class="col-sm-1 material-switch">
					<input id="abandonedresumeallowed" name="inp_Abandonedresumeallowed" <?php echo ($status=="_edit" && $datalist[0]->q_abandonedresumeallowed=="on"?"checked=\"checked\"":""); ?> type="checkbox"/>
					<label for="abandonedresumeallowed" class="label-primary"></label>
				</div>
			</div>
			زمان انتظار بازگشت(ثانیه):	
			<input id="txtDiscardabandonedafter" name="inp_txtDiscardabandonedafter" class="form-control" type="number" value='<?php echo($status=="_edit"?$datalist[0]->q_discardabandonedafter:""); ?>' required MaxLength="10" />
			اطلاعیه:	
			<select id="ddlAnnouncesound" class="form-control select2" style="width: 100%;" required name="inp_ddlAnnouncesound">								
				<option value="0">---بدون صدای اطلاعیه---</option>	
				<?php foreach ($sndlist as $item) { ?>
				<option value="<?php echo $item->s_id ?>"><?php echo $item->s_name; ?></option>	
				<?php }	?>
			</select>
			زمان تکرار اطلاعیه(ثانیه):	
			<input id="txtAnnouncefrequency" name="inp_txtAnnouncefrequency" class="form-control" type="number" value='<?php echo($status=="_edit"?$datalist[0]->q_announcefrequency:""); ?>' required MaxLength="10" />		
			حداکثر ظرفیت صف:
			<input id="txtMaxlen" name="inp_txtMaxlen" class="form-control" type="number" value='<?php echo($status=="_edit"?$datalist[0]->q_maxlen:""); ?>' required MaxLength="10" />					
			پس از صف-موفق:
			<div class="row">				  			  
			  <div class="col-sm-4">
				<select name="grp_ddlSDestination" id="ddlSDestination" required class="form-control" style="width: 100%;">																
					<option value="toagent" selected="selected">{{ __('callcenter.toagent') }}</option>									
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
			  </div>
			  <div class="col-sm-4">
				<select class="select2" class="form-control" placeholder="مقصد" required style="width:100%;" id="ddlSDestValue" name="inp_ddlSDestValue">														
				</select>
			  </div>
			  <div class="col-sm-4">					
				<input class="form-control" style="width:100%;direction:ltr;" value='<?php echo($status=="_edit"?$datalist[0]->q_aftersuccessmethod:""); ?>' placeholder="متد" id="txtSmethod" name="Smethod" type="text">
			  </div>			 
			</div>	
			پس از صف-ظرفیت تکمیل:
			<div class="row">				  			  
			  <div class="col-sm-4">
				<select name="grp_ddlMDestination" id="ddlMDestination" required class="form-control" style="width: 100%;">																
					<option value="toagent" selected="selected">{{ __('callcenter.toagent') }}</option>									
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
			  </div>
			  <div class="col-sm-4">
				<select class="select2" class="form-control" placeholder="مقصد" style="width:100%;" required id="ddlMDestValue" name="inp_ddlMDestValue">														
				</select>
			  </div>
			  <div class="col-sm-4">					
				<input class="form-control" style="width:100%;direction:ltr;" value='<?php echo($status=="_edit"?$datalist[0]->q_aftermaxmethod:""); ?>' placeholder="متد" id="txtMmethod" name="Mmethod" type="text">
			  </div>			 
			</div>	
			پس از صف-ناموفق:
			<div class="row">				  			  
			  <div class="col-sm-4">
				<select name="grp_ddlDDestination" id="ddlDDestination" required class="form-control" style="width: 100%;">																
					<option value="toagent" selected="selected">{{ __('callcenter.toagent') }}</option>									
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
			  </div>
			  <div class="col-sm-4">
				<select class="select2" class="form-control" placeholder="مقصد" required style="width:100%;" id="ddlDDestValue" name="inp_ddlDDestValue">														
				</select>
			  </div>
			  <div class="col-sm-4">					
				<input class="form-control" style="width:100%;direction:ltr;" value='<?php echo($status=="_edit"?$datalist[0]->q_afterfailedmethod:""); ?>' placeholder="متد" id="txtDmethod" name="Dmethod" type="text">
			  </div>			  
			</div>
			<br />
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button> 
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo $item_id; ?>' />    
			<input type="hidden" id="hdStatus" name="inp_hdStatus" value='<?php echo $status; ?>' />   
		  </form>    
			<script>
				$('#frmControls input[type=text],input[type=number],select').on('change invalid', function() {
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
	<script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src='/bower_components/select2/dist/js/select2.min.js'></script>
    <script>
		$(document).ready(function() {
			  $(".select2").select2();
		});
	</script>
	<script>			
		function clearList(dList){            
            obj = document.getElementById(dList);
            while (obj.options.length) {
                obj.remove(0);
            }                      
        }
		$(document).ready(function(){    			
			$('#ddlConSound').val('<?php echo ($status=="_edit"?$datalist[0]->q_startsound:""); ?>'); 					
			$('#ddlConSound').trigger('change');	
			$('#ddlAnnouncesound').val('<?php echo ($status=="_edit"?$datalist[0]->q_announcesound:""); ?>'); 						
			$('#ddlAnnouncesound').trigger('change');	
			
			$('#ddlSDestination').val('<?php echo ($status=="_edit"?$datalist[0]->q_aftersuccess:""); ?>'); 					
			$('#ddlSDestination').trigger('change');	
			$('#ddlSDestValue').val('<?php echo ($status=="_edit"?$datalist[0]->q_aftersuccessvalue:""); ?>'); 						
			$('#ddlSDestValue').trigger('change');		
			
			$('#ddlDDestination').val('<?php echo ($status=="_edit"?$datalist[0]->q_afterfailed:""); ?>'); 					
			$('#ddlDDestination').trigger('change');	
			$('#ddlDDestValue').val('<?php echo ($status=="_edit"?$datalist[0]->q_afterfailedvalue:""); ?>'); 						
			$('#ddlDDestValue').trigger('change');		
			
			$('#ddlMDestination').val('<?php echo ($status=="_edit"?$datalist[0]->q_aftermax:""); ?>'); 					
			$('#ddlMDestination').trigger('change');	
			$('#ddlMDestValue').val('<?php echo ($status=="_edit"?$datalist[0]->q_aftermaxvalue:""); ?>'); 						
			$('#ddlMDestValue').trigger('change');		
			
			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });			
			$('#ddlSDestination').change(function(){
				$.ajax({
					type: "post",
					url: "/init/getdest",
					data: {'coontext': '0','item_id': $('#ddlSDestination').val(),'_token': $('input[name=_token]').val()},
					dataType: "json",
					success: function (response) {
						clearList("ddlSDestValue"); 
						var datas = response;                      
						if(datas.length>0){
							for (var j_q = 0; j_q < datas.length; j_q++) {                         
								var opt = document.createElement("option"); 							                  
								opt.value = datas[j_q].item_id;
								opt.text = datas[j_q].item_value;
								document.getElementById("ddlSDestValue").options.add(opt);                                           
							}							
						}					
					}
				});
			});	
			$('#ddlDDestination').change(function(){
				$.ajax({
					type: "post",
					url: "/init/getdest",
					data: {'coontext': '0','item_id': $('#ddlDDestination').val(),'_token': $('input[name=_token]').val()},
					dataType: "json",
					success: function (response) {
						clearList("ddlDDestValue"); 
						var datas = response;                      
						if(datas.length>0){
							for (var j_q = 0; j_q < datas.length; j_q++) {                         
								var opt = document.createElement("option"); 							                  
								opt.value = datas[j_q].item_id;
								opt.text = datas[j_q].item_value;
								document.getElementById("ddlDDestValue").options.add(opt);                                           
							}							
						}					
					}
				});
			});	
			$('#ddlMDestination').change(function(){
				$.ajax({
					type: "post",
					url: "/init/getdest",
					data: {'coontext': '0','item_id': $('#ddlMDestination').val(),'_token': $('input[name=_token]').val()},
					dataType: "json",
					success: function (response) {
						clearList("ddlMDestValue"); 
						var datas = response;                      
						if(datas.length>0){
							for (var j_q = 0; j_q < datas.length; j_q++) {                         
								var opt = document.createElement("option"); 							                  
								opt.value = datas[j_q].item_id;
								opt.text = datas[j_q].item_value;
								document.getElementById("ddlMDestValue").options.add(opt);                                           
							}							
						}					
					}
				});
			});	
			$("#ddlSDestination").trigger('change');
			$("#ddlDDestination").trigger('change');
			$("#ddlMDestination").trigger('change');
		});
	</script>	
	<script>
      $(function () {
          $('#dtDatatable').DataTable({
              "searching": false,    
			  "bPaginate": false,
			  "bInfo" : false,
			  "sZeroRecords" : false,
              "language":
                  {
                    "emptyTable":       "<center>هیچ اطلاعاتی یافت نشد</center>",
                    "info":             "نمایش رکوردهای _START_ تا _END_ از مجموع _TOTAL_",
                    "infoEmpty":        "نمایش 0 تا 0 از 0",
                    "infoFiltered":     "(filtered from _MAX_ total entries)",
                    "infoPostFix": "",
                    "lengthMenu":       "نمایش _MENU_ رکورد در هر صفحه",
                    "loadingRecords":   "درحال بارگزاری...",
                    "processing":       "درحال انجام عملیات...",
                    "search":           "جستجو :",
                    "zeroRecords":      "هیچ اطلاعاتی یافت نشد.",
                    "paginate": {
                        "first":        "اولین",
                        "previous":     "قبلی",
                        "next":         "بعدی",
                        "last":         "آخرین"
                    },
                    "aria": {
                        "sortAscending":    ": ترتیب بندی سعودی",
                        "sortDescending":   ": ترتیب بندی نزولی"
                    },
                    "decimal":          "",
                    "thousands":        ","
                }
          });
      });
    </script>
@endsection