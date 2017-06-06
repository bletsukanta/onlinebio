@extends('admin.layouts.dashboard')
@section('page_heading','Create Admin')
@section('section')
    <?php if(Session::has('message')){ ?>
    <div class="col-lg-10" align="center">
        <div class="alert alert-danger  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-remove"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('message') }}
        </div>
    </div>
    <?php } 
    if(Session::has('sucmsg')){ ?>
    <div class="col-lg-10" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    <?php } ?>
    {{Form::open (array ('url' => url('backend/saveadmin'),'name'=>'frmlogin','id'=>'frmlogin','onSubmit'=>'return validateProfile()'))}}           
        <div class="col-lg-4">
            <div class="form-group">
                <label>First Name</label>
                {{Form::text('first_name','', array ('placeholder'=>'First Name','class'=>"form-control",'id'=>'first_name','autofocus'=>'autofocus','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Email ID</label>
                {{Form::email ('email','', array ('placeholder'=>'E-mail','class'=>"form-control",'id'=>'email','required'=>'required'))}}

            </div>
            <div class="form-group">
                <label>Phone Number</label>
                {{Form::text('phone_no','', array ('placeholder'=>'Phone Number','class'=>"form-control",'id'=>'phone_no','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Address</label>
                {{Form::text('address','', array ('placeholder'=>'Address','class'=>"form-control",'id'=>'address','required'=>'required'))}}

            </div>
            <div class="form-group">
                <label>State</label>
                {{Form::text('state','', array ('placeholder'=>'State','class'=>"form-control",'id'=>'state'))}}
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label>Last Name</label>
                {{Form::text('last_name','', array ('placeholder'=>'Last Name','class'=>"form-control",'id'=>'last_name','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Alt Email</label>
                {{Form::email ('alt_email','', array ('placeholder'=>'Alt E-mail','class'=>"form-control",'id'=>'alt_email'))}}

            </div>
            <div class="form-group">
                <label>Alt Phone Number</label>
                {{Form::text('alt_phone_no','', array ('placeholder'=>'Alt Phone No','class'=>"form-control",'id'=>'alt_phone_no'))}}
            </div>
            <div class="form-group">
                <label>City</label>
                {{Form::text('city','', array ('placeholder'=>'City','class'=>"form-control",'id'=>'city'))}}

            </div>
            <div class="form-group">
                <label>Country</label>
                {{Form::text('country','', array ('placeholder'=>'Country','class'=>"form-control",'id'=>'country'))}}
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Password</label>
                {{Form::text('password','', array ('placeholder'=>'Password','class'=>"form-control",'id'=>'password','required'=>'required'))}}
            </div>
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary">Save Admin</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/adminusers")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">       
        function validateProfile(){
            var phone_exp = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
            var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            if($("#first_name").val() == "" ){
                $("#first_name").parent('div').addClass('has-error');
                $("#first_name").focus();
                return false;
            }else{
                $("#first_name").parent('div').removeClass('has-error');	
            }
            if($("#last_name").val() == "" ){
                $("#last_name").parent('div').addClass('has-error');
                $("#last_name").focus();
                return false;
            }else{
                $("#last_name").parent('div').removeClass('has-error');	
            }
            if($("#email").val() == "" ){
                $("#email").parent('div').addClass('has-error');
                $("#email").focus();
                return false;
            }else if(!$("#email").val().match(emailExp)){
                $("#email").parent('div').addClass('has-error');
                $("#email").focus();
                return false;
            }else{
                $("#email").parent('div').removeClass('has-error');	   	   
            }
            if($("#phone_no").val() == "" ){
                $("#phone_no").parent('div').addClass('has-error');
                $("#phone_no").focus();
                return false;
            }else if(!$("#phone_no").val().match(phone_exp)){
                $("#phone_no").parent('div').addClass('has-error');
                $("#phone_no").focus();
                return false;
            }else{
                $("#phone_no").parent('div').removeClass('has-error');	
            }
            if($("#address").val() == "" ){
                $("#address").parent('div').addClass('has-error');
                $("#address").focus();
                return false;
            }else{
                $("#address").parent('div').removeClass('has-error');	
            }
            if($("#password").val() == "" ){
                $("#password").parent('div').addClass('has-error');
                $("#password").focus();
                return false;
            }else{
                $("#password").parent('div').removeClass('has-error');	
            }
          return true;
        }
    </script>  
@stop
