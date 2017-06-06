@extends('admin.layouts.dashboard')
@section('page_heading','Manage Domain Image')
@section('section')
<div class="panel-body">
     
    @if(Session::has('sucmsg'))
    <div class="col-lg-10" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    @endif
    <div  class="pull-right" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/add-domain-image")}}'">Add Image</button></div>
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th width="40%">Domain Name</th>
                <th width="30%">Image</th>
                <th width="20%">No of Images</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($domain_list as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $val->domain_name }}</td>
                <td><img src="{{ asset("public/domain_images/thumb/".$val->image_name)}}" class="img-thumbnail" alt="domain image" width="170" height="50"></td>
                <td>{{ $val->cntdomain }}</td>
                <td>
                    <a href="{{url('/backend/edit-domain-image').'/'.$val->domain_id }}" title="EditDomain">
                        <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="deleteDomainImage({{ $val->domain_id }})" title="DeleteDomain">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>	
</div>
<script type="text/javascript">
    //Delete domain image
    function deleteDomainImage(domainid){
        var deleteurl = "{{url('/backend/delete/domain-image-multiple')}}"+"/"+domainid;
        if(confirm('Do you really want to delete this?')){
            window.location.href = deleteurl;
        }
    }
</script>
@stop