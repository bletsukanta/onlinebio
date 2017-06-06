@extends ('admin.layouts.plane')
@section ('body')
<div class="container" style="padding-top: 100px;">
    <div class="row">
        <br>
        <center><b>OnlineBio Admin Panel</b></center>
        <br>
         <?php if(Session::has('message')){ ?>
        <div class="col-md-4 col-md-offset-4" align="center">
            <div class="alert alert-danger  alert-dismissable " role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-remove"></i>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('message') }}
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
           @section ('login_panel_title','Login to your account here')
           @section ('login_panel_body')

           {{Form::open (array ('url' => url('backend/postLogin'),'name'=>'frmlogin','id'=>'frmlogin','onSubmit'=>'return validateLogin()'))}}
                <fieldset>
                    <div class="form-group">
                        {{Form::email ('email','', array ('placeholder'=>'E-mail','class'=>"form-control",'id'=>'email','autofocus'=>'autofocus','required'=>'required'))}}

                    </div>
                    <div class="form-group">
                        {{Form::password ('password', array('placeholder'=>'Password','class'=>'form-control','name'=>'password','id'=>'password','required'=>'required')) }}

                    </div>
                    <!--<div class="checkbox">
                           <label>
                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                        </label>
                    </div>-->
                    <button  type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                </fieldset>
            {{Form::close ()}}
            <br/>
            <div class="text-primary"> <a href="#">Recover Your Password</a> </div>
            @endsection
            @include('admin.widgets.panel', array('as'=>'login', 'header'=>true))
        </div>
    </div>
</div>
<script type="text/javascript">
    function validateLogin(){
        //alert('hi suresh'); return false;
        var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
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