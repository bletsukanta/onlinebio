@extends('admin.layouts.dashboard')
@section('page_heading','Manage Subadmin')
@section('section')

<div class="panel-body">
    <?php  
    if(Session::has('sucmsg')){ ?>
    <div class="col-lg-10" align="center">
        <div class="alert alert-success  alert-dismissable " role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  <i class="fa fa-check"></i>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ Session::get('sucmsg') }}
        </div>
    </div>
    <?php } ?>
    <div  class="pull-right" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/createadmin")}}'">Create Subadmin</button></div>
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subadminusers as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $val->first_name." ".$val->last_name }}</td>
                <td>{{ $val->email }}</td>
                <td>{{ $val->address }}</td>
                <td>{{ $val->phone_no }}</td>
                <td> @if($val->status == 1)  Active @else Inactive @endif </td>
                <td>
                    <a href="{{url('/backend/editadmin').'/'.$val->id }}" title="EditAdminUser">
                        <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="activeSubAdminUser({{ $val->id }},{{ $val->status }})" @if($val->status == '1') title="InActiveAdminUser" @else title="ActiveAdminUser" @endif >
                        @if($val->status == '1')
                            <i class="fa fa-ban"></i>
                        @else
                            <i class="fa fa-check-circle-o"></i>
                        @endif  
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="deleteSubAdminUser({{ $val->id }})" title="DeleteAdminUser">
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
    function activeSubAdminUser(adminuserid, status){
        var changestatusurl = "<?php echo url('/backend/changestatus'); ?>"+"/"+adminuserid+"/"+status;
        if(confirm('Do you really want to change status of user ?')){
            window.location.href = changestatusurl;
        }
    }
    //Delete SubAdminUser
    function deleteSubAdminUser(adminuserid){
        var deleteuserurl = "<?php echo url('/backend/deleteadmin'); ?>"+"/"+adminuserid;
        if(confirm('Do you really want to delete user ?')){
            window.location.href = deleteuserurl;
        }
    }
</script>
@stop