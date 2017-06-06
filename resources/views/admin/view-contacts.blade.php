@extends('admin.layouts.dashboard')
@section('page_heading','View Contact Us')
@section('section')

<div class="panel-body">
    <div class="row show-grid">
        <div class="col-md-3">Name</div>
        <div class="col-md-9">{{ $data->contact_name }}</div>
    </div>
    <div class="row show-grid">
        <div class="col-md-3">Email</div>
        <div class="col-md-9">{{ $data->contact_email }}</div>
    </div>
    <div class="row show-grid">
        <div class="col-md-3">Phone No</div>
        <div class="col-md-9">{{ $data->phone_no }}</div>
    </div>
    <div class="row show-grid">
        <div class="col-md-3">Message</div>
        <div class="col-md-9">{{ $data->message }}</div>
    </div>
    <div class="col-lg-10" align="center">
        <button  type="button" class="btn btn-sm btn-primary" onclick="window.location='{{url("/backend/contactus")}}'">Cancel</button>
    </div>
    <div class="col-lg-10" style="min-height:30px;"></div>
</div>
@stop