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
        اپراتورهای صف: <?php echo($status=="_edit"?$datalist[0]->q_name:""); ?>
        <small>مرکز تماس</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">مرکز تماس</a></li>
        <li class="active">اپراتورهای صف</li>
      </ol>     
@endsection

@section('maincontent')		
	<div class="box box-info">	
		{{ csrf_field() }}
		<a href="/queues" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">					
			<div id="digitlist">					 
				 <div class="row">				  
				  <div class="col-sm-4">
				    <select class="select2" class="form-control" placeholder="اپراتور" style="width:100%;" id="ddlAgent">														
					<?php foreach ($userlist as $item) { ?>
						<option value="<?php echo $item->sip_number ?>"><?php echo($item->name." ".$item->u_lname."(".$item->sip_number.")"); ?></option>	
					<?php } ?>
					</select>
				  </div>				 
				  <div class="col-sm-4">
					<input class="form-control" style="width:100%;" placeholder="سطح" id="txtLevel" type="number">
				  </div>
				  <div class="col-sm-3">					
					<input class="form-control" style="width:100%;" placeholder="اولویت" id="txtPosition" type="number">
				  </div>
				  <div class="col-sm-1 pull-left">					
					<button id="newDigit" type="button" class="btn btn-primary pull-left" data-toggle="tooltip" title="افزودن" data-original-title="افزودن"><i class="fa fa-plus"></i></button> 
				  </div>
				</div> 					
				<div>
				 <table id="dtDatatable" class="table table-bordered table-hover" style="width:100%">
					<thead>
					<tr>
						<th style='font-weight: bold; text-align: right'>اپراتور</th>
						<th style='font-weight: bold; text-align: right'>اولویت</th>
						<th style='font-weight: bold; text-align: right'>سطح</th>						
						<th style='font-weight: bold; text-align: right'>عملیات</th>								
					</tr>
					</thead>
					<tbody id="spitems">

                    </tbody>      
				 </table>
				</div>
			</div>			
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
		function removeDigitItem(ditem){
			item_id=ditem.id.replace("d_", "");
			$.ajax({
                type: "post",
                url: "/queues/removeagents",
                data: {'Queue': '<?php echo($status=="_edit"?$datalist[0]->q_routeid:""); ?>','Item_id': item_id,'_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (response) {
                    var datas = response;
					if(datas.error=="1"){
						alert(datas.message);
						return;
					}
                    $('#dtDatatable tbody').empty();
                    $.each(datas, function (i, val) {
						$("tbody#spitems").append("<tr id=\"d"+val.t_id+"\">" +
                            "<td style=\"direction:ltr\" class=\"text-center\">"+ val.t_useragent +"</td>"+
						"<td class=\"text-center\">"+ val.t_position + "</td>" +
						"<td class=\"text-center\">"+ val.t_level + "</td>" +						
						"<td><button type=\"button\" onclick=\"confirm('{{ __('callcenter.confirm') }}') ? removeDigitItem(this) : false;\" class=\"btn btn-danger pull-left\" id=\"d_"+val.t_id+"\"><i class=\"fa fa-close\"></i></a></td>"+
                            "</tr>");
                    });
                }
            });
			$("#"+item_id).remove();			
		}
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
			@if($status=="_edit")
            $.ajax({
                type: "post",
                url: "/queues/listagents",
                data: {'Queue': '<?php echo($status=="_edit"?$datalist[0]->q_routeid:""); ?>','_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (response) {
                    var datas = response;
                    $('#dtDatatable tbody').empty();
                    $.each(datas, function (i, val) {
						$("tbody#spitems").append("<tr id=\"d"+val.t_id+"\">" +
                            "<td style=\"direction:ltr\" class=\"text-center\">"+ val.t_useragent +"</td>"+
						"<td class=\"text-center\">"+ val.t_position + "</td>" +
						"<td class=\"text-center\">"+ val.t_level + "</td>" +					
						"<td><button type=\"button\" onclick=\"confirm('{{ __('callcenter.confirm') }}') ? removeDigitItem(this) : false;\" class=\"btn btn-danger pull-left\" id=\"d_"+val.t_id+"\"><i class=\"fa fa-close\"></i></a></td>"+
                            "</tr>");
                    });
                }
            });
			@endif		
			$('#newDigit').click(function () {
				var Agent = $("#ddlAgent").val();
				var Level = $("#txtLevel").val();
				var Position = $("#txtPosition").val();
				
				var data = $("#ddlAgent").select2('data');					
				if(data.length==0){
					alert("اپراتور مورد نظر را انتخاب نمایید");
					return 0;
				}			
				var destText=data[0].text;
				var dmethod = $("#txtmethod").val();
				
				if(Level=="" || Position==""){
					alert("اطلاعات را بصورت کامل وارد نمایید");
					return 0;
				}			
				$.ajax({
					type: "post",
					url: "/queues/editagent",
					data: {'Queue': <?php echo($status=="_edit"?$datalist[0]->q_routeid:""); ?>,'Agent': Agent,'Level': Level,'Position': Position,'_token': $('input[name=_token]').val()},
					dataType: "json",
					success: function (response) {
						var datas = response;
						if(datas.error=="1"){
							alert(datas.message);
							return;
						}
						$("td").remove(".dataTables_empty");
						$('#dtDatatable tbody').empty();
						$.each(datas, function (i, val) {
							$("tbody#spitems").append("<tr id=\"d"+val.t_id+"\">" +
								"<td style=\"direction:ltr\" class=\"text-center\">"+ val.t_useragent +"</td>"+
							"<td class=\"text-center\">"+ val.t_position + "</td>" +
							"<td class=\"text-center\">"+ val.t_level + "</td>" +							
							"<td><button type=\"button\" onclick=\"confirm('{{ __('callcenter.confirm') }}') ? removeDigitItem(this) : false;\" class=\"btn btn-danger pull-left\" id=\"d_"+val.t_id+"\"><i class=\"fa fa-close\"></i></a></td>"+
								"</tr>");
						});  
					}
				});			                            
			});
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