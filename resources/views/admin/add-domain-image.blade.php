@extends('admin.layouts.dashboard')
@section('page_heading','Add/Edit Domain Image')
@section('section')
    @if(Session::has('message'))
    <div class="col-lg-10" align="center">
        <div class="alert alert-danger  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-remove"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('message') }}
        </div>
    </div>
    @endif 
    <div class="col-lg-10" align="center">
        <div class="alert alert-danger  alert-dismissable " role="alert" id="validation-errors" style="display: none;">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-remove"></i>
         
        </div>
    </div>
    <?php //print "<pre>"; print_r($domain_image_arr);exit;?>
    @if(isset($domain_image_arr))
            @php ($domain_id = $domain_image_arr[0]->domain_id)
    @else
            @php ($domain_id = '0')
    @endif
    
    {{Form::open (array ('name'=>'frmdomain','id'=>'frmdomain','url'=>'backend/save-domain-image','onSubmit'=>'return validateDomain()','files'=>true))}} 
    {{ Form::hidden('hdn_domain_id',$domain_id, array('id' => 'hdn_domain_id')) }}
        <div class="col-lg-5">
            <div class="form-group">
                <label>Domain Name</label>
                {{ Form::select('domain_name', $domain_name_arr, $domain_id, ['placeholder' => 'Please select domain','class' => 'form-control','id'=>'domain_name']) }}
            </div>
            <div class="form-group">
                <label>Domain Image (Multiple image upload here)</label>
                {{Form::file('domain_image[]',['id'=>'domain_image','multiple'=>true,'onChange'=>'saveTempImage()'])}}
            </div>
            <div class="form-group text-danger">
              [ You can upload multiple images for each domain. Upto 5 images need to be uploaded]  <br/>
              [ For better image display please upload image with  dimension: 1000 X 293 px (i.e width X height)]
            </div>
        </div>
        <div class="col-lg-5" id="domain_preview_image">
            @if(isset($domain_image_arr))
                @foreach($domain_image_arr as $val)
                <div  class="pull-left">
                    <img src="{{ asset("public/domain_images/thumb/".$val->image_name)}}" class="img-thumbnail" alt="domain image" width="170" height="50">
                    <div class="text-center"> <a href="javascript:void(0);" onClick="deleteDomainImage({{ $val->id }})" title="Delete Image"><i class="fa fa-trash-o"></i></a></div>
                </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-10" align="center">
            <button  type="submit" class="btn btn-sm btn-primary"> Add Images </button>
            <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/domain-image")}}'">Cancel</button>
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
            if($("#domain_image").val() == "" ){
                $("#domain_image").parent('div').addClass('has-error');
                $("#domain_image").focus();
                return false;
            }else{
                $("#domain_image").parent('div').removeClass('has-error');	
            }
          return true;
        }
        function saveTempImage(){
            var url = '{{url("/backend/uploadFiles")}}';
            //alert(url);
            //var imageData=$("#domain_image").val();
            var data = new FormData();
            jQuery.each(jQuery('#domain_image')[0].files, function(i, file) {
                data.append('imgfile', file);
            });
            //alert(data);
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data:data,
                success: function(results) { //alert(results);
                    if(results !="0"){
                        var imgStr = '<div  class="pull-left"><img src="{{ asset("public/preview_images")}}/'+results+'" class="img-thumbnail" alt="domain image" width="170" height="50">\n\
                                       <div class="text-center"> <a href="javascript:void(0);" onClick="deletePreviewImage(\''+results+'\')" title="Delete Image"><i class="fa fa-trash-o"></i></a></div> \n\
                                       <input type="hidden" name="hid_img[]" value="'+results+'" ></div>';
                        $("#domain_preview_image").append(imgStr);
                    }else{
                        $("#validation-errors").show();
                        $("#validation-errors button").after("Sorry! invalid image format.");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }); // close
         }
         //Delete domain image
        function deleteDomainImage(imgid){
            var deleteurl = "{{ url('/backend/delete/domain-image-single') }}"+"/"+imgid;
            if(confirm('Do you really want to delete this?')){
                window.location.href = deleteurl;
            }
        }
        function deletePreviewImage(img){//alert(img);
            var domain_id = $("#hdn_domain_id").val();
            var deleteurl = "{{ url('/backend/delete/domain-image-preview') }}"+"/"+img+"/"+domain_id;
            if(confirm('Do you really want to delete this?')){
                window.location.href = deleteurl;
            }
        }
        
    </script>  
@stop
