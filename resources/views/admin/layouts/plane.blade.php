<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>Online Bio - Admin Panel</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset("public/admin/stylesheets/styles.css") }}" />
        <script src="{{ asset('public/js/jquery-1.11.2.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{asset('public/admin/ckeditor/ckeditor.js')}}"></script>
</head>
<body>
	@yield('body')
	
	<script src="{{ asset("public/admin/scripts/frontend.js") }}" type="text/javascript"></script>
        
</body>
</html>