@extends('admin.layouts.dashboard')
@section('page_heading','Edit Social Media')
@section('section')
    <?php if(Session::has('sucmsg')){ ?>
    <div class="col-lg-10" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    <?php } ?>
    {{Form::open (array ('url' => url('backend/postsocialmedia'),'name'=>'frmlogin','id'=>'frmlogin','onSubmit'=>'return validateSocialMedia()'))}}           
    <?php   //print_r($data);?>
        <div class="col-lg-5">
            <div class="form-group">
                <label>Facebook URL</label>
                {{Form::text('facebook_url',$data->facebook_url, array ('placeholder'=>'Facebook URL','class'=>"form-control",'id'=>'facebook_url','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Twitter URL</label>
                {{Form::text('twitter_url',$data->twitter_url, array ('placeholder'=>'Twitter URL','class'=>"form-control",'id'=>'twitter_url','required'=>'required'))}}

            </div>
            <div class="form-group">
                <label>Pinterest URL</label>
                {{Form::text('pinterest_url',$data->pinterest_url, array ('placeholder'=>'Pinterest URL','class'=>"form-control",'id'=>'pinterest_url'))}}
            </div>
        </div>
        <div class="col-lg-5">
            <div class="form-group">
                <label>LinkedIn URL</label>
                {{Form::text('linkdin_url',$data->linkdin_url, array ('placeholder'=>'LinkedIn URL','class'=>"form-control",'id'=>'linkdin_url','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Googleplus URL</label>
                {{Form::text('googleplus_url',$data->googleplus_url, array ('placeholder'=>'Googleplus URL','class'=>"form-control",'id'=>'googleplus_url'))}}

            </div>
            <div class="form-group">
                <label>Instagram URL</label>
                {{Form::text('instagram_url',$data->instagram_url, array ('placeholder'=>'Instagram URL','class'=>"form-control",'id'=>'instagram_url'))}}
            </div>
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary">Edit Social Media</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/dashboard")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">
        function validateSocialMedia(){
            if($("#facebook_url").val() == "" ){
                $("#facebook_url").parent('div').addClass('has-error');
                $("#facebook_url").focus();
                return false;
            }else{
                $("#facebook_url").parent('div').removeClass('has-error');	
            }
            if($("#twitter_url").val() == "" ){
                $("#twitter_url").parent('div').addClass('has-error');
                $("#twitter_url").focus();
                return false;
            }else{
                $("#twitter_url").parent('div').removeClass('has-error');	
            }
            if($("#linkdin_url").val() == "" ){
                $("#linkdin_url").parent('div').addClass('has-error');
                $("#linkdin_url").focus();
                return false;
            }else{
                $("#linkdin_url").parent('div').removeClass('has-error');	   	   
            }
          return true;
        }
    </script>  
@stop
