@extends('admin.layouts.plane')

@section('body')
 <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<!--                <a class="navbar-brand" href="{{ url('backend/dashboard') }}">Admin v1.0</a>-->
<a class="navbar-brand" href="{{ url('backend/editprofile') }}">Welcome : <em class="text-primary"> {{ Session::get('bio_admin_name') }} </em></a>
                
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ url('/backend/editprofile')}}" ><i class="fa fa-user fa-fw"></i> Edit Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/backend/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li {{ (Request::is('/') ? 'class="active"' : '') }}>
                            <a href="{{ url('/backend/dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-book"></i> Manage Contents<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/contents') }}">Contents</a>
                                </li>
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/faqs') }}">FAQs</a>
                                </li>
                               
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/tutorials') }}">Tutorials</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @if(Session::get('bio_user_type')=='admin') 
                        <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                            <a href="{{ url('/backend/adminusers') }}"><i class="fa fa-user fa-fw"></i> Manage Subadmin</a>
                        </li>
                        @endif
                        <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                            <a href="{{ url('/backend/contactus') }}"><i class="fa fa-list-alt"></i> Manage Contact Us</a>
                        </li>
                        <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                            <a href="{{ url('/backend/emailtemplates') }}"><i class="fa fa-envelope-o"></i> Manage EmailTemplates</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-rss"></i> Domain Settings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/domain-category') }}">Domain Category</a>
                                </li>
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/domain-list') }}">Domain List</a>
                                </li>
                                 <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/domain-image') }}">Domain Images</a>
                                </li>
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/domainservice-list') }}">Service List</a>
                                </li>
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/reserved-subdomain') }}">Reserved Subdomain</a>
                                </li>
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/edit-subdomainprice') }}">Edit SubdomainPrice</a>
                                </li>
                            </ul>
                        </li>    
                        <li>
                            <a href="#"><i class="fa fa-gear fa-fw"></i>Profile Settings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/editprofile') }}">Edit Profile</a>
                                </li>
                                @if(Session::get('bio_user_type')=='admin') 
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/editsocialmedia') }}">Edit Social Media</a>
                                </li>
                                @endif
                                <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                    <a href="{{ url('/backend/changepassword') }}">Change Password</a>
                                </li>
                                <li>
                                    <a href="{{ url('/backend/logout') }}">Logout</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header1">@yield('page_heading')</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">  
                @yield('section')

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop

