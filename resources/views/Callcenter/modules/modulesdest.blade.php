<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css"/>	
    <style>
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
	</style>
@endsection

@section('pageheadercontent')
      <h1>
        افزونه ها
        <small>مرکز تماس</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">مرکز تماس</a></li>
        <li class="active">افزونه ها</li>
      </ol>     
@endsection

@section('maincontent')		
	<div class="box box-info">		
		<a href="/module" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/module" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}			
			گام ها:			
			<div id="digitlist">					 
				 <div class="row">				  				  
				  <div class="col-sm-2"><input class="form-control" placeholder="خروجی ماژول" id="pvalue" style="width:100%;direction:ltr;" type="text"></div>				 
				  <div class="col-sm-3">
					<select name="grp_ddlDestination" id="ddlDestination"  class="form-control" style="width: 100%;">																
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
				  </div>
				  <div class="col-sm-3">
					<select class="select2" class="form-control" placeholder="مقصد" style="width:100%;" id="ddlDestValue">														
					</select>
				  </div>
				  <div class="col-sm-3">					
					<input class="form-control" style="width:100%;direction:ltr;" placeholder="متد" id="txtmethod" name="method" type="text">
				  </div>
				  <div class="col-sm-1">					
					<button id="newDigit" type="button" class="btn btn-default pull-left" data-toggle="tooltip" title="جدید" data-original-title="جدید"><i class="fa fa-plus"></i></button> 
				  </div>
				</div> 	
				<div>
				 <table id="dtDatatable" class="table table-bordered table-hover" style="width:100%">
					<thead>
					<tr>						
						<th style='font-weight: bold; text-align: right'>خروجی ماژول</th>
						<th style='font-weight: bold; text-align: right'>مقصد</th>
						<th style='font-weight: bold; text-align: right'>مقدار مقصد</th>
						<th style='font-weight: bold; text-align: right'>متد</th>
						<th style='font-weight: bold; text-align: right'>عملیات</th>								
					</tr>
					</thead>
					<tbody id="spitems">

                    </tbody>      
				 </table>
				</div>
			</div>
			<br />
			<button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button> 
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo $item_id; ?>' />    
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
	<script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src='/bower_components/select2/dist/js/select2.min.js'></script>
    <script>
		$(document).ready(function() {
			  $(".select2").select2();
		});
		
		function removeDigitItem(ditem){
			item_id=ditem.id.replace("_", "");
			$("#"+item_id).remove();			
		}
	</script>
	<script>	
		$('#newDigit').click(function () {
            var params = $("#params").val();
			var pvalue = $("#pvalue").val();
            var destination = $("#ddlDestination").val();
			var destValue = $("#ddlDestValue").val();
			var data = $("#ddlDestValue").select2('data');		
			var itemid=Math.floor((Math.random() * 9999999) + 1000000);
			if(data.length==0){
				alert("مقصد نمی تواند خالی باشد");
				return 0;
			}			
			var destText=data[0].text;
			var dmethod = $("#txtmethod").val();
			
			if(params==""){
				alert("پارامتر نمی تواند خالی باشد");
				return 0;
			}
			if(pvalue==""){
				alert("خروجی ماژول نمی تواند خالی باشد");
				return 0;
			}
			if(destValue==""){
				alert("مقصد نمی تواند خالی باشد");
				return 0;
			}
			$.ajax({
                type: "post",
                url: "/init/actname",
                data: {'item_id': destination,'_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (response) {
                    var datas = response;
                    $("td").remove(".dataTables_empty");
					$("tbody#spitems").append("<tr id=\"d"+itemid+"\">" +						
						"<td class=\"text-center\">"+ pvalue +"</td>"+
						"<td class=\"text-center\">"+ datas.item_value + "</td>" +
						"<td class=\"text-center\">"+ destText + "</td>" +
						"<td class=\"text-center\">"+ dmethod + "<input type=\"hidden\" id=\"modacts\" name=\"modactions[]\" value=\""+pvalue+","+destination+","+destValue+","+dmethod+"\" /> </td>" +
						"<td><button type=\"button\" onclick=\"return removeDigitItem(this)\" class=\"btn btn-danger pull-left\" id=\"d_"+itemid+"\"><i class=\"fa fa-close\"></i></a></td>"+
						"</tr>");        
                }
            });			                            
        });
		function clearList(dList){            
            obj = document.getElementById(dList);
            while (obj.options.length) {
                obj.remove(0);
            }                      
        }
		$(document).ready(function(){    			
			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });			
            $.ajax({
                type: "post",
                url: "/module/actions",
                data: {'item_id': '<?php echo $item_id; ?>','_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (response) {
                    var datas = response;
                    $('#dtDatatable tbody').empty();
                    $.each(datas, function (i, val) {
						$("tbody#spitems").append("<tr id=\"d"+val.mv_id+"\">" +                       
						"<td style=\"direction:ltr\" class=\"text-center\">"+ val.mv_value +"</td>"+
						"<td class=\"text-center\">"+ val.mv_desttext + "</td>" +
						"<td class=\"text-center\">"+ val.a_destvaluetext + "</td>" +
						"<td style=\"direction:ltr\" class=\"text-center\">"+ val.mv_destmethod + "<input type=\"hidden\" id=\"modacts\" name=\"modactions[]\" value=\""+val.mv_value+","+val.mv_dest+","+val.mv_destvalue+","+val.mv_destmethod+"\" /> </td>" +
						"<td><button type=\"button\" onclick=\"return removeDigitItem(this)\" class=\"btn btn-danger pull-left\" id=\"d_"+val.mv_id+"\"><i class=\"fa fa-close\"></i></a></td>"+
                            "</tr>");
                    });
                }
            });
			$('#ddlDestination').change(function(){
				$.ajax({
					type: "post",
					url: "/init/getdest",
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
						}					
					}
				});
			});			
			$("#ddlDestination").trigger('change');
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