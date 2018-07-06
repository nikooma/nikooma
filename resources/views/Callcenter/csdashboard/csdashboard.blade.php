<?php
use App\Http\Controllers\app_code\Permissions;
?>
@extends('master.site')

@section('rootscript')
    <meta name="csrf-token" content="{{ csrf_token() }}" />    
	<link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css"/>		
	<style>
		.content {
			min-height: 250px;
			padding: 1px;
			margin-left: auto;
			margin-right: auto;
			padding-right: 15px;
			padding-left: 15px;
		}
		.AlertPosition{
			position: absolute;
			left: 25px;
			top: 35px;
			z-index: 1050;
			width: 93%;	
			display: block; 
			
			-webkit-animation: topbottommove 1s 1;
			-webkit-animation-direction: infinite;
			-moz-animation: topbottommove 1s 1;
			-moz-animation-direction: infinite;
			animation: topbottommove 1s 1;
			animation-direction: infinite;
		}
		
		/* Safari 4.0 - 8.0 */
@-webkit-keyframes topbottommove {
    from   {background: #b8c7ce; left: 25px; top: 0px;}
    to     {background: red; left: 25px; top: 35px;}
}

@keyframes topbottommove {
    from   {background: #b8c7ce; left: 25px; top: 0px;}
    to     {background: red; left: 25px; top: 35px;}
}
	</style>	
@endsection

@section('pageheadercontent')
@endsection

@section('maincontent')
	{{ csrf_field() }}
    <!-- Main content -->
	<div id="dvAlert" class="alert alert-danger alert-dismissible AlertPosition" style="display:none;">		
		<h4><i class="icon fa fa-ban"></i> هشدار!</h4>
		<label id="lblMessage"></label>
	</div>
    <section class="content">	
	  <div class="box box-solid bg-light-blue-gradient">
		<div class="box-header">
		  <!-- tools box -->
		  <div class="pull-right box-tools">
			<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
					data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
			  <i class="fa fa-minus"></i></button>
		  </div>
		  <!-- /. tools -->
		  <i class="fa fa-stop"></i>

		  <h3 class="box-title">
			وضعیت شما: ( <span style="color:#cafffb"><label id="lblStatus"></label></span> )
		  </h3>
		</div>
		<div class="box-body">
		  <div class="btn-group" style="padding-left:10px;">
 	    	  <button id="btnStart" type="button" class="btn btn-primary" disabled><i class="fa fa-play"></i> ورود</button>
     		  <button id="btnPause" type="button" class="btn btn-primary" disabled><i class="fa fa-pause"></i> استراحت</button>
		      <button id="btnStop" type="button" class="btn btn-primary" disabled><i class="fa fa-stop"></i> خروج</button>
		  </div>
		  <div class="btn-group" style="padding-left:10px;">
 	    	  <a class="btn btn-info" title="صف هاي انتظار" data-original-title="صف هاي انتظار" tooltip="صف هاي انتظار" style="margin-right: 5px; margin-left: 5px" onclick="openQueueList();">صف هاي انتظار <i class="fa fa-bars"></i></a>
		  </div>
		  
		</div>
		<!-- /.box-body-->
	  </div>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>0</h3>

              <p>تماس ها</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-telephone"></i>
            </div>
            <a href="#" class="small-box-footer">اطلاعات بيشتر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>00:00:00</h3>

              <p>استراحت</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-pause"></i>
            </div>
            <a href="#" class="small-box-footer">اطلاعات بيشتر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0</h3>

              <p>تماس هاي موفق</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-happy"></i>
            </div>
            <a href="#" class="small-box-footer">اطلاعات بيشتر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>0</h3>

              <p>تماس هاي ناموفق</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-sad"></i>
            </div>
            <a href="#" class="small-box-footer">اطلاعات بيشتر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
			<div class="box box-solid bg-light-blue-gradient">
				<div class="box-header">
					<div class="pull-right box-tools">
						<a onclick="openBlock();" class="btn btn-danger btn-sm pull-right" data-toggle="tooltip"><i class="fa fa-ban"></i> مسدود</a>
						<a href="#" class="btn btn-primary btn-sm pull-right" data-toggle="tooltip"><i class="fa fa-calendar"></i> تاريخچه مشترک</a>
						<a href="#" class="btn btn-primary btn-sm pull-right" data-toggle="tooltip"><i class="fa fa-bolt"></i> عمليات کاربر</a>
						<a href="#" class="btn btn-primary btn-sm pull-right" data-toggle="tooltip"><i class="fa fa-ticket"></i> ثبت تيکت</a>						
						<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
								data-toggle="tooltip" style="margin-right: 5px;">
						<i class="fa fa-minus"></i></button>
					</div>
					<!-- /. tools -->

					<i class="fa fa-phone"></i>

					<h3 class="box-title">
						اطلاعات تماس
					</h3>										
				</div>
				<div class="box-body">
				  <table style="width: 100%; height:353px;">		
						<tr>
							<td style="height: 300px; vertical-align: top;">
								<input type="hidden" name="ctl00$MainContent$callCode" id="MainContent_callCode" />
								<table style="border: 1px solid #E1E1E1; margin: 5px; width: 98%;">
									<tr style="background: rgb(96, 176, 230);">
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">وضعيت شما</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">نام مشترک</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">صف انتظار</td>
									</tr>
									<tr>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblStatus" style="font-family:Tahoma;"></span>                                                
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblMemberName"></span>
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; "><span id="MainContent_lblQueue"></span>
										</td>
									</tr>
									<tr style="background: rgb(96, 176, 230);">
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">تلفن تماس گيرنده</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">تلفن ADSL</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">شهرستان</td>
									</tr>
									<tr>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblCallerID"></span>
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lbl3RDNumber"></span>
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblCity"></span>
										</td>
									</tr>
									<tr style="background: rgb(96, 176, 230);">
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">مرکز</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">نوع تعرفه</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">وضعيت سرويس</td>
									</tr>
									<tr>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblCenter"></span>
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblSerType"></span>
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblServiceStatus"></span>
										</td>
									</tr>
									<tr style="background: rgb(96, 176, 230);">
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">حجم ترافيک باقيمانده</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">حجم ترافيک رزرو</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">مسدود شده</td>
									</tr>
									<tr>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblTraf"></span>
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblRezerv"></span>
										</td>
										<td style="border: 1px solid #E1E1E1; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblLock"></span>
										</td>
									</tr>
									<tr style="background: rgb(96, 176, 230);">
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">علت انسداد</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">وضعيت مشترک</td>
										<td style="width: 33.33%; height: 30px;text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">زمان انتظار در صف</td>
									</tr>
									<tr>
										<td style="border: 1px solid #D4D4D4; text-align:center; height: 30px;font-family: BNazanin; font-size: small; font-weight: bold; " class="auto-style57">
											<span id="MainContent_lblLockRes"></span>
										</td>
										<td style="border: 1px solid #D4D4D4; text-align:center; height: 30px;font-family: BNazanin; font-size: small; font-weight: bold; " class="auto-style57">
											<span id="MainContent_lblMemberStatus"></span>
										</td>
										<td style="border: 1px solid #D4D4D4; text-align:center; height: 30px;font-family: BNazanin; font-size: small; font-weight: bold; " class="auto-style57">
											<span id="MainContent_lblTime" style="font-family:Tahoma;"></span>
										</td>
									</tr>
									<tr style="background: rgb(96, 176, 230);">
										<td style="width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">رمز مودم</td>
										<td style="width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">تعداد تماس ها امروز</td>
										<td style="width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">زمان باقي مانده</td>
									</tr>
									<tr>
										<td style="border: 1px solid #D4D4D4; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblPassword"></span>
										</td>
										<td style="border: 1px solid #D4D4D4; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblTedadTamas"></span>
										</td>
										<td style="border: 1px solid #D4D4D4; width: 33.33%; height: 30px; text-align:center; font-family: BNazanin; font-size: small; font-weight: bold; ">
											<span id="MainContent_lblZaman"></span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <div class="box box-solid bg-light-blue-gradient">
				<div class="box-header">
					<div class="pull-right box-tools">						
						<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
								data-toggle="tooltip" style="margin-right: 5px;">
						<i class="fa fa-minus"></i></button>
					</div>
					<!-- /. tools -->

					<i class="fa fa-phone"></i>
					<h3 class="box-title">
						اطلاعيه ها
					</h3>										
				</div>
				<div class="box-body">
					<div style="height:364px;overflow-y: auto;">
						<ul>
							<li>امروز به دليل اختلالات کلي در شبکه نيمور به مدت 5 ساعت قطع بوده و کسي تماس نگيرد. درصورت مشاهده هرگوني تماس برخورد فيزيکي صورت خواهد گرفت. خخخخخخخخخخخ</li>
							<li>امروز به دليل اختلالات کلي در شبکه نيمور به مدت 5 ساعت قطع بوده و کسي تماس نگيرد. درصورت مشاهده هرگوني تماس برخورد فيزيکي صورت خواهد گرفت. خخخخخخخخخخخ</li>
							<li>امروز به دليل اختلالات کلي در شبکه نيمور به مدت 5 ساعت قطع بوده و کسي تماس نگيرد. درصورت مشاهده هرگوني تماس برخورد فيزيکي صورت خواهد گرفت. خخخخخخخخخخخ</li>
							<li>امروز به دليل اختلالات کلي در شبکه نيمور به مدت 5 ساعت قطع بوده و کسي تماس نگيرد. درصورت مشاهده هرگوني تماس برخورد فيزيکي صورت خواهد گرفت. خخخخخخخخخخخ</li>
							<li>امروز به دليل اختلالات کلي در شبکه نيمور به مدت 5 ساعت قطع بوده و کسي تماس نگيرد. درصورت مشاهده هرگوني تماس برخورد فيزيکي صورت خواهد گرفت. خخخخخخخخخخخ</li>
							<li>امروز به دليل اختلالات کلي در شبکه نيمور به مدت 5 ساعت قطع بوده و کسي تماس نگيرد. درصورت مشاهده هرگوني تماس برخورد فيزيکي صورت خواهد گرفت. خخخخخخخخخخخ</li>
							<li>امروز به دليل اختلالات کلي در شبکه نيمور به مدت 5 ساعت قطع بوده و کسي تماس نگيرد. درصورت مشاهده هرگوني تماس برخورد فيزيکي صورت خواهد گرفت. خخخخخخخخخخخ</li>
							
						</ul>
					</div>
				</div>
			</div>
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
	  <div class="box box-solid bg-light-blue-gradient">
		<div class="box-header">
		  <!-- tools box -->
		  <div class="pull-right box-tools">
			<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
					data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
			  <i class="fa fa-minus"></i></button>
		  </div>
		  <!-- /. tools -->
		  <i class="fa fa-stop"></i>

		  <h3 class="box-title">
			صف هاي انتظار
		  </h3>
		</div>
		<div class="box-body">
		  <div class="btn-group" style="padding-left:10px;">
 	    	  <button type="button" class="btn btn-primary disabled"><i class="fa fa-play"></i> شروع به پاسخگويي</button>
     		  <button type="button" class="btn btn-primary disabled"><i class="fa fa-pause"></i> استراحت</button>
		      <button type="button" class="btn btn-primary disabled"><i class="fa fa-stop"></i> اتمام پاسخگويي</button>
		  </div>
		  <div class="btn-group" style="padding-left:10px;">
 	    	  <a class="btn btn-info" title="صف هاي انتظار" data-original-title="صف هاي انتظار" tooltip="صف هاي انتظار" style="margin-right: 5px; margin-left: 5px" onclick="openQueueList();">صف هاي انتظار <i class="fa fa-bars"></i></a>
		  </div>
		  
		</div>
		<!-- /.box-body-->
	  </div>
    </section>
    <!-- /.content -->   
	
	
	<div class="modal fade" id="queueList" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">صف های انتظار</h4>
				</div>
				<div class="modal-body">     
					<?php foreach($queuelist as $item){ ?>
					<input id="chQueue_<?php echo $item->t_queue; ?>" name="Queue_<?php echo $item->t_queue; ?>" value="<?php echo $item->t_queue; ?>" type="checkbox" />
					<label for="chQueue_<?php echo $item->t_queue; ?>"><?php echo $item->q_name; ?></label>
					<br />					
					<?php } ?>					
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="blockcustomer" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مسدود</h4>
				</div>
				<div class="modal-body">                                              										
					شماره مشترک:
					<label id="b_callerid" class="form-control">8632243108</label>
					شماره ADSL:
					<label id="b_adslnumber" class="form-control">32778684</label>
					توضيحات:
					<input id="b_desc" type="text" required class="form-control" />
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">بلوکه شود</button>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function openQueueList() {
			$('#queueList').modal('show');
		}  
		function openBlock() {
			$('#blockcustomer').modal('show');
		} 
	</script>
	
@endsection

@section('footerscript')    
	<script src='/bower_components/select2/dist/js/select2.min.js'></script>	
    <script>			
		setInterval(function() {
			$.ajax({
                type: "post",
                url: "/csdashboard/status",
                data: {'item_id': '<?php echo $useragent; ?>','_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (response) {
                    var datas = response;
                    var status=datas.status;
					if(datas.code!="0"){
						$("#lblMessage").text(datas.message);
						$("#dvAlert").show();
						$("#btnStart").attr('disabled', 'disabled');
						$("#btnStop").attr('disabled', 'disabled');
						$("#btnPause").attr('disabled', 'disabled');						
						return;
					}
					if(status=="Logged Out"){												
						$("#dvAlert").hide();						
						$("#lblStatus").text("خروج");
						$("#lblStatus").css("color", "red");
						$("#btnStart").removeAttr('disabled');
						$("#btnStop").attr('disabled', 'disabled');
						$("#btnPause").attr('disabled', 'disabled');
					}
					else if(status=="Available"){												
						$("#dvAlert").hide();						
						$("#lblStatus").text("آماده پاسخگویی");
						$("#lblStatus").css("color", "#92ff92");
						$("#btnStart").attr('disabled', 'disabled');
						$("#btnStop").removeAttr('disabled');
						$("#btnPause").removeAttr('disabled');
					}
					else if(status=="On Break"){												
						$("#dvAlert").hide();						
						$("#lblStatus").text("استراحت");
						$("#lblStatus").css("color", "yellow");
						$("#btnStart").removeAttr('disabled', 'disabled');
						$("#btnStop").removeAttr('disabled');
						$("#btnPause").attr('disabled', 'disabled');
					}
					if(datas.members.uuid!=null){
						$("#MainContent_lblMemberName").text(datas.members.flname);
						$("#MainContent_lblQueue").text(datas.members.queue);
						$("#MainContent_lblCallerID").text(datas.members.callerid);
						$("#MainContent_lbl3RDNumber").text(datas.members.adsltel);
						$("#MainContent_lblCity").text(datas.members.city);						
						
						$("#MainContent_lblCenter").text(datas.members.mdf);	
						$("#MainContent_lblSerType").text(datas.members.activeservice);	
						$("#MainContent_lblServiceStatus").text(datas.members.islock);	
						$("#MainContent_lblTraf").text(datas.members.credit);	
						$("#MainContent_lblRezerv").text(datas.members.deposit);	
						$("#MainContent_lblLock").text(datas.members.islock);	
						$("#MainContent_lblLockRes").text(datas.members.lockreason);	
						$("#MainContent_lblMemberStatus").text(datas.members.isonline);	
						$("#MainContent_lblTime").text(datas.members.jointime);	
						$("#MainContent_lblPassword").text(datas.members.netpassword);	
						$("#MainContent_lblTedadTamas").text(datas.members.city);	
						$("#MainContent_lblZaman").text(datas.members.timetoexp);							
					}
                }
            });
		}, 2500); 		
        $(document).ready(function(){
            $("#btnStart").click(function(){
				$("#btnStart").attr('disabled', 'disabled');
				$("#btnStop").attr('disabled', 'disabled');
				$("#btnPause").attr('disabled', 'disabled');
                $.ajax({
					type: "post",
					url: "/csdashboard/start",
					data: {'item_id': '<?php echo $useragent; ?>','_token': $('input[name=_token]').val()},
					dataType: "json",
					success: function (response) {
						var datas = response;
						var resault=datas.resault;
						if(resault=="1"){
							$("#dvAlert").hide();
							$("#lblStatus").text("آماده پاسخگویی");
							$("#lblStatus").css("color", "#92ff92");
							$("#btnStart").attr('disabled', 'disabled');
							$("#btnStop").removeAttr('disabled');
							$("#btnPause").removeAttr('disabled');							
						}
						else{						
							$("#dvAlert").show();						
							$("#lblStatus").text(datas.resault);
							$("#btnStart").removeAttr('disabled');
							$("#btnStop").attr('disabled', 'disabled');
							$("#btnPause").attr('disabled', 'disabled');
						}
					}
				});
            });  			
			$("#btnPause").click(function(){
                $.ajax({
					type: "post",
					url: "/csdashboard/pause",
					data: {'item_id': '<?php echo $useragent; ?>','_token': $('input[name=_token]').val()},
					dataType: "json",
					success: function (response) {
						var datas = response;
						var resault=datas.resault;
						if(resault=="1"){
							$("#dvAlert").hide();
							$("#lblStatus").text("استراحت");
							$("#lblStatus").css("color", "yellow");
							$("#btnStart").removeAttr('disabled');
							$("#btnStop").removeAttr('disabled');
							$("#btnPause").attr('disabled', 'disabled');
						}
						else{						
							$("#dvAlert").show();						
							$("#lblStatus").text(datas.resault);
							$("#btnStart").attr('disabled');
							$("#btnStop").removeAttr('disabled', 'disabled');
							$("#btnPause").removeAttr('disabled', 'disabled');
						}
					}
				});
            });
			$("#btnStop").click(function(){
                $.ajax({
					type: "post",
					url: "/csdashboard/stop",
					data: {'item_id': '<?php echo $useragent; ?>','_token': $('input[name=_token]').val()},
					dataType: "json",
					success: function (response) {
						var datas = response;
						var resault=datas.resault;
						if(resault=="1"){
							$("#dvAlert").hide();
							$("#lblStatus").text("خروج");
							$("#lblStatus").css("color", "red");
							$("#btnStart").removeAttr('disabled');
							$("#btnStop").attr('disabled', 'disabled');
							$("#btnPause").attr('disabled', 'disabled');
						}
						else{						
							$("#dvAlert").show();						
							$("#lblStatus").text(datas.resault);
							$("#btnStart").attr('disabled');
							$("#btnStop").removeAttr('disabled', 'disabled');
							$("#btnPause").removeAttr('disabled', 'disabled');
						}
					}
				});
            });
        });
    </script>    
@endsection