@extends('filetrack.includes.layout')

@section('title', 'Edit Profile')

@section('head-area')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                User Profile
            </h3>
        </div>
        <div class="card-body">
            <form class="needs-validation"
                action="{{route('filetrack.fileuser.updateProfile') }}"
                method='post' enctype="multipart/form-data">
                @if (isset($editproduct))
                    @method('patch')
                @endif
                @csrf
                <input type="hidden" name="id" value="{{ Auth::guard('fileuser')->user()->id }}" />
                <div class="row">
                    <div class="col-md-3 mb-1">
                        <img src="{{ asset(Auth::guard('fileuser')->user()->pic) }}" class="me-75 bg-light-danger"
                            style="height:100px;width:100px;" />
                    </div>
                    <div class="col-md-4 mb-1 justify-content-start">
                        <h3>{{ Auth::guard('fileuser')->user()->full_name }}</h3>
                    </div>
                    <div class="col-md-4 mb-1 justify-content-start">
                        Role : <h3>{{ Auth::guard('fileuser')->user()->roles[0]->name }}</h3>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="basic-addon-name">First Name</label>

                        <input type="text" id="basic-addon-name" name='first_name' class="form-control"
                            value="{{ Auth::guard('fileuser')->user()->first_name }}" placeholder="First Name"
                            aria-label="Name" aria-describedby="basic-addon-name" required />
                    </div>
                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="basic-addon-name">Last Name</label>

                        <input type="text" id="basic-addon-name" name='last_name' class="form-control"
                            value="{{ Auth::guard('fileuser')->user()->last_name }}" placeholder="Name"
                            aria-label="Name" aria-describedby="basic-addon-name" required />
                    </div>
                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="basic-addon-name">Email</label>

                        <input type="email" id="basic-addon-name" name='email' class="form-control"
                            value="{{ Auth::guard('fileuser')->user()->email }}" placeholder="Email"
                            aria-label="Name" aria-describedby="basic-addon-name" readonly />
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="basic-addon-name">Phone</label>

                        <input type="text" id="basic-addon-name" name='phone' class="form-control"
                            value="{{ Auth::guard('fileuser')->user()->phone }}" placeholder="Phone"
                            aria-label="Name" aria-describedby="basic-addon-name"/>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="pic">Image Thumbnail</label>
                        <input type="file" name='pic' id="pic" class="form-control " aria-label="pic"
                            aria-describedby="pic" />
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <button type="submit"
                            class="btn btn-primary waves-effect waves-float waves-light">Update</button>
                    </div>
                </div>

            </form>
        </div>
    </div>



@endsection


@section('Script-Area')
    {{-- <script src="{{asset('backend/assets/js/scripts/forms/form-validation.js')}}"></script> --}}
    <script src="{{ asset('backend/assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endsection
