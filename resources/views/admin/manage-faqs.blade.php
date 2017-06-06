@extends('admin.layouts.dashboard')
@section('page_heading','Manage FAQs')
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
    <div  class="pull-right" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/addfaq")}}'">Add FAQs</button></div>
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th width="10%">Sl No</th>
                <th width="20%">Question</th>
                <th width="60%">Answer</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $val->question }}</td>
                <td>{!! str_limit($val->answer,200) !!}</td>
                <td align="center">
                    <a href="{{url('/backend/editfaq').'/'.$val->id.'/edit' }}" title="EditFaq">
                        <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="deleteSubAdminUser({{ $val->id }})" title="DeleteFaq">
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
    function deleteSubAdminUser(faqid){
        var deleteuserurl = "<?php echo url('/backend/deleteFaq'); ?>"+"/"+faqid;
        if(confirm('Do you really want to delete this question?')){
            window.location.href = deleteuserurl;
        }
    }
</script>
@stop