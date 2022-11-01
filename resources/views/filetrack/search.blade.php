@extends('filetrack.includes.layout')

@section('title','Generate File')
@section('header-area')
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/vendors/css/forms/select/select2.min.css')}}">

@endsection
@section('content')

<div class="card">
    <div class="card-header">
        Search File
    </div>
    <div class="card-body">
        <div class="form-group col-6">
            <label for="" class="form-label">Enter File Number OR Code</label>
            <input type="text" class="form-control" name='filecode'>
        </div>
    </div>
</div>
@endsection

@section('script-area')

<script src="{{asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('backend/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>


<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>

@endsection