<?php
use App\Http\Controllers\app_code\Permissions;
use App\Http\Controllers\app_code\GClass;
?>

@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> 
	<link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet" />	
@endsection

@section('maincontent')
        <div class="box" style="min-height:650px;overflow:hidden;">
        <div class="box-header">  
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close pull-left" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close pull-left" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>     
            <div class="btn-group pull-left">
                <div class="btn-group">
                <button id="btnAddNew" onclick="actionNewForm();" type="button" class="btn btn-primary pull-left" data-toggle="tooltip" title="{{ __('callcenter.newitem') }}" data-original-title="{{ __('callcenter.newitem') }}"><i class="fa fa-plus"></i></button>
                </div>
                <div class="btn-group">
                <button id="lnkEdit" type="button" class="btn btn-default pull-left" data-toggle="tooltip" title="{{ __('callcenter.edititem') }}" data-original-title="{{ __('callcenter.edititem') }}"><i class="fa fa-edit"></i></button>              
                </div> 
                <div class="btn-group">
                <button id="lnkDelete" type="button" onclick="confirm('{{ __('callcenter.confirm') }}') ? actionDeleteForm() : false;" class="btn btn-danger pull-left" data-toggle="tooltip" title="{{ __('callcenter.deleteitem') }}" data-original-title="{{ __('callcenter.deleteitem') }}"><i class="fa fa-trash"></i></button>              
                </div>   
                                 
            </div>  
        <h1>{{ __('callcenter.inbound.title') }}</h1>
        </div>
        <!-- /.box-header -->
        <form id="frmList" method="POST" action="inbounds" data-toggle="validator" role="form">                                                           
            {{ csrf_field() }}
        <div class="box-body">
            <table id="dtTicketList" class="table table-bordered table-hover" style="width:100%">
            <thead>
            <tr>
                <td class="text-center"></td>      
                <th style='font-size: 13px; font-weight: bold; color: #0033CC;text-align: right'>شماره</th>
                <th style='font-size: 13px; font-weight: bold; color: #0033CC;text-align: right'>نام منشی</th>
                <th style='font-size: 13px; font-weight: bold; color: #0033CC;text-align: right'>صدای ورود</th>
                <th style='font-size: 13px; font-weight: bold; color: #0033CC;text-align: right'>صدای خطا</th>
                <th style='font-size: 14px; font-weight: bold; color: #0033CC;text-align: right'>صدای خروج</th>                                                            
				<th style='font-size: 14px; font-weight: bold; color: #0033CC;text-align: right'>تعداد خطای مجاز</th> 
				<th style='font-size: 14px; font-weight: bold; color: #0033CC;text-align: right'>زمان سرریز</th> 
				<th style='font-size: 14px; font-weight: bold; color: #0033CC;text-align: right'>وقفه بین رقم ها</th> 
				<th style='font-size: 14px; font-weight: bold; color: #0033CC;text-align: right'>تعداد سرریز مجاز</th> 
				<th style='font-size: 14px; font-weight: bold; color: #0033CC;text-align: right'>حداکثر طول شماره</th> 
            </tr>
            </thead>
            <tbody>                
                <?php foreach ($datalist as $item) { ?>
                    <tr>
                        <td class="text-center">
                        <input type="checkbox" name="selected[]" value="<?php echo $item->i_id; ?>" />
                        </td>                                                                  
						<td class="text-right"><?php echo $item->i_id; ?> </td>     
                        <td class="text-right"><?php echo $item->i_name; ?> </td> 
                        <td class="text-right"><?php echo $item->idestinationnumber; ?> </td> 
                        <td class="text-right"><?php echo GClass::getDestinationName($item->idestination); ?> </td> 
                        <td class="text-right"><?php echo $item->idestinationvalue; ?> </td>                                                                                                         
						<td class="text-right"><?php echo $item->username; ?> </td> 
						<td class="text-right"><?php echo ($item->s_name==""?"عمومی":$item->s_name); ?> </td> 
                    </tr>                    
                <?php } ?>
            </tbody>             
            </table>
        </div>
        </form>
        <!-- /.box-body -->

        <script type="text/javascript">
            function openNewForm() {
                $('#NewFormModal').modal('show');
            }
        </script>
        <div class="modal fade" id="NewFormModal" role="dialog">
                <div class="modal-dialog">    
                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('callcenter.inbound.title') }}</h4>
                    </div>
                    <div class="modal-body">   
                        <form id="frmControls" method="POST" action="inbounds?act=add" data-toggle="validator" role="form">                                                           
                            {{ csrf_field() }}
							{{ __('callcenter.inbound.name') }}:
                            <input id="txtName" name="inp_txtName" class="form-control" type="text" required MaxLength="100" />                            
                            {{ __('callcenter.destinationnumber') }}:							
                            <input id="txtDestNumber" name="inp_txtDestNumber" dir="ltr" class="form-control" type="text" required MaxLength="100" />                         
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
                            <input id="txtUsername" name="inp_txtUsername" class="form-control" type="text" MaxLength="100" />                            
                            کلمه عبور:
                            <input id="txtPass" name="inp_txtPass" class="form-control" type="password" MaxLength="100" />                         							
                            <br />
							<br />
                            <button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>
							<input type="hidden" id="hdDesVal" name="inp_hdDesVal" />  
                            <input type="hidden" id="hdID" name="inp_hdID" />    
                        </form>    
                        <script>
                            $('#frmControls input[type=text]').on('change invalid', function() {
                                var textfield = $(this).get(0);
                                textfield.setCustomValidity('');                                
                                if (!textfield.validity.valid) {
                                textfield.setCustomValidity('{{ __('callcenter.infoadditem') }}.');  
                                }
                            });

                        </script>                                             
                    </div>
                    </div>
      
                </div>
                </div> 
        </div>
        <div id="ajaxWait" class="ajaxLoaderFull" style="display: none";>
            <img src="images/ajax-loader.gif" style="position: absolute;left: 45%;top: 35%;" />
        </div>
@endsection

@section('footerscript')
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	<script src='../vendors/select2/dist/js/select2.min.js'></script>
    <script>
	  $(document).ready(function() {
		  $(".select2").select2({
			dropdownParent: $("#NewFormModal")
		  });
		});
	</script>
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
                url: "{{ url('/') }}/inbounds/getdest",
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
        function actionDeleteForm(){
            $("#frmList").attr('action', 'inbounds?act=delete');
            $("#frmList").submit();
        }
        function actionNewForm(){
            $("#txtName").val('');
            $("#txtFamily").val('');
            $("#txtUserName").val('');
            $("#txtPass").val('');
            $("#txtPassRE").val('');
            $("#txtDes").val('');
            $("#txtMobile").val('');
            $("#txteMail").val('');
            $("#hdID").val('');
            openNewForm(); 
        }
        $(document).ajaxStart(function(){           
            $("#ajaxWait").css("display", "block");
        });

        $(document).ajaxComplete(function(){
            $("#ajaxWait").css("display", "none");
        });
        $(document).ready(function(){    
			$("#ddlDestination").trigger('change');
            $("#lnkEdit").click(function(){
                var item_id='';
                data_array = $("#frmList").serializeArray();
                $.each(data_array, function (i, input) {
                    if(input.name=="selected[]")
                    {                        
                        item_id=input.value;
                        return false;
                    }                    
                });  
                if(item_id!=''){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "post",
                        url: "inbounds/getdata",
                        data: {'item_id': item_id,'_token': $('input[name=_token]').val()},
                        dataType: "json",
                        success: function (response) {							
                            var datas = response;
							console.log("hello");
                            $("#txtName").val(datas.iname);    							
                            $("#txtDestNumber").val(datas.idestinationnumber.replace("/","\\"));  
							$("#txtUsername").val(datas.username); 
							$("#ddlServers").val(datas.context);    
							$("#ddlServers").trigger('change');
                            $("#ddlDestination").val(datas.idestination);    
							$("#ddlDestination").trigger('change');							
							$("#hdDesVal").val(datas.idestinationvalue);                            
                            $("#hdID").val(datas.icode);                    
                        }
                    });
                    openNewForm();                   
                }
            });       
        });
    </script>
    <script>
      $(function () {
          $('#dtTicketList').DataTable({
              "searching": true,              
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