@extends('admin.layouts.dashboard')
@section('page_heading','Manage Domains')
@section('section')
<div class="panel-body">
     
    @if(Session::has('sucmsg'))
    <div class="col-lg-14" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    @endif
    <div  class="pull-left" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/import-domains")}}'">Import CSV or Excel</button></div>&nbsp;&nbsp;
    <div  class="pull-right" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/create-domain")}}'">Create Domain</button></div>
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th width="30%">Name</th>
                <th width="50%">Category Name</th>
                <th width="10%">Status</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($domain_list as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $val->domain_name }}</td>
                <td>{{ $val->category_name }}</td>
                <td> @if($val->status == 1)  Active @else Inactive @endif </td>
                <td>
                    <a href="{{url('/backend/edit-domain').'/'.$val->id }}" title="EditDomain">
                        <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="activeDomain({{ $val->id }},{{ $val->status }})" @if($val->status == '1') title="InActiveAdminUser" @else title="ActiveAdminUser" @endif >
                        @if($val->status == '1')
                            <i class="fa fa-ban"></i>
                        @else
                            <i class="fa fa-check-circle-o"></i>
                        @endif  
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="deleteDomain({{ $val->id }})" title="DeleteDomain">
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
    function activeDomain(domainid, status){
        var changestatusurl = "<?php echo url('/backend/domain/changestatus/'); ?>"+"/"+domainid+"/"+status;
        if(confirm('Do you really want to change status of domain ?')){
            window.location.href = changestatusurl;
        }
    }
    //Delete SubAdminUser
    function deleteDomain(domainid){
        var deleteurl = "<?php echo url('/backend/delete/domain'); ?>"+"/"+domainid;
        if(confirm('Do you really want to delete domain ?')){
            window.location.href = deleteurl;
        }
    }
</script>
@stop