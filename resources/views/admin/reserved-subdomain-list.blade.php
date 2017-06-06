@extends('admin.layouts.dashboard')
@section('page_heading','Manage Reserved Subdomain')
@section('section')
@php( $subdomaintype_arr = config('constants.subdomain_type')) 

<div class="panel-body">
     
    @if(Session::has('sucmsg'))
    <div class="col-lg-14" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    @endif
    <div  class="pull-left" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/import-reserved-subdomains")}}'">Import CSV or Excel</button></div>&nbsp;&nbsp;
    <div  class="pull-right" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/create-reservedsubdomain")}}'">Create Reserved-Subdomain</button></div>
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th width="30%">Subdomain Name</th>
                <th width="20%">Domain Name</th>
                <th width="30%">Subdomain Type</th>
                <th width="10%">Is Used</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reserved_subdomain_list as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $val->subdomain_name }}</td>
                <td>{{ $val->domain_name }}</td>
                <td>{{ $subdomaintype_arr[$val->subdomain_type] }}</td>
                <td> @if($val->is_used == 1)  Yes @else No @endif </td>
                <td>
                    <a href="{{url('/backend/edit-reserved-subdomain').'/'.$val->id }}" title="EditReservedSubdomain">
                        <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    @if($val->is_used == 0)
                    <a href="javascript:void(0);" onClick="deleteReservedSubDomain({{ $val->id }})" title="DeleteReservedSubdomain">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    @else
                    <a href="javascript:void(0);" onClick="javascript:void(0);" title="DeleteReservedSubdomain">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>	
</div>
<script type="text/javascript">
    //Delete deleteReservedSubDomain
    function deleteReservedSubDomain(reservedsubdomain_id){
        var deleteurl = "<?php echo url('/backend/delete/reserved-subdomain'); ?>"+"/"+reservedsubdomain_id;
        if(confirm('Do you really want to delete reserved subdomain ?')){
            window.location.href = deleteurl;
        }
    }
</script>
@stop