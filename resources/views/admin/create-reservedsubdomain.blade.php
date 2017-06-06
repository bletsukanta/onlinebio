@extends('admin.layouts.dashboard')
@section('page_heading','Create Reserved Subdomain')
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
    
    @if(isset($reserved_subdomain))
            @php ($reserved_subdomain_id = $reserved_subdomain->id)
            @php ($reserved_subdomain_name = $reserved_subdomain->subdomain_name)
            @php ($domain_id = $reserved_subdomain->domain_id)
            @php ($subdomain_type = $reserved_subdomain->subdomain_type)
            @php ($saveurl = url('backend/update-reservedsubdomain'))
    @else
            @php ($reserved_subdomain_id = '')
            @php ($reserved_subdomain_name = '')
            @php ($domain_id = 0)
            @php ($subdomain_type = '')
            @php ($saveurl = url('backend/save-reservedsubdomain'))
    @endif
    
    {{Form::open (array ('url' => $saveurl,'name'=>'frmreservesubdomain','id'=>'frmreservesubdomain','onSubmit'=>'return validateReserveSubdomain()','files'=>true))}}           
    {{ Form::hidden('hdn_reserved_subdomain_id',$reserved_subdomain_id, array('id' => 'hdn_reserved_subdomain_id')) }}
        <div class="col-lg-5">
            <div class="form-group">
                <label>Subdomain Name</label>
                {{Form::text('reserved_subdomain_name',$reserved_subdomain_name, array ('placeholder'=>'Reserved Subdomain Name','class'=>"form-control",'id'=>'reserved_subdomain_name','autofocus'=>'autofocus','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Domain Name</label>
                {{ Form::select('domain_name', $domain_arr, $domain_id, ['placeholder' => 'Please select domain','class' => 'form-control','id'=>'domain_name','required'=>'required']) }}
            </div>
            <div class="form-group">
                <label>Subdomain Type</label>
                {{ Form::select('subdomain_type', $subdomaintype_arr, $subdomain_type, ['placeholder' => 'Please select sudomain type','class' => 'form-control','id'=>'subdomain_type','required'=>'required']) }}
            </div>
        </div>
        
        <div class="col-lg-10" align="left">
            <button  type="submit" class="btn btn-sm btn-primary"> @if(isset($reserved_subdomain)) Update @else Save @endif </button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/reserved-subdomain")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">       
        function validateReserveSubdomain(){
            if($("#reserved_subdomain_name").val() == "" ){
                $("#reserved_subdomain_name").parent('div').addClass('has-error');
                $("#reserved_subdomain_name").focus();
                return false;
            }else{
                $("#reserved_subdomain_name").parent('div').removeClass('has-error');	
            }
            if($("#domain_name").val() == "" ){
                $("#domain_name").parent('div').addClass('has-error');
                $("#domain_name").focus();
                return false;
            }else{
                $("#domain_name").parent('div').removeClass('has-error');	
            }
            if($("#subdomain_type").val() == "" ){
                $("#subdomain_type").parent('div').addClass('has-error');
                $("#subdomain_type").focus();
                return false;
            }else{
                $("#subdomain_type").parent('div').removeClass('has-error');	
            }
          return true;
        }
    </script>  
@stop
