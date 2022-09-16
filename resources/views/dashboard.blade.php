@extends('backend.includes.layout')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Floating Navbar</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="sk-layout-2-columns.html">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Starter Kit</a>
                            </li>
                            <li class="breadcrumb-item active">Floating Navbar
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Description -->
        <section id="description" class="card">
            <div class="card-header">
                <h4 class="card-title">Description</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="card-text">
                        <p>The floating navigation layout has a fixed navigation and floating navbar menu and
                            footer. Only navigation section and navbar menu is fixed to user. Navbar Wrapper has
                            specing from all sides. In this page you can experience it.</p>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Description -->
    </div>
@endsection
