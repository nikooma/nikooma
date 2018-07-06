<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" />
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
                <a id="btnAddNew" href="/module/addnew" type="button" class="btn btn-primary pull-left" data-toggle="tooltip" title="{{ __('callcenter.newitem') }}" data-original-title="{{ __('callcenter.newitem') }}">{{ __('callcenter.newitem') }} <i class="fa fa-plus"></i></a>
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
        <form id="frmList" method="POST" action="module" data-toggle="validator" role="form">                                                           
            {{ csrf_field() }}
        <div class="box-body">
            <table id="dtDatatable" class="table table-bordered table-hover" style="width:100%">
            <thead>
				<tr>
					<th class="text-center"></td>      
					<th style='font-size: 13px; font-weight: bold; text-align: right'>شماره</th>
					<th style='font-size: 13px; font-weight: bold; text-align: right'>نام افزونه</th>
					<th style='font-size: 13px; font-weight: bold; text-align: right'>فرمت افزونه</th>
					<th style='font-size: 13px; font-weight: bold; text-align: right'>توسعه دهنده</th>  				
					<th style='font-size: 14px; font-weight: bold; text-align: right'>نسخه</th> 
					<th style='font-size: 14px; font-weight: bold; text-align: right'>وضعیت</th>
					<th style='font-size: 14px; font-weight: bold; text-align: right'>عملیات</th>
				</tr>
            </thead>
            <tbody>                
                <?php foreach ($datalist as $item) { ?>
                    <tr>
                        <td class="text-center">
                        <input type="checkbox" name="selected[]" value="<?php echo $item->m_id; ?>" />
                        </td>                                                                  
						<td class="text-right"><?php echo $item->m_id; ?> </td>
                        <td class="text-right"><?php echo $item->m_name; ?> </td> 
                        <td class="text-right"><?php echo $item->m_type; ?> </td> 
                        <td class="text-right"><?php echo $item->m_developer; ?> </td> 
						<td class="text-right"><?php echo $item->m_version; ?> </td>
						<td class="text-right"><?php echo ($item->enabled_t3245=="0"?"غیرفعال":"فعال"); ?> </td>
						<td class="text-right">
							<a id="btnStatus" href="/module/status/<?php echo $item->m_id; ?>" type="button" class="btn btn-<?php echo($item->enabled_t3245=='0'?'primary':'danger') ?> pull-left" data-toggle="tooltip" title="وضعیت" data-original-title="وضعیت"><i class="fa <?php echo($item->enabled_t3245=='0'?'fa-check':'fa-ban') ?>"></i></a>
							<?php if($item->enabled_t3245!='0'){
							echo ('<a id="btnAddValue" href="/module/editdest/'.$item->m_id.'" type="button" class="btn btn-primary pull-right" data-toggle="tooltip" title="ویرایش مقصد" data-original-title="ویرایش مقصد"><i class="fa fa-edit"></i></a></td>');
							}
						    ?>
						</td>
							
						</td>
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
    <script>
        function actionDeleteForm(){
            $("#frmList").attr('action', '../../../module');
            $("#frmList").submit();
        }       		
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