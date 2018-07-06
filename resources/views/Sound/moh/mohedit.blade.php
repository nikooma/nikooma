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
	<div class="box box-info">		
		<a href="/musiconhold" class="btn btn-primary pull-left" style="margin:10px;">بازگشت <i class="fa fa-reply"></i></a>              
		<hr />
		<div class="box-body center-frame">
		  <form id="frmControls" method="POST" action="/musiconhold" data-toggle="validator" role="form">                                                           
			{{ csrf_field() }}
			نام صدای انتظار:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->m_name:""); ?>' type="text" required MaxLength="50" />
			نرخ صدا:
			<input id="txtRate" name="inp_txtRate" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->m_rate:"8000"); ?>' type="number" required MaxLength="50" />			
			<div class="row">
				<div class="col-sm-3">
					پخش صدا بصورت تصادفی:
				</div>			
				<div class="col-sm-1 material-switch">
					<input id="playshuffle" name="inp_playshuffle" <?php echo ($status=="_edit" && $datalist[0]->m_shuffle=="on"?"checked=\"checked\"":""); ?> type="checkbox"/>
					<label for="playshuffle" class="label-primary"></label>
				</div>
			</div>
			تعداد کانال:
			<input id="txtChannels" name="inp_txtChannels" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->m_channels:"1"); ?>' type="number" required MaxLength="50" />
			زمان پخش هر صدا:
			<input id="txtInterval" name="inp_txtInterval" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->m_interval:"60"); ?>' type="number" required MaxLength="50" />
			
			<button type="submit" name="submit" style="margin:10px;" class="btn btn-primary pull-left">ذخیره سازی <i class="fa fa-save"></i></button>			
			<input type="hidden" id="hdID" name="inp_hdID" value='<?php echo($status=="_edit"?$datalist[0]->m_id:""); ?>' />    
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
	<script src='/bower_components/bootstrap-file-upload/dist/js/file-upload.js'></script> 
	<script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>	
	<script type="text/javascript">
		$(document).ready(function() {
			$('.file-upload').file_upload();
		});
	</script>
	@if($status=="_edit")
		<script >
		!function(e)
		{
			var t=function(t,n){
				this.$element=e(t),
				this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),
				this.$input=this.$element.find(":file");
				if(this.$input.length===0)return;
				this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),
				this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),
				this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)</script>
	@endif		
	
	<script>
      $(function () {
          $('#dtDatatable').DataTable({
              "searching": true, 
			  "bPaginate": false,
			  "bInfo" : false,
			  "sZeroRecords" : false,
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