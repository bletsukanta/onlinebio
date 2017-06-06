@extends('admin.layouts.dashboard')
@section('page_heading','Edit Email Template')
@section('section')
   
    <?php 
    if(Session::has('sucmsg')){ ?>
    <div class="col-lg-10" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    <?php } ?>
     <?php   //print_r($data);exit;?>
    {{Form::open (array ('url' => url('backend/postEmailTemplate'),'name'=>'frmlogin','id'=>'frmlogin','onSubmit'=>'return validateEmailTemplate()'))}}           
    {{ Form::hidden('reference_id', $data->id, array('id' => 'reference_id')) }}
        <div class="col-lg-10">
            <div class="form-group">
                <label>Title</label>
                {{Form::text('title',$data->title, array ('placeholder'=>'Title','class'=>"form-control",'id'=>'title'))}}
            </div>
            <div class="form-group">
                <label>Subject</label>
                {{Form::text('subject',$data->subject, array ('placeholder'=>'Subject','class'=>"form-control",'id'=>'subject'))}}

            </div>
            <div class="form-group">
                <label>Content</label>
                {{Form::textarea('content',$data->contents, array ('class'=>"ckeditor",'id'=>'content'))}}
            </div>
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary">Update</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/emailtemplates")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">
        function validateEmailTemplate(){
            if($("#title").val() == "" ){
                $("#title").parent('div').addClass('has-error');
                $("#title").focus();
                return false;
            }else{
                $("#title").parent('div').removeClass('has-error');	
            }
            if($("#subject").val() == "" ){
                $("#subject").parent('div').addClass('has-error');
                $("#subject").focus();
                return false;
            }else{
                $("#subject").parent('div').removeClass('has-error');	
            }
            if (CKEDITOR.instances.content.getData() == '' ){
                CKEDITOR.instances.content.focus();
                $("#content").parent('div').addClass('has-error');
                return false;
             }
//            if($("#content").val() == "" ){
//                $("#content").parent('div').addClass('has-error');
//                $("#content").focus();
//                return false;
//            }else{
//                $("#content").parent('div').removeClass('has-error');	   	   
//            }
          return true;
        }
    </script>  
@stop
