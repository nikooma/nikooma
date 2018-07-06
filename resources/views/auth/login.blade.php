<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>Nikooma</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="/plugins/login/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/plugins/login/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/plugins/login/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/plugins/login/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/plugins/login/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/plugins/login/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/plugins/login/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>	
	<link rel="stylesheet" type="text/css" href="/plugins/login/plugins/select2/select2_metro.css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="/plugins/login/css/pages/login-soft.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
	<!-- BEGIN LOGO -->
	<div class="logo">
		<!-- PUT YOUR LOGO HERE -->
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
		<form class="form-vertical login-form" method="POST" action="{{ route('login') }}">
		{{ csrf_field() }}
			<h3 class="form-title" style="font-family: BNazanin;text-align:center">ورود به سیستم</h3>
			<div class="alert alert-error hide" style="direction:rtl;font-family: BNazanin;">
				<button class="close" data-dismiss="alert"></button>
				<span>نام کاربری و کلمه عبور را وارد نمایید</span>
			</div>
			<div class="control-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">نام کاربری</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-user"></i>
						<input id="email" id="username" class="m-wrap placeholder-no-fix" style="direction:rtl" type="text" autocomplete="off" placeholder="نام کاربری" name="username" value="{{ old('username') }}" />
						@if (count($errors))
							<span class="help-block">
								@foreach($errors->all() as $error)
									<strong>{{ $error }}</strong>
								@endforeach
							</span>
						@endif
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">کلمه عبور</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input id="password" class="m-wrap placeholder-no-fix" style="direction:rtl" type="password" autocomplete="off" placeholder="کلمه عبور" name="password"/>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
				</div>
			</div>
			<div class="form-actions" style="direction:rtl;font-family: BNazanin;">								          
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> مرا بخاطر بسپار
							</label>
						</div>
					</div>
				</div>
				
				<button type="submit" class="btn blue pull-left">
				ورود <i class="m-icon-swapleft m-icon-white"></i>
				</button>  
			</div>
			<div class="forget-password" style="direction:rtl;font-family: BNazanin;text-align:right">
				<h4>کلمه عبور را فراموش کرده اید؟</h4>
				<p>
					لطفا در این قسمت درخواست <a href="javascript:;"  id="forget-password">کمک</a>
					خود را ارسال نمایید.
				</p>
			</div>			
		</form>
		<!-- END LOGIN FORM -->        		
		<!-- END FORGOT PASSWORD FORM -->		
	</div>
	<!-- END LOGIN -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		2018 © Nikooma
	</div>
	<!-- END COPYRIGHT -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<script src="/plugins/login/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="/plugins/login/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="/plugins/login/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="/plugins/login/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>	
	<!--[if lt IE 9]>
	<script src="/plugins/login/plugins/excanvas.min.js"></script>
	<script src="/plugins/login/plugins/respond.min.js"></script>  
	<![endif]-->   
	<script src="/plugins/login/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="/plugins/login/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="/plugins/login/plugins/jquery.cookie.min.js" type="text/javascript"></script>	
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="/plugins/login/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
	<script src="/plugins/login/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/plugins/login/plugins/select2/select2.min.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="/plugins/login/scripts/app.js" type="text/javascript"></script>
	<script src="/plugins/login/scripts/login-soft.js" type="text/javascript"></script>      
	<!-- END PAGE LEVEL SCRIPTS --> 
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
	<div style="position:absolute; bottom:0px; left:0px; "><a href="http://www.justukfreebies.co.uk/website-templates/free-responsive-login-form-template/">Free Website Templates</a></div>
</body>
<!-- END BODY -->
</html>