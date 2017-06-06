@extends('admin.layouts.dashboard')
@section('page_heading','Manage Services')
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
    <div  class="pull-right" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/create-domainservice")}}'">Create Service</button></div>
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th width="30%">Service Name</th>
                <th width="20%">Domain Name</th>
                <th width="30%">Description</th>
                <th width="10%">Status</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($domain_service_list as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $val->service_name }}</td>
                <td>{{ $val->domain_name }}</td>
                <td>{{ $val->short_description }}</td>
                <td> @if($val->status == 1)  Active @else Inactive @endif </td>
                <td>
                    <a href="{{url('/backend/edit-domainservice').'/'.$val->id }}" title="EditService">
                        <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="activeDomainService({{ $val->id }},{{ $val->status }})" @if($val->status == '1') title="InActiveService" @else title="ActiveService" @endif >
                        @if($val->status == '1')
                            <i class="fa fa-ban"></i>
                        @else
                            <i class="fa fa-check-circle-o"></i>
                        @endif  
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="deleteDomainService({{ $val->id }})" title="DeleteService">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>	
</div>
<script type="text/javascript">
    //Change the status of SubAdminUser 
    function activeDomainService(service_id, status){
        var changestatusurl = "<?php echo url('/backend/domain-service/changestatus/'); ?>"+"/"+service_id+"/"+status;
        if(confirm('Do you really want to change status of service ?')){
            window.location.href = changestatusurl;
        }
    }
    //Delete SubAdminUser
    function deleteDomainService(service_id){
        var deleteurl = "<?php echo url('/backend/delete/domain-service'); ?>"+"/"+service_id;
        if(confirm('Do you really want to delete service ?')){
            window.location.href = deleteurl;
        }
    }
</script>
@stop