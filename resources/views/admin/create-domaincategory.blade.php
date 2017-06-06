@extends('admin.layouts.dashboard')
@section('page_heading','Create Domain Category')
@section('section')
    @if(Session::has('message'))
    <div class="col-lg-10" align="center">
        <div class="alert alert-danger  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-remove"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('message') }}
        </div>
    </div>
    @endif 
    @if(Session::has('sucmsg'))
    <div class="col-lg-10" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    @endif
    
    @if(isset($data))
            @php ($category_name = $data->category_name)
            @php ($category_id = $data->id)
            @php ($saveurl = url('backend/update-domaincategory'))
    @else
            @php ($category_name = '')
            @php ($category_id = 0)
            @php ($saveurl = url('backend/save-domaincategory'))
    @endif
    
    {{Form::open (array ('url' => $saveurl,'name'=>'frmcategory','id'=>'frmcategory','onSubmit'=>'return validateCategory()'))}}           
    {{ Form::hidden('hdn_domain_categoryid',$category_id, array('id' => 'hdn_domain_categoryid')) }}
        <div class="col-lg-5">
            <div class="form-group">
                <label>Category Name</label>
                
                {{Form::text('category_name',$category_name, array ('placeholder'=>'Category Name','class'=>"form-control",'id'=>'category_name','autofocus'=>'autofocus','required'=>'required'))}}
            </div>
        </div>
        <div class="col-lg-10" align="left">
            <button  type="submit" class="btn btn-sm btn-primary"> @if(isset($data)) Update Category @else Save Category @endif </button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/domain-category")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">       
        function validateCategory(){
            if($("#category_name").val() == "" ){
                $("#category_name").parent('div').addClass('has-error');
                $("#category_name").focus();
                return false;
            }else{
                $("#category_name").parent('div').removeClass('has-error');	
            }
          return true;
        }
    </script>  
@stop
