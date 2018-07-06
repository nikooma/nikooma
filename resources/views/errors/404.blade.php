@extends('master.site')

@section('rootscript')
   
@endsection

@section('pageheadercontent')
      <h1>
        خطای 404
		<small>صفحه مورد نظر یافت نشد</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>        
        <li class="active">خطای 404</li>
      </ol>
@endsection

@section('maincontent')
         <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> صفحه مورد نظر شما یافت نشد!.</h3>

          <p>
            صفحه ای که بدنبال آن هستید وجود ندارد.<br/>
            شما میتوانید <a href="../../home">به صفحه خانه بروید</a> و یا اگر مشگلی وجود دارد آن را گزارش دهید:
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="گزارش">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-newspaper-o"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
@endsection

@section('footerscript')
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src='../bower_components/select2/dist/js/select2.min.js'></script>	
@endsection