@extends('admin.layouts.dashboard')
@section('page_heading','Manage Tutorials')
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
    <div  class="pull-right" style="padding-bottom: 5px;"><button  type="button" class="btn btn-sm btn-primary" onClick="window.location='{{url("/backend/addtutorial")}}'">Add Tutorial</button></div>
    <table class="table table-bordered">
        <thead>
            <tr class="danger">
                <th width="10%">Sl No</th>
                <th width="20%">Topic</th>
                <th width="60%">Content</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $k => $val )
            <tr @if ($loop->iteration % 2) class="success" @else class="warning" @endif>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $val->topic }}</td>
                <td>{!! str_limit($val->content,200) !!}</td>
                <td align="center">
                    <a href="{{url('/backend/edittutorial').'/'.$val->id.'/edit' }}" title="EditTutorial">
                        <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0);" onClick="deleteTutorial({{ $val->id }})" title="DeleteTutorial">
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
    function deleteTutorial(topicid){
        var deletetopicurl = "<?php echo url('/backend/deleteTutorial'); ?>"+"/"+topicid;
        if(confirm('Do you really want to delete this topic?')){
            window.location.href = deletetopicurl;
        }
    }
</script>
@stop