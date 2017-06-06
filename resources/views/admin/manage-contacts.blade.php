@extends('admin.layouts.dashboard')
@section('page_heading','Manage Contact Us')
@section('section')
<div class="panel-body">
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th width="10%">Sl No</th>
                <th width="30%">Name</th>
                <th width="30%">Email</th>
                <th width="20%">Phone No</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $val->contact_name }}</td>
                <td>{{ $val->contact_email }}</td>
                <td>{{ $val->phone_no }}</td>
                <td align="center">
                    <a href="{{url('/backend/viewcontacts').'/'.$val->id.'/view' }}" title="View Contacts">
                        <i class="fa fa-eye"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="deleteContacts({{ $val->id }})" title="DeleteTutorial">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>	
</div>
<script type="text/javascript">
    //Delete SubAdminUser
    function deleteContacts(contactid){
        var deletecontacturl = "<?php echo url('/backend/deleteContact'); ?>"+"/"+contactid;
        if(confirm('Do you really want to delete this record?')){
            window.location.href = deletecontacturl;
        }
    }
</script>
@stop