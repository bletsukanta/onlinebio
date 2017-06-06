@extends('admin.layouts.dashboard')
@section('page_heading','Create Domain')
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
    
    @if(isset($domain_data_arr))
            @php ($domain_id = $domain_data_arr->id)
            @php ($domain_name = $domain_data_arr->domain_name)
            @php ($meta_title = $domain_data_arr->meta_title)
            @php ($meta_description = $domain_data_arr->meta_description)
            @php ($meta_keyword = $domain_data_arr->meta_keyword)
            @php ($category_id = explode(',',$domain_data_arr->category_id))
            @php ($favicon_image = $domain_data_arr->favicon_image)
            @php ($saveurl = url('backend/update-domain'))
    @else
            @php ($domain_id = '')
            @php ($domain_name = '')
            @php ($meta_title = '')
            @php ($meta_description = '')
            @php ($meta_keyword = '')
            @php ($category_id = '')
            @php ($favicon_image = '')
            @php ($saveurl = url('backend/save-domain'))
    @endif
    
    {{Form::open (array ('url' => $saveurl,'name'=>'frmdomain','id'=>'frmdomain','onSubmit'=>'return validateDomain()','files'=>true))}}           
    {{ Form::hidden('hdn_domain_id',$domain_id, array('id' => 'hdn_domain_id')) }}
        <div class="col-lg-5">
            <div class="form-group">
                <label>Domain Name</label>
                {{Form::text('domain_name',$domain_name, array ('placeholder'=>'Domain Name','class'=>"form-control",'id'=>'domain_name','autofocus'=>'autofocus','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Domain Category</label>
                {{ Form::select('domain_category[]', $domain_category_arr, $category_id, ['multiple'=>'multiple','placeholder' => 'Please select','class' => 'form-control','id'=>'domain_category','required'=>'required']) }}
            </div>
            <div class="form-group">
                <label>Meta Title</label>
                {{Form::text('meta_title', $meta_title, array ('placeholder'=>'Meta Title','class'=>"form-control",'id'=>'meta_title'))}}
            </div>
            <div class="form-group">
                <label>Meta Description</label>
                {{ Form::textarea('meta_description', $meta_description, ['placeholder'=>'Meta Description','size' => '30x5', 'id' => 'meta_description', 'class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-lg-5">
            
            <div class="form-group">
                <label>Meta Keyword</label>
                {{Form::text('meta_keyword', $meta_keyword, array ('placeholder'=>'Meta Keyword','class'=>"form-control",'id'=>'meta_keyword'))}}
            </div>
            <div class="form-group">
                <label>Favicon Image</label>
                {{Form::file('favicon_image')}}
            </div>
            <div class="form-group"> 
                <img src="{{ ($favicon_image != '')?asset('public/admin_favicon_image/'.$favicon_image): asset('public/images/profile-img.jpg')}}" class="img-circle" alt="profile image" width="109" height="115">
            </div>
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary"> @if(isset($domain_data_arr)) Update Domain @else Save Domain @endif </button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/domain-list")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">       
        function validateDomain(){
            if($("#domain_name").val() == "" ){
                $("#domain_name").parent('div').addClass('has-error');
                $("#domain_name").focus();
                return false;
            }else{
                $("#domain_name").parent('div').removeClass('has-error');	
            }
            if($("#domain_category").val() == "" ){
                $("#domain_category").parent('div').addClass('has-error');
                $("#domain_category").focus();
                return false;
            }else{
                $("#domain_category").parent('div').removeClass('has-error');	
            }
          return true;
        }
    </script>  
@stop
