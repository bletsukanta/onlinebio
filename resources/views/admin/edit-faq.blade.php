@extends('admin.layouts.dashboard')
@section('page_heading','Edit FAQs')
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
    {{Form::open (array ('url' => url('backend/postFaqEdit'),'name'=>'frmContent','id'=>'frmContent','onSubmit'=>'return validateFAQ()'))}}           
    {{ Form::hidden('reference_id', $data->id, array('id' => 'reference_id')) }}
        <div class="col-lg-10">
            <div class="form-group">
                <label>Question</label>
                {{Form::text('question',$data->question, array ('placeholder'=>'Question','class'=>"form-control",'id'=>'question'))}}
            </div>
            <div class="form-group">
                <label>Answer</label>
                {{Form::textarea('answer',$data->answer, array ('class'=>"ckeditor",'id'=>'answer'))}}
            </div>
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary">Update</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/faqs")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">
        function validateFAQ(){
            if($("#question").val() == "" ){
                $("#question").parent('div').addClass('has-error');
                $("#question").focus();
                return false;
            }else{
                $("#question").parent('div').removeClass('has-error');	
            }
            if (CKEDITOR.instances.answer.getData() == '' ){
                CKEDITOR.instances.answer.focus();
                $("#answer").parent('div').addClass('has-error');
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
