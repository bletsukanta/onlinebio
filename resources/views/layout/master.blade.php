<!DOCTYPE html>
<html ng-app="OnlineBioApp" ng-init="showContent=true;showHome=false;showFaq=true;">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset("public/css/bootstrap.min.css")}}" rel="stylesheet">
        <!-- Custom CSS -->

        <!-- Custom Fonts -->
        <link href="{{ asset("public/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css">
        <link href="{{ asset("public/css/style.css") }}" rel="stylesheet" type="text/css">    
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
        <script type="text/javascript" src="{{ asset("public/js/jquery-1.11.2.min.js") }}"></script>
        <script type="text/javascript" src="{{ asset("public/js/floating-1.12.js")}}"></script>
        <!-- Bootstrap Core JavaScript -->
        <script type="text/javascript" src="{{ asset("public/js/bootstrap.min.js")}}"></script>
        <!-- for signup page extra -->
        <script type="text/javascript" src="{{ asset("public/js/jquery-ui.js")}}"></script>
        
        <script src="{{ asset('public/lib/angular/angular.js') }}" type="text/javascript"></script>
        <!-- For Social Link -->
        <script src="{{ asset('public/lib/angular/angular-social-links.js') }}" type="text/javascript"></script>
        <!-- For Flexslider carasoul -->
        <script src="{{ asset('public/lib/angular/angular-flexslider.js') }}" type="text/javascript"></script>
        
        <script src="{{ asset('public/lib/angular/recaptcha_api.js') }}?onload=vcRecaptchaApiLoaded&render=explicit" async defer></script>
        <script src="{{ asset('public/lib/angular/angular-recaptcha.js') }}"></script>
        
        <!--Custom Angular Js -->
        <script type="text/javascript" src="{{ asset("public/angular_app1.js")}}"></script>
        <script type="text/javascript" src="{{ asset("public/controller/footer.js")}}"></script>
    </head>
    @yield('body')

    <!--end -->
</html>