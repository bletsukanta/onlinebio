@extends('admin.layouts.dashboard')
@section('page_heading','Edit Tutorial')
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
    {{Form::open (array ('url' => url('backend/postTutorialEdit'),'name'=>'frmContent','id'=>'frmContent','onSubmit'=>'return validateTutorials()'))}}           
    {{ Form::hidden('reference_id', $data->id, array('id' => 'reference_id')) }}
        <div class="col-lg-10">
            <div class="form-group">
                <label>Topic</label>
                {{Form::text('topic',$data->topic, array ('placeholder'=>'Topic','class'=>"form-control",'id'=>'topic'))}}
            </div>
            <div class="form-group">
                <label>Content</label>
                {{Form::textarea('content',$data->content, array ('class'=>"ckeditor",'id'=>'content'))}}
            </div>
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary">Update</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/tutorials")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">
        CKEDITOR.replace( 'content', {
            //filebrowserBrowseUrl: '/browser/browse.php',
            //filebrowserUploadUrl: 'http://192.168.0.114/onlinebio/public/admin/ckeditor/filemanager/connectors/php/upload.php'
            filebrowserUploadUrl: '{{ url("public/admin/ckeditor/filemanager/connectors/php/upload.php")}}'
        });
        function validateTutorials(){
            if($("#topic").val() == "" ){
                $("#topic").parent('div').addClass('has-error');
                $("#topic").focus();
                return false;
            }else{
                $("#topic").parent('div').removeClass('has-error');	
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
