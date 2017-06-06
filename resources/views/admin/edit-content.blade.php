@extends('admin.layouts.dashboard')
@section('page_heading','Edit Contents')
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
     <?php   //print_r($data);exit;?>
    {{Form::open (array ('url' => url('backend/postContent'),'name'=>'frmContent','id'=>'frmContent','onSubmit'=>'return validateContent()'))}}           
    {{ Form::hidden('reference_id', $data->id, array('id' => 'reference_id')) }}
        <div class="col-lg-10">
            <div class="form-group">
                <label>Title</label>
                {{Form::text('content_title',$data->content_title, array ('placeholder'=>'Content Title','class'=>"form-control",'id'=>'content_title'))}}
            </div>
            <div class="form-group">
                <label>Content</label>
                {{Form::textarea('content_description',$data->content_description, array ('class'=>"ckeditor",'id'=>'content_description'))}}
            </div>
            <div class="form-group">
                <label>Meta Title</label>
                {{Form::text('meta_title',$data->meta_title, array ('placeholder'=>'Meta Title','class'=>"form-control",'id'=>'meta_title'))}}
            </div>
            <div class="form-group">
                <label>Meta Keyword</label>
                {{Form::text('meta_keyword',$data->meta_keyword, array ('placeholder'=>'Meta Keyword','class'=>"form-control",'id'=>'meta_keyword'))}}
            </div>
            <div class="form-group">
                <label>Meta Description</label>
                {{Form::text('meta_descr',$data->meta_descr, array ('placeholder'=>'Title','class'=>"form-control",'id'=>'meta_keyword'))}}
            </div>
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary">Update</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/contents")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">
        function validateContent(){
            if($("#content_title").val() == "" ){
                $("#content_title").parent('div').addClass('has-error');
                $("#content_title").focus();
                return false;
            }else{
                $("#content_title").parent('div').removeClass('has-error');	
            }
            if (CKEDITOR.instances.content_description.getData() == '' ){
                CKEDITOR.instances.content_description.focus();
                $("#content_description").parent('div').addClass('has-error');
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
