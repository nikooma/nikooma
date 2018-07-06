@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}">   
	<link href="../css/tabs.css" rel="stylesheet" />	
	<link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet" />	
	<style>
		#exTab1 .tab-content {
		  color : white;
		  background-color: #5a738e;
		  padding : 5px 15px;
		  min-height: 550px;		  
		}

		#exTab2 h3 {
		  color : white;
		  background-color: #5a738e;
		  padding : 5px 15px;
		}

		/* remove border radius for the tab */

		#exTab1 .nav-pills > li > a {
		  border-radius: 0;
		}

		/* change border radius for the tab , apply corners on top*/

		#exTab3 .nav-pills > li > a {
		  border-radius: 4px 4px 0 0 ;
		}
		#exTab3 .tab-content {
		  color : white;
		  background-color: #5a738e;
		  padding : 5px 15px;
		  min-height: 550px;
		}
		.nav-pills > li{
			float: right;
		}
		#exTab3 .active > a {
		  background-color:#5a738e;
		}
	</style>
	{{ csrf_field() }}
@endsection
@section('pageheadercontent')
      <h1>
        مدیریت گروه ها
        <small>کاربران</small>
      </h1>	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li><a href="#">کاربری</a></li>
        <li class="active">مدیریت گروه ها</li>
      </ol>    
@endsection
@section('maincontent')
<div class="box" style="min-height:650px;overflow:hidden;">
  <div class="box-header">  
    <div id="warningpln" style="display:none;" class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <span id="warntext"></span>
        <button type="button" class="close pull-left" data-dismiss="alert">&times;</button>
    </div>                
    <div id="successpnl" style="display:none;" class="alert alert-success"><i class="fa fa-check-circle"></i> <span id="successtext"></span>
        <button type="button" class="close pull-left" data-dismiss="alert">&times;</button>
    </div>            
	<div class="input-group">  
	<span class="input-group-addon" style="font-size:15px;">گروه :</span>	
	<select id="ddlgroups" class="pull-right form-control select2" style="width: 40%;" name="groups">
		<?php foreach ($grplist as $item) { ?>
		<option value="<?php echo $item->id ?>"><?php echo $item->name; ?></option>	
		<?php } ?>
	</select>	
	</div>
	<br />
	<div id="exTab3" class="container">	
		<ul class="nav nav-pills">
			<?php $i_first=0;
				foreach ($panels as $item) { 
				$i_first++;
				if($i_first==1){?>
					<li class="active"><a href="<?php echo $item['href']; ?>" data-toggle="tab"><?php echo $item['name']; ?></a></li>					
			<?php }else{ ?>			
					<li><a href="<?php echo $item['href']; ?>" data-toggle="tab"><?php echo $item['name']; ?></a></li>					
				<?php }} ?>			
		</ul>		
		<div class="tab-content clearfix">
			<?php foreach ($pviews as $vitem) { ?>
			<div class="tab-pane active" id="<?php echo $vitem['href']; ?>">
				<div class="container">
					<div id="user-permissions">
						<?php foreach ($vitem["panels"] as $pans) { ?>
						<span style="font-size:25px;"><?php echo $pans['name']; ?></span>
						<table style="width:100%" class="table table-borderless">
						  <thead>
							<tr>							  
							  <th style="font-size:15px;text-align:right;">دسترسی</th>
							  <th style="font-size:15px;text-align:right;">مجاز</th>
							  <th style="font-size:15px;text-align:right;">غیر مجاز</th>							 
							</tr>
						  </thead>
						   <tbody>
						    <?php foreach ($pans['roles'] as $role) { ?>
							<tr>
							  <td><?php echo $role['label']; ?></td>
							  <td><div class="btn-group btn-toggle">
								  <input type="radio" id="iA_<?php echo $role['id']; ?>" name="<?php echo $pans['tag']; ?>_<?php echo $role['name']; ?>" class="radiobuttonsubmit" value="<?php echo $role['id']; ?>_ALLOW">
								</div></td>
							  <td><div class="btn-group btn-toggle">
								  <input type="radio" id="iD_<?php echo $role['id']; ?>" name="<?php echo $pans['tag']; ?>_<?php echo $role['name']; ?>" class="radiobuttonsubmit" checked="checked" value="<?php echo $role['id']; ?>_DALLOW">
								</div></td>
							</tr>
							<?php } ?>													
						  </tbody>
						</table>
						<?php } ?>	
					</div>
				</div>
				<div id="push"></div>
			</div>	
			<?php } ?>
		</div>
	</div>
	<div id="ajaxWait" class="ajaxLoaderFull" style="display: none";>
		<img src="images/ajax-loader.gif" style="position: absolute;left: 45%;top:200px" />
	</div>
  </div>
</div>
@endsection

@section('footerscript') 
	<script src='../vendors/select2/dist/js/select2.min.js'></script>
	<script>
	  $(function () {
		//Initialize Select2 Elements
		$(".select2").select2();
	  });
	  function clearList(dList){            						
		$("#exTab3 input:radio").each(function(){
		    if(this.value.indexOf("_DALLOW")>0){				
				this.checked="checked";
			}
		});		
	  }	  
	  $(document).ajaxStart(function(){			
            $("#ajaxWait").css("display", "block");
        });

      $(document).ajaxComplete(function(){
            $("#ajaxWait").css("display", "none");
        });
	  $(document).ready(function() {		  		  
		  $('#ddlgroups').change(function(){
			clearList("ddlOffice"); 
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: "post",
				url: "managegroups/updateroles",
				data: {'item_id': $('#ddlgroups').val(),'_token': $('input[name=_token]').val()},
				dataType: "json",
				success: function (response) {
					var datas = response;  
					
					if(datas.length>0){
						for (var j_q = 0; j_q < datas.length; j_q++) {                       
							console.log("iA_"+datas[j_q]);     
							var chk=document.getElementById("iA_"+datas[j_q]);
							if(chk!=null)
							{
								chk.checked="checked";
							}
						}               
					}					
				}
			});
		  });
		  $('.radiobuttonsubmit').change(function() {	
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: "post",
				url: "managegroups/savedata",
				data: {'group': $("#ddlgroups").val(),'item_id': this.value,'_token': $('input[name=_token]').val()},
				dataType: "json",
				success: function (response) {
					var datas = response;			
					if(datas.status=="OK"){
						$("#successpnl").css("display","block");
						$("#warningpln").css("display","none");
						$("#successtext").text("دسترسی با موفقیت اعمال شد.");
					}
					else{
						$("#successpnl").css("display","none");
						$("#warningpln").css("display","block");
						$("#successtext").text("خطا:"+datas.message);
					}
				}
			});
		  });
		  
		  $("#ddlgroups").change();  
	  });		
	</script>   
@endsection