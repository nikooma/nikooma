<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css"/>		
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
				@if(Permissions::permissionCheck('23','05')==1)
                <div class="btn-group">
                <a id="btnAddNew" href="/queues/addnew" type="button" class="btn btn-primary pull-left" data-toggle="tooltip" title="{{ __('callcenter.newitem') }}" data-original-title="{{ __('callcenter.newitem') }}">{{ __('callcenter.newitem') }} <i class="fa fa-plus"></i></a>
                </div>
				@endif
				@if(Permissions::permissionCheck('23','03')==1)
                <div class="btn-group">
                <button id="lnkEdit" type="button" class="btn btn-default pull-left" data-toggle="tooltip" title="{{ __('callcenter.edititem') }}" data-original-title="{{ __('callcenter.edititem') }}">{{ __('callcenter.edititem') }} <i class="fa fa-edit"></i></button>              
                </div> 
				@endif
				@if(Permissions::permissionCheck('23','04')==1)
                <div class="btn-group">
                <button id="lnkDelete" type="button" onclick="confirm('{{ __('callcenter.confirm') }}') ? actionDeleteForm() : false;" class="btn btn-danger pull-left" data-toggle="tooltip" title="{{ __('callcenter.deleteitem') }}" data-original-title="{{ __('callcenter.deleteitem') }}">{{ __('callcenter.deleteitem') }} <i class="fa fa-trash"></i></button>              
                </div>   
				@endif
                                 
            </div>          
        </div>
        <!-- /.box-header -->
        <form id="frmList" method="POST" action="manageusers" data-toggle="validator" role="form">                                                           
            {{ csrf_field() }}
        <div class="box-body">
            <table id="dtDatatable" class="table table-bordered table-hover" style="width:100%">
            <thead>
            <tr>
                <th class="text-center"></th>
                <th style='font-weight: bold; text-align: right'>نام صف</th>
                <th style='font-weight: bold; text-align: right'>صدای اتصال</th>
                <th style='font-weight: bold; text-align: right'>صدای انتظار</th>
                <th style='font-weight: bold; text-align: right'>حداکثر انتظار</th>
				<th style='font-weight: bold; text-align: right'>حداکثر انتظار بدون پاسخگو</th>
				<th style='font-weight: bold; text-align: right'>عملیات</th>
            </tr>
            </thead>
            <tbody>                
                <?php foreach ($datalist as $item) { ?>
                    <tr>
                        <td class="text-center">
                        <input type="checkbox" name="selected[]" value="<?php echo $item->q_routeid; ?>" />
                        </td>                                               
                        <td class="text-right"><?php echo $item->q_name; ?> </td> 
                        <td class="text-right"><?php echo $item->q_startsound; ?> </td> 
						<td class="text-right"><?php echo $item->q_mohsound; ?> </td> 
						<td class="text-right"><?php echo $item->q_maxwaittime; ?> </td> 
						<td class="text-right"><?php echo $item->q_maxwaitnoagent; ?> </td> 
						<td class="text-right"><a id="btnAddNew" href="/queues/addagents/<?php echo $item->q_routeid; ?>" type="button" class="btn btn-primary pull-left" data-toggle="tooltip" title="اپراتورها" data-original-title="اپراتورها"><i class="fa fa-user-circle-o"></i></a></td>
                    </tr>                    
                <?php } ?>
            </tbody>             
            </table>
        </div>
        </form>
        <!-- /.box-body -->       
@endsection

@section('footerscript')
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src='/bower_components/select2/dist/js/select2.min.js'></script>	
    <script>
        function actionDeleteForm(){
            $("#frmList").attr('action', 'queues');
            $("#frmList").submit();
        }       
		@if(Permissions::permissionCheck('23','03')==1)
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
                    window.location = "/queues/edit/"+item_id;    
                }
            });       
        });
		@endif
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