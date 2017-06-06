@extends('admin.layouts.dashboard')
@section('page_heading','Manage Contents')
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
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th>Sl No</th>
                <th>Type</th>
                <th>Content Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Data as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $loop->iteration }}</td>
                <td>{{ strtoupper($val->type) }}</td>
                <td>{{ $val->content_title }}</td>
                <td align="center">
                    <a href="{{url('/backend/editcontent').'/'.$val->id.'/edit' }}" title="EditContents">
                        <i class="fa fa-edit"></i>
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