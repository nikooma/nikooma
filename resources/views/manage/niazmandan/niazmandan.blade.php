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
        نیازمندان
        <small>نیازمندان</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">نیازمندان</a></li>
        <li class="active">مدیریت</li>
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
                <a id="btnAddNew" href="/niazmandan/addnew" type="button" class="btn btn-primary pull-left" data-toggle="tooltip" title="{{ __('callcenter.newitem') }}" data-original-title="{{ __('callcenter.newitem') }}">{{ __('callcenter.newitem') }} <i class="fa fa-plus"></i></a>
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
        <form id="frmList" method="POST" action="/niazmandan" data-toggle="validator" role="form">                                                           
            {{ csrf_field() }}
        <div class="box-body">
            <table id="dtDatatable" class="table table-bordered table-hover" style="width:100%">
            <thead>
            <tr>
                <th class="text-center"></th>                
                <th style='font-weight: bold; text-align: right'>کدملی</th>
                <th style='font-weight: bold; text-align: right'>نام و نام خانوادگی</th>
                <th style='font-weight: bold; text-align: right'>نام پدر</th>					
                <th style='font-weight: bold; text-align: right'>تلفن تماس</th>
                <th style='font-weight: bold; text-align: right'>تلفن همراه</th>                                            
                <th style='font-weight: bold; text-align: right'>میزان یارانه</th> 
				<th style='font-weight: bold; text-align: right'>میزان درآمد</th>				
				<th style='font-weight: bold; text-align: right'>تحصیلات</th>				
				<th style='font-weight: bold; text-align: right'>شغل</th>
				<th style='font-weight: bold; text-align: right'>عملیات</th>
            </tr>
            </thead>
            <tbody>                
                <?php foreach ($datalist as $item) { ?>
                    <tr>
                        <td class="text-center">
                        <input type="checkbox" name="selected[]" value="<?php echo $item->n_id; ?>" />
                        </td>                                           
						<td class="text-right"><?php echo $item->n_meli; ?> </td>     
                        <td class="text-right"><?php echo $item->n_name.' '.$item->n_family; ?> </td> 
                        <td class="text-right"><?php echo $item->n_pedar; ?> </td> 												
                        <td class="text-right"><?php echo $item->n_telephone; ?> </td> 
                        <td class="text-right"><?php echo $item->n_mobile; ?> </td> 
                        <td class="text-right"><?php echo $item->n_yaraneh; ?> </td>   
						<td class="text-right"><?php echo $item->n_daramad; ?> </td> 
						<td class="text-right"><?php echo $item->n_mizantahsilat; ?> </td>
						<td class="text-right"><?php echo $item->n_shoghl; ?> </td>
						<td class="text-right">
							<button id="lnkView" type="button" onclick="openNiazmandData(<?php echo $item->n_id; ?>)" class="btn btn-primary pull-right" data-toggle="tooltip" title="نمایش" data-original-title="نمایش"><i class="fa fa-search"></i></button>    
							<a id="lnkTakafol" href="/niazmandan/takafol/<?php echo $item->n_id; ?>" class="btn btn-primary pull-right" data-toggle="tooltip" title="تحت تکفل" data-original-title="تحت تکفل"><i class="fa fa-child"></i></a>
						</td>
                    </tr>                    
                <?php } ?>
            </tbody>             
            </table>
        </div>			
        </form>
		<form id="frmExport" name="frmexport" method="POST" action="/niazmandan" data-toggle="validator" role="form">
			{{ csrf_field() }}
		<div class="modal fade" id="exportModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">استخراج</h4>
                    </div>
                    <div class="modal-body">                                              
						نوع خروجی:
						<input type="radio" id="extype1" class="proType" name="inp_extype" value="pdf" checked="checked"><label for="reqImportant1">PDF</label>
						<input type="radio" id="extype2" class="proType" name="inp_extype" value="excel"><label for="reqImportant2">EXCEL</label>
						<br>
						چیدمان بر اساس:
						<select name="grp_ddlSort" id="ddlSort"  class="form-control select2" style="width: 100%;">
							<option value="id">شماره</option>
							<option value="name">نام</option>
							<option value="u_lname">نام خانوادگی</option>
							<option value="username">نام کاربری</option>
							<option value="sip_number">تلفن سیپ</option>
							<option value="usercontext">سرورتلفنی</option>
							<option value="u_timeout">محلت زمان اتصال</option>
							<option value="u_rejects">تعداد پاسخ داده نشده مجاز</option>
							<option value="u_wrapuptime">زمان تنفس</option>
							<option value="u_rejecttime">تاخیر رد تماس</option>
							<option value="u_noanswer">تاخیر بی پاسخ ماندن تماس</option>
							<option value="u_dnd">تاخیر dnd</option>							
							<option value="u_mobilenumber">تلفن همراه</option>
							<option value="email">پست الکترونیک</option>		
						</select>
						نوع چیدمان:
						<input type="radio" id="sorttype1" class="proType" name="inp_sorttype" value="asc" checked="checked"><label for="reqImportant1">بالا به پایین</label>
						<input type="radio" id="sorttype2" class="proType" name="inp_sorttype" value="desc"><label for="reqImportant2">پایین به بالا</label>
						<br>
						ستون ها:
						<label id="lblMetError" class="label label-danger form-control" Text=""></label>
						<select size="9" id="lstFields" required multiple name="inp_lstFields[]" class="selectpicker form-control" style="overflow-x:scroll" data-live-search="true">
							<option value="id|شماره">شماره</option>
							<option value="name|نام">نام</option>
							<option value="u_lname|نام خانوادگی">نام خانوادگی</option>
							<option value="username|نام کاربری">نام کاربری</option>
							<option value="sip_number|تلفن سیپ">تلفن سیپ</option>
							<option value="usercontext|سرورتلفنی">سرورتلفنی</option>
							<option value="u_timeout|محلت زمان اتصال">محلت زمان اتصال</option>
							<option value="u_rejects|تعداد پاسخ داده نشده مجاز">تعداد پاسخ داده نشده مجاز</option>
							<option value="u_wrapuptime|زمان تنفس">زمان تنفس</option>
							<option value="u_rejecttime|تاخیر رد تماس">تاخیر رد تماس</option>
							<option value="u_noanswer|تاخیر بی پاسخ ماندن تماس">تاخیر بی پاسخ ماندن تماس</option>
							<option value="u_dnd|تاخیر dnd">تاخیر dnd</option>							
							<option value="u_mobilenumber|تلفن همراه">تلفن همراه</option>
							<option value="email|پست الکترونیک">پست الکترونیک</option>		
						</select>
						<br>
						<input type="hidden" name="hdExport" value="_export"/>
						<input type="submit" class="btn btn-primary" value="دریافت"/>
                        <script>
                            $('#frmControls input[type=text]').on('change invalid', function() {
                                var textfield = $(this).get(0);
                                textfield.setCustomValidity('');
                                if (!textfield.validity.valid) {
                                    textfield.setCustomValidity('این مقدار را وارد نمایید.');
                                }
                            });

                        </script>
                    </div>
                </div>

            </div>
        </div>
		</form>
		<form method="POST" name="frmimport" action="/niazmandan" enctype="multipart/form-data">
			{{ csrf_field() }}
		<div class="modal fade" id="importModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">استخراج</h4>
                    </div>
                    <div class="modal-body">                                              
						ورودی خود را انتخاب نمایید:
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<label class="file-upload btn btn-primary">
								Browse for file ... <input type="file" id="import" name="fleimport" />
							</label>
						</div>
						<br />
						<input type="hidden" name="hdImport" value="_import" />
						<button type="submit" name="submit" class="btn btn-primary">بارگذاری</button>  						
					</div>
				</div>
			</div>
		</div>
		</form>
		
	<div class="modal fade" id="frmNiazmand" role="dialog">
		<div class="modal-dialog">    
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">نیازمندان</h4>
				</div>
				<div class="modal-body">                       						
					<span id="modalbody"></span>                                          
                </div>
            </div>
        </div>
    </div>
        <!-- /.box-body -->       
@endsection

@section('footerscript')
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src='/bower_components/select2/dist/js/select2.min.js'></script>	
    <script>
        function actionDeleteForm(){
            $("#frmList").attr('action', 'niazmandan');
            $("#frmList").submit();
        }       
		function openExport() {
			$('#exportModal').modal('show');
		}
		function openImport() {
			$('#importModal').modal('show');
		}
		
		function openNiazmandData(niaz_id) {
			$.ajax({
				type: "post",
				url: "/niazmandan/getdata",
				data: {'item_id': niaz_id,'_token': $('input[name=_token]').val()},
				dataType: "json",
				success: function (response) {
					var datas = response;
					var spantext="نام:  "+datas.n_name+"<br />نام خانوادگی:  "+datas.n_family+"<br />نام پدر:  "+datas.n_pedar+"<br />شماره شناسنامه:  "+datas.n_shenasnameh+
						"<br />کدملی:  "+datas.n_meli+"<br />تاریخ تولد"+datas.n_tarikhtavalod+"<br />محل تولد:  "+datas.n_mahaltavalod+"<br />شغل:  "+datas.n_shoghl+"<br />درآمد"+datas.n_daramad+
						"<br />بیمه:  "+datas.n_bimeh+"<br />میزان تحصیلات:  "+datas.n_mizantahsilat+"<br />مهارت:  "+datas.n_maharat+"<br />یارانه:  "+datas.n_yaraneh+"<br />وضعیت تعهل:  "+datas.n_hamsar+
						"<br />کدملی همسر:  "+datas.n_melihamsar+"<br />شغل همسر:  "+datas.n_shoghlhamsar+"<br />نوع منزل:  "+datas.n_noemanzel+"<br />آدرس منزل:  "+datas.n_addressmanzel+
						"<br />کد پستی:  "+datas.n_codeposti+"<br />تلفن منزل:  "+datas.n_telephone+"<br />تلفن همراه:  "+datas.n_mobile+"<br />علت نیاز:  "+datas.n_elateniaz+
						"<br />وضعیت جسمانی:  "+datas.n_vaziatejesmani+"<br />جنسیت:  "+datas.n_jensiat;
					$("#modalbody").html(spantext);
				}                                
			});
			$('#frmNiazmand').modal('show');
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
                    window.location = "/niazmandan/edit/"+item_id;    
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