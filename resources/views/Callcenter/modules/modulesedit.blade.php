<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="/bower_components/bootstrap-file-upload/dist/css/file-upload.css"/>	
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
		  <form method="POST" action="/module" enctype="multipart/form-data">                                                           
			{{ csrf_field() }}
			نام افزونه:
			<input id="txtName" name="inp_txtName" class="form-control" value='<?php echo($status=="_edit"?$datalist[0]->name:""); ?>' type="text" required MaxLength="50" />
			فایل افزونه:
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<label class="file-upload btn btn-primary">
					Browse for file ... <input type="file" id="module" name="flemodule" />
				</label>
			 </div>
			<br />
			<button type="submit" name="submit" class="btn btn-primary">{{ __('callcenter.saveitem') }}</button>    
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
	<script type="text/javascript">
		$(document).ready(function() {
			$('.file-upload').file_upload();
		});
	</script>
	@if($status=="_edit")
		<script>			
			<?php 
			$grp='[';
			foreach ($usergrplist as $group){
				$grp.=$group->groupid.',';
			}
			$grp=rtrim($grp,",")."]";
			?>
			$(document).ready(function(){    
				$('#ddlgroups').val(<?php echo $grp; ?>); 						
				$('#ddlgroups').trigger('change');	
				$('#ddlServers').val(<?php echo $datalist[0]->usercontext; ?>); 						
				$('#ddlServers').trigger('change');	
			});			
		</script>
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
@endsection