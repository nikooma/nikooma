<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="/bower_components/bootstrap-file-upload/dist/css/file-upload.css"/>
	<link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" />	
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
        صداهای انتظار
        <small>صدا</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">صدا</a></li>
        <li class="active">صداهای انتظار</li>
      </ol>    
@endsection

@section('maincontent')		
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
	<div class="box box-info">		
		<a href="/musiconhold" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form method="POST" action="../../../../musiconhold/addsounds/<?php echo $item_id; ?>" enctype="multipart/form-data">                                                           
			{{ csrf_field() }}
			نام صدای انتظار:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->name:""); ?>' type="text" required MaxLength="50" />
			فایل صدا:
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<label class="file-upload btn btn-primary">
					Browse for file ... <input type="file" id="musiconhold" required name="flesound" />
				</label>
			 </div>
			<br />
			<div>
			<button type="submit" name="submit" style="margin:10px;" class="btn btn-primary pull-left">افزودن صدا <i class="fa fa-plus"></i></button>
			 <table id="dtDatatable" class="table table-bordered table-hover" style="width:100%">
				<thead>
				<tr>
					<th class="text-center"></th>   
					<th style='font-weight: bold; text-align: right'>شماره</th>
					<th style='font-weight: bold; text-align: right'>نام صدا</th>					
					<th style='font-weight: bold; text-align: right'>عملیات</th>								
				</tr>
				</thead>
				<tbody id="spitems">
					<?php foreach ($soundlist as $item) { ?>
						<tr>
							<td class="text-center">
							<input type="checkbox" name="selected[]" value="<?php echo $item->ms_id; ?>" />
							</td>                                                                  
							<td class="text-right"><?php echo $item->ms_id; ?> </td>
							<td class="text-right"><?php echo $item->ms_name; ?> </td> 														
							<td class="text-right">																			
									پخش پشتیبانی نمی شود							
							</td>				
						</tr>                    
					<?php } ?>
				</tbody>       
			 </table>
			</div>			
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo $item_id; ?>' />    
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
	<script src='/bower_components/bootstrap-file-upload/dist/js/file-upload.js'></script> 
	<script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>	
	<script type="text/javascript">
		$(document).ready(function() {
			$('.file-upload').file_upload();
		});
	</script>

      $(function () {
          $('#dtDatatable').DataTable({
              "searching": true, 			  
              "language":
                  {
                    "emptyTable":       "<center>هیچ صدایی وجود ندارد</center>",
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