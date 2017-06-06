@extends('admin.layouts.dashboard')
@section('page_heading','Import Reserved Subdomains')
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
    {{Form::open (array ('url' => url('backend/save-import-reservedsubdomains'),'name'=>'frmimportsubdomain','id'=>'frmimportsubdomain','onSubmit'=>'return validateImportSubdomain()','files'=>true))}}           
        <div class="col-lg-5">
            <div class="form-group">
                <label>Import Domains</label>
                {{Form::file('import_subdomain',array ('id'=>'import_subdomain','autofocus'=>'autofocus','required'=>'required'))}}
            </div>
            <!--div class="form-group">&nbsp;&nbsp;</div-->
            <div class="form-group">
                <a href="{{asset('public/sample_import_files/import_reserved_subdomains_sample.csv')}}" class="bluelink">Download formatted sample</a>
            </div>
        </div>
        
        <div class="col-lg-10" align="left">
            <button  type="submit" class="btn btn-sm btn-primary">ImportReservedSubDomains</button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/reserved-subdomain")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">       
        function validateImportSubdomain(){
            if($("#import_subdomain").val() == "" ){
                $("#import_subdomain").parent('div').addClass('has-error');
                $("#import_subdomain").focus();
                return false;
            }else{
                $("#import_subdomain").parent('div').removeClass('has-error');	
            }
          return true;
        }
    </script>  
@stop
