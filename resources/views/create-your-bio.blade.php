@extends('layout.master')
@section('body')
<body class="bluebg" style="padding-bottom:100px;">
    <!--header section starts here-->
    @include('layout.signup-header')
    <!--header section end here-->
    <div class="clearfix"></div>
    <section class="mar-top20" ng-controller="createBioCtrl">
        <div class="container">
            <div class="row" id="createbio">
                {{Form::open (array ('url' => '','name'=>'frmdomain','id'=>'frmdomain','files'=>true))}}
                <div class=" col-md-6">
                    <div class="form-group">
                        {{ Form::select('domain_category', $domain_category_arr, '', ['ng-model' => 'domain_category','ng-change' => 'getDomains()','placeholder' => 'Select category','class' => 'form-control orange']) }}
                    </div>
                </div>                       
                <div class=" col-md-6">
                    <div class="form-group" >
                        {{ Form::select('domain_name', array(), '', ['ng-change' => 'showSudomainName()','ng-options' => 'val.domain_name for val in domain_arr track by val.id','ng-model' => 'domain_name','placeholder' => 'Select your occupation','class' => 'form-control grey']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-container">
                        <div class="form-group">
                            {{Form::text('user_name','', ['ng-blur' => 'showSudomainName()','ng-model' => 'user_name','placeholder'=>'User Name','class'=>"form-control orange"])}}
                        </div>
                    </div>
                </div>
                {{Form::close ()}} 
            </div>
            <div class="clearfix"></div>
            <div class="row text-center"> 
                <!--Social signup container start-->
                <div id="effect" ng-hide="show_social_login_container">
                    Your Domain name will look like this<br/>
                    [[show_sudomain_name]]<br/>
                    <p class="mar-top20">Get it now for free confirming your</p>
                    <a href="javascript:void(0);" id="button" class="btn btn-info btn-circle btn-lg" ng-click="showEmailForm()">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </a>
                    <a href="javascript:void(0);" id="mobile" class="btn btn-danger btn-circle btn-lg" ng-click="showMobileForm()">
                        <i class="fa fa-mobile" aria-hidden="true"></i>
                    </a>
                    <a  class="btn btn-primary btn-circle btn-lg">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-info btn-circle btn-lg">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-info btn-circle btn-lg" style="background:#007bb6;">
                        <i class="fa fa-linkedin"></i>
                    </a>
                    <a class="btn btn-danger btn-circle btn-lg">
                        <i class="fa fa-google-plus" aria-hidden="true"></i>
                    </a>
                </div>
                <!-- Signup verification code form container end -->
                <div class="col-md-12">
                    <div id="effect1" class="email-box" ng-hide="showemail">
                        <p class="marbot10">[[show_sudomain_name]]<br/></p>
                        {{Form::text('email','', ['placeholder'=>'Type your email','class'=>"form-control marbot5"])}}
                        {{Form::text('password','', ['placeholder'=>'Type your password','class'=>"form-control marbot5"])}}
                        {{Form::text('confirm_password','', ['placeholder'=>'Confirm your Password','class'=>"form-control marbot5"])}}
                        <mailcaptcha></mailcaptcha>
                        <div class="clearfix mar-top20"></div>
                        {{ Form::button('Create my bio', array('ng-click' => 'createBioSubmit()','name' => 'create_bio','class' => 'btn btn-primary create-bio-btn')) }}
                        {{ Form::button('Cancel', array('ng-click' => 'closeForm()', 'class' => 'closeform btn btn-primary create-bio-cancel-btn')) }}
                        <div class="clearfix"></div>
                        <div class=" text-center mar-top20">By clicking on any of the links above you are agreeing to our
                            Terms and Conditions and Privacy
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="effect2" class="email-box" ng-hide="showmobile">
                        <p class="marbot10">[[show_sudomain_name]]</p>
                        {{Form::text('phoneno','', ['placeholder'=>'Type your phoneno','class'=>"form-control marbot5"])}}
                        {{Form::text('password','', ['placeholder'=>'Type your password','class'=>"form-control marbot5"])}}
                        {{Form::text('confirm_password','', ['placeholder'=>'Confirm your Password','class'=>"form-control marbot5"])}}
                        <mobilecaptcha></mobilecaptcha>
                        <div class="clearfix mar-top20"></div>
                        {{ Form::button('Create my bio', array('name' => 'create_bio','class' => 'btn btn-primary create-bio-btn')) }}
                        {{ Form::button('Cancel', array('ng-click' => 'closeForm()', 'class' => 'closeform btn btn-primary create-bio-cancel-btn')) }}
                        <div class="clearfix"></div>
                        <div class=" text-center mar-top20">
                            By clicking on any of the links above you are agreeing to our Terms and Conditions and Privacy
                        </div>
                    </div>                  
                </div>
                <div class="clearfix"></div>
                <!-- Verify code starts here -->
                <div class="col-md-12 mar-top20"  ng-hide="1">
                    <p>We have sent you a verification code<br>
                        please type it below to confirm your account creation</p>
                    <div class="clearfix"></div>
                    <div class="form-container">
                        <div class="col-md-12 pad0"><span class="pull-left width63per" style=" margin-right:2%;"><input type="text" name="user" placeholder="6 digit code" class="form-control marbot5"></span>
                            <span class="pull-left width35per">
                                <input type="submit" name="login" class="btn btn-primary create-bio-btn pull-right btn-block" value="Confirm" style="height:35px;">
                            </span>
                        </div>
                    </div>
                </div>
                <!--Verify code ends here-->
                <div class="clearfix"></div>
                <!--Edit bio user starts here -->
                <div class="form-container mar-top20" ng-hide="1">   
                    <div class="col-md-12 ">
                        <h4>Congratulations your bio is live online</h4>
                        <span class=" col-md-6">
                            <input type="submit" name="login" class="btn btn-primary create-bio-btn pull-left" value="Edit my bio">
                        </span>
                        <span class=" col-md-6" >
                            <input type="submit" name="login" class="btn btn-primary create-bio-btn pull-right" value="View my bio">
                        </span>
                    </div>   
                </div> 
                <!--Edit bio user ends here -->
            </div>
        </div>
    </section>
    <!--footer section starts here-->
    @include('layout.signup-footer')
    <!--End of footer section -->
</body>
@stop
<!--body section ends here-->