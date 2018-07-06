@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> 	
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
        <h1>{{ __('callcenter.groups.title') }}</h1>
        </div>
        <!-- /.box-header -->
        <form id="frmList" method="POST" action="server" data-toggle="validator" role="form">                                                           
            {{ csrf_field() }}
        <div class="box-body">
            <table id="dtDatatable" class="table table-bordered table-hover" style="width:100%">
            <thead>
            <tr>
                <td style='width:15px;' class="text-center"></td>
				<th style='font-size: 13px; font-weight: bold; color: #0033CC;text-align: right'>{{ __('callcenter.itemid') }}</th>
                <th style='font-size: 13px; font-weight: bold; color: #0033CC;text-align: right'>{{ __('callcenter.groupname') }}</th>                                
				<th style='font-size: 13px; font-weight: bold; color: #0033CC;text-align: right'>{{ __('callcenter.description') }}</th>                                
            </tr>
            </thead>
            <tbody>                
                <?php foreach ($datalist as $item) { ?>
                    <tr>
                        <td class="text-center">
                        <input type="checkbox" name="selected[]" value="<?php echo $item->s_id; ?>" />
                        </td>                                                          
						<td class="text-right"><?php echo $item->s_id; ?> </td>     
                        <td class="text-right"><?php echo $item->s_name; ?> </td>                      				
						<td class="text-right"><?php echo $item->s_domain; ?> </td> 
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
                        <h4 class="modal-title">{{ __('callcenter.groups.name') }}</h4>
                    </div>
                    <div class="modal-body">   
                        <form id="frmControls" method="POST" action="server?act=add" data-toggle="validator" role="form">                                                           
                            {{ csrf_field() }}
                            {{ __('callcenter.groupname') }}:
                            <input id="txtName" name="inp_txtName" class="form-control" type="text" required MaxLength="100" />
                            {{ __('callcenter.description') }}:
                            <input id="txtDomain" name="inp_txtDomain" class="form-control" required MaxLength="50" />						
                            <br />
                            <button type="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>
                            <input type="hidden" id="hdID" name="inp_hdID" />    
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
    <script>
        function actionDeleteForm(){
            $("#frmList").attr('action', 'server?act=delete');
            $("#frmList").submit();
        }
        function actionNewForm(){
            $("#txtName").val('');
            $("#txtDomain").val('');           
            $("#hdID").val('');
            openNewForm();              
        }
        $(document).ajaxStart(function(){
            $("#txtName").val('');
            $("#txtDomain").val('');                     
            $("#ajaxWait").css("display", "block");
        });

        $(document).ajaxComplete(function(){
            $("#ajaxWait").css("display", "none");
        });
        $(document).ready(function(){            
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
                        url: "server/getdata",
                        data: {'item_id': item_id,'_token': $('input[name=_token]').val()},
                        dataType: "json",
                        success: function (response) {
                            var datas = response;
                            $("#txtName").val(datas.s_name);    
                            $("#txtDomain").val(datas.s_domain);                                                         
                            $("#hdID").val(datas.s_id);                    
                        }
                    });
                    openNewForm();                      
                }
            });       
        });
    </script>
    <script>
      $(function () {
          $('#dtDatatable').DataTable({
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