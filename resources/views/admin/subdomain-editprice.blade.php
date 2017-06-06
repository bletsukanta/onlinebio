@extends('admin.layouts.dashboard')
@section('page_heading','Subdomain Price')
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
    
    {{Form::open (array ('url' => 'backend/update-subdomainprice','name'=>'frmprice','id'=>'frmprice','onSubmit'=>'return validatePrice()'))}}           
        <div class="col-lg-5">
            <div class="form-group">
                <label>Generic Price</label>
                {{Form::text('generic_price',$subdomain_price->generic_price, array ('placeholder'=>'Generic price','class'=>"form-control",'id'=>'generic_price','autofocus'=>'autofocus','required'=>'required'))}}
            </div>
            <div class="form-group">
                <label>Premium Price</label>
                {{ Form::text('premium_tire1_price', $subdomain_price->premium_tire1_price, ['placeholder' => 'Premium_tire1_price','class' => 'form-control','id'=>'premium_tire1_price','required'=>'required']) }}
            </div>
            
            <div class="form-group">
                <label>SuperPremium Price</label>
                {{ Form::text('premium_tire2_price', $subdomain_price->premium_tire2_price, ['placeholder'=>'premium_tire2_price', 'id' => 'premium_tire2_price', 'class' => 'form-control','required'=>'required']) }}
            </div>
        </div>
        
        <div class="col-lg-10" align="left">
            <button  type="submit" class="btn btn-sm btn-primary">  Update </button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend")}}'">Cancel</button>
        </div>
        <div class="col-lg-10" style="min-height:30px;"></div>
    {{Form::close ()}} 
    <script type="text/javascript">       
        function validateService(){
            if($("#generic_price").val() == "" ){
                $("#generic_price").parent('div').addClass('has-error');
                $("#generic_price").focus();
                return false;
            }else{
                $("#generic_price").parent('div').removeClass('has-error');	
            }
            if($("#premium_tire1_price").val() == "" ){
                $("#premium_tire1_price").parent('div').addClass('has-error');
                $("#premium_tire1_price").focus();
                return false;
            }else{
                $("#premium_tire1_price").parent('div').removeClass('has-error');	
            }
            if($("#premium_tire2_price").val() == "" ){
                $("#premium_tire2_price").parent('div').addClass('has-error');
                $("#premium_tire2_price").focus();
                return false;
            }else{
                $("#premium_tire2_price").parent('div').removeClass('has-error');	
            }
          return true;
        }
    </script>  
@stop
