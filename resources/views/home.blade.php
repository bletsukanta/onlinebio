@extends('layout.master')
@section('body')
<body class="color-grey" style="padding-bottom:60px;">

    <div id="floatdiv" class="float">

        <a href="{{url('create-your-bio') }}">Create your BIO now! </a>
    </div>
    <!--header section starts here-->
    @include('layout.home-header')
    <!--header section end here-->
    <div class="clearfix"></div>
    <section class="martop30" ng-controller="faqCtrl" ng-hide="showFaq">
        <div class="container">
            @php($auto = 0);
            <div class="row">
                <div class="col-md-12">
                    <div class="home_scroll">
                        <h2>Faq</h2> 
                        <div class="panel-group" id="faqAccordion">
                            <div class="panel panel-default" ng-repeat="val in faqArr | orderBy : 'id'">
                                <div class="panel-heading accordion-toggle question-toggle collapsed" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question[[$index+1]]">
                                    <h4 class="panel-title">
                                        <a href="#" class="ing">Q: [[val.question]]</a>
                                    </h4>

                                </div>
                                <div id="question[[$index+1]]" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">
                                        <h5><span class="label label-primary">Answer</span></h5>

                                        <p ng-bind-html="TrustedHtml(val.answer)"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </section>
    <section class="martop30"  ng-controller="contentCtrl" ng-hide="showContent">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="home_scroll">
                        <h2>[[ContentTitle]]</h2>
                        <p ng-bind-html="ContentDescription"></p>
                    </div>
                </div>   
            </div>
        </div>
    </section>
    <section class="martop30" ng-controller="homeCtrl" ng-hide="showHome">
        <!--<div ng-bind="contentdisplay"></div>-->
        <div class="container">
            <div class="row" id="round-shape-user">
                <ul>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/2.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>
                        </a>

                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/3.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/4.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/5.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/6.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/2.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/3.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/4.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/5.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/6.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/2.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/3.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/4.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/5.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/6.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/2.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/3.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>
                    <li>
                        <a href="free_user-before-login.htm"><img src="{{asset('public/images/4.jpg')}}">
                            <br>

                            <span>John Lawerence<br>
                                Creator
                                Toronto, Canada</span>

                        </a>
                    </li>                   
                </ul>
            </div>
        </div>
    </section>
    <!--footer section starts here-->
    @include('layout.home-footer')
    <!--footer section starts here-->
    <!-- modal -->
    <div class="modal fade" id="login123" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="lineModalLabel">Login to Your Account</h4>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="loginform" class="form-horizontal" role="form">

                        <div  class="input-group mar-bot20">
                            <span class="input-group-addon"><i class="fa fa-user text-white" aria-hidden="true"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username or email">                                        
                        </div>

                        <div class="input-group mar-bot20">
                            <span class="input-group-addon"><i class="fa fa-lock text-white" aria-hidden="true" ></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                        </div>



                        <div  class="form-group martop10">
                            <!-- Button -->

                            <div class="col-sm-12 controls">
                                <a id="btn-login" href="free_user_after_login.htm" class="btn btn-primary btn-block">Login  </a>
                            </div>
                        </div>

                    </form>

                    <div class="login-help">
                        <a href="create-your-bio.htm">Create your BIO now! </a> - <a href="#">Forgot Password</a>
                    </div>               
                </div>               


            </div>
        </div>
    </div>    

    <div class="modal fade" id="type" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="lineModalLabel">Search by type</h4>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form>
                        <div class="col-md-12">
                            <div id="imaginary_container">
                                <div class="input-group stylish-input-group">
                                    <input type="text" class="form-control" placeholder="Search by type">
                                    <span class="input-group-addon">
                                        <button type="submit" class="srch-submit">
                                            <i class="fa fa-search text-white" aria-hidden="true"></i>
                                        </button>  
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="city" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="lineModalLabel">Search by City</h4>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form>
                        <div class="col-md-12">
                            <div id="imaginary_container">
                                <div class="input-group stylish-input-group">
                                    <input type="text" class="form-control" placeholder="Search by City">
                                    <span class="input-group-addon">
                                        <button type="submit" class="srch-submit">
                                            <i class="fa fa-search text-white" aria-hidden="true"></i>
                                        </button>  
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="service" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="lineModalLabel">Search by Service</h4>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form>
                        <div class="col-md-12">
                            <div id="imaginary_container">
                                <div class="input-group stylish-input-group">
                                    <input type="text" class="form-control" placeholder="Search by Service">
                                    <span class="input-group-addon">
                                        <button type="submit" class="srch-submit">
                                            <i class="fa fa-search text-white" aria-hidden="true"></i>
                                        </button>  
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#floatdiv').addFloating({
            targetRight: 10,
            targetTop: 200,
            snap: true
        });
    });
    </script>
</body>
@stop
<!--body section ends here-->
