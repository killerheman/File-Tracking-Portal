@extends('filetrack.includes.layout')

@section('title','Dashboard')
@section('header-area')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/pages/dashboard-analytics.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/pages/card-analytics.css') }}">

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/charts/apexcharts.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('backend/assets/vendors/css/extensions/tether-theme-arrows.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/extensions/tether.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('backend/assets/vendors/css/extensions/shepherd-theme-default.css') }}">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/bootstrap-extended.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/colors.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/components.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/themes/dark-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/themes/semi-dark-layout.css') }}">

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/core/menu/menu-types/vertical-menu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/core/colors/palette-gradient.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/plugins/tour/tour.css') }}">
<!-- END: Page CSS-->

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style.css') }}">
<!-- END: Custom CSS-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection

@section('content')
    <section id="dashboard-analytics">
        <div class="row">
           @hasanyrole('Admin|Super Admin|Master File User|Mid File User')
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-users fa-2x text-primary" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1 mb-25">{{$users}}</h2>
                        <p class="mb-0">All Users</p>
                    </div>
                    <div class="card-content">
                        <div id="subscribe-gain-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-snowflake-o fa-2x text-info" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1 mb-25"> {{$todayfile}} </h2>
                        <p class="mb-0">Today  Files</p>
                    </div>
                    <div class="card-content">
                        <div id="orders-received-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-modx fa-2x text-success" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1 mb-25"> {{$monthfile}} </h2>
                        <p class="mb-0">This Month Files</p>
                    </div>
                    <div class="card-content">
                        <div id="subscribe-gain-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-pie-chart fa-2x text-danger" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1 mb-25">{{$weekfile}}</h2>
                        <p class="mb-0">This Week Files</p>
                    </div>
                    <div class="card-content">
                        <div id="orders-received-chart"></div>
                    </div>
                </div>
            </div>
          @endrole
       
           
          
        </div>
    </section>
    <section id="overlay-image-chat-cards">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card overlay-img-card text-white">
                    <img src="{{ asset('backend/app-assets/images/pages/card-image-6.jpg')}}" class="card-img" alt="card-img-6">
                    <div class="card-img-overlay overlay-black d-flex flex-column justify-content-between">
                        <h5 class="card-title text-white">Quote of the day</h5>
                        <div class="card-content">
                            <script type="text/javascript" src="https://www.brainyquote.com/link/quotebr.js"></script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card overlay-img-card text-white">
                    <img src="{{ asset('backend/app-assets/images/pages/card-image-5.jpg')}}" class="card-img" alt="card-img-6">
                    <div class="card-img-overlay overlay-black">
                        <h5 class="font-medium-5 text-white text-center mt-4">Snowy</h5>
                        <p class="text-white text-center">New York</p>
                        <div class="card-content">
                            <div class="d-flex justify-content-around mt-2">
                                <div class="icon">
                                    <i class="feather icon-cloud-snow font-large-5"></i>
                                </div>
                                <div class="temprature mt-3">
                                    <p class="font-large-3"> -6 <span class="mt-1">°</span></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mt-4">
                                    <div class="precipitation">
                                        <span class="font-medium-3">Precipitation</span>
                                    </div>
                                    <div class="degree">
                                        <span class="font-medium-3">48%</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between my-2">
                                    <div class="humidity">
                                        <span class="font-medium-3">Humidity</span>
                                    </div>
                                    <div class="degree">
                                        <span class="font-medium-3">60%</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between my-2">
                                    <div class="wind">
                                        <span class="font-medium-3">Wind</span>
                                    </div>
                                    <div class="degree">
                                        <span class="font-medium-3">23 km/h</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <script src="{{ asset('backend/assets/js/scripts/pages/dashboard-analytics.js') }}"></script>
@endsection
