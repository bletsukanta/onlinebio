@extends('admin.layouts.dashboard')
@section('page_heading','Change Password')
@section('section')
    <?php if(Session::has('message')){ ?>
    <div class="col-lg-5" align="center">
        <div class="alert alert-danger  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-remove"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('message') }}
        </div>
    </div>
    <?php } 
    if(Session::has('sucmsg')){ ?>
    <div class="col-lg-5" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    <?php } ?>
    <div class="clearfix"></div>
    {{Form::open (array ('url' => url('backend/postchangepassword'),'name'=>'frmlogin','id'=>'frmlogin','onSubmit'=>'return validateChangePassword()'))}}           
    <?php   //print_r($data);?>
        <div class="col-lg-5">
            <div class="form-group">
                <label>Old Password</label>
                {{Form::password('old_password', array ('placeholder'=>'Old Password','class'=>"form-control",'id'=>'old_password','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>New Password</label>
                {{Form::password('new_password', array ('placeholder'=>'New Password','class'=>"form-control",'id'=>'new_password','required'=>'required'))}}

            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                {{Form::password('confirm_password', array ('placeholder'=>'Confirm Password','class'=>"form-control",'id'=>'confirm_password','required'=>'required'))}}
            </div>
        </div>
        <div class="col-lg-12" align="left">
            <button  type="submit" class="btn btn-sm btn-primary">Change Password</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/dashboard")}}'">Cancel</button>
        </div>
        <div class="col-lg-5" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">
        function validateChangePassword(){
            if($("#old_password").val() == "" ){
                $("#old_password").parent('div').addClass('has-error');
                $("#old_password").focus();
                return false;
            }else{
                $("#old_password").parent('div').removeClass('has-error');	
            }
            if($("#new_password").val() == "" ){
                $("#new_password").parent('div').addClass('has-error');
                $("#new_password").focus();
                return false;
            }else{
                $("#new_password").parent('div').removeClass('has-error');	
            }
            if($("#confirm_password").val() == "" ){
                $("#confirm_password").parent('div').addClass('has-error');
                $("#confirm_password").focus();
                return false;
            }else if($("#confirm_password").val() != $("#new_password").val() ){
                $("#confirm_password").parent('div').addClass('has-error');
                $("#confirm_password").focus();
                return false;
            }else{
                $("#confirm_password").parent('div').removeClass('has-error');	   	   
            }
          return true;
        }
    </script>  
@stop
