@extends('admin.layouts.dashboard')
@section('page_heading','Create Service')
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
    
    @if(isset($service_data_arr))
            @php ($service_id = $service_data_arr->id)
            @php ($service_name = $service_data_arr->service_name)
            @php ($short_description = $service_data_arr->short_description)
            @php ($domain_id = $service_data_arr->domain_id)
            @php ($saveurl = url('backend/update-domainservice'))
    @else
            @php ($service_id = '')
            @php ($service_name = '')
            @php ($short_description = '')
            @php ($domain_id = 0)
            @php ($saveurl = url('backend/save-domainservice'))
    @endif
    
    {{Form::open (array ('url' => $saveurl,'name'=>'frmservice','id'=>'frmservice','onSubmit'=>'return validateService()','files'=>true))}}           
    {{ Form::hidden('hdn_service_id',$service_id, array('id' => 'hdn_service_id')) }}
        <div class="col-lg-5">
            <div class="form-group">
                <label>Service Name</label>
                {{Form::text('service_name',$service_name, array ('placeholder'=>'Service Name','class'=>"form-control",'id'=>'service_name','autofocus'=>'autofocus','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Domain Name</label>
                {{ Form::select('domain_name', $domain_arr, $domain_id, ['placeholder' => 'Please select domain','class' => 'form-control','id'=>'domain_name','required'=>'required']) }}
            </div>
            
            <div class="form-group">
                <label>Short Description</label>
                {{ Form::textarea('short_description', $short_description, ['placeholder'=>'Short Description','size' => '30x5', 'id' => 'short_description', 'class' => 'form-control']) }}
            </div>
        </div>
        
        <div class="col-lg-10" align="left">
            <button  type="submit" class="btn btn-sm btn-primary"> @if(isset($service_data_arr)) Update @else Save @endif </button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/domainservice-list")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">       
        function validateService(){
            if($("#service_name").val() == "" ){
                $("#service_name").parent('div').addClass('has-error');
                $("#service_name").focus();
                return false;
            }else{
                $("#service_name").parent('div').removeClass('has-error');	
            }
            if($("#domain_name").val() == "" ){
                $("#domain_name").parent('div').addClass('has-error');
                $("#domain_name").focus();
                return false;
            }else{
                $("#domain_name").parent('div').removeClass('has-error');	
            }
          return true;
        }
    </script>  
@stop
