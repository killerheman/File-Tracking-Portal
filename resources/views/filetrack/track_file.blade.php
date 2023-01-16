@extends('filetrack.includes.layout')

@section('title', 'Generate File')
@section('header-area')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <style>
        #qr div {
            max-height: 50px !important;
            max-width: 50px !important;
            margin-top: -15px;
            margin-left: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Files Detail </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class='col-3 mt-2'><b>File Code - </b>{{ $file->file_code }}</div>
                <div class='col-3 mt-2'><b>File No - </b>{{ $file->file_number }}</div>
                <div class='col-3 mt-2' style="display:flex"><b>Bar-Code :</b> &nbsp;&nbsp;&nbsp;{!! DNS1D::getBarcodeHTML($file->file_number, 'UPCA') !!}
                </div>
                <div class='col-3 mt-2' style="display:flex"><b>QR :</b>
                    <div id='qr' class="mb-2">&nbsp;&nbsp;&nbsp;{!! DNS2D::getBarcodeHTML($file->file_number, 'QRCODE', 2, 2) !!}</div>
                </div>
                <div class='col-6'><b>Subject - </b>{{ $file->subject }}</div>
                <div class='col-3 mt-2'><b>File Type - </b>{{ $file->type->name ?? '' }}</div>
                <div class='col-3 mt-2'><b>File Status - </b>{{ $file->filestatus->name ?? '' }}</div>
                <div class='col-3 mt-2'><b> Mode - </b>{{ $file->mode->name }}</div>
                <div class='col-3 mt-2'><b> Created By - </b>{{ $file->created_by_user->full_name }}</div>
            </div>

        </div>
        <div class="card-footer">
            <!-- Timeline Starts -->
            <section class="basic-timeline">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">File Tracking View</h4>
                            </div>
                            <div class="card-body">
                                <ul class="timeline">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-primary text-light">
                                            <tr class="text-light">
                                                <th>Sr.No</th>
                                                <th>Date</th>
                                                <th>Tracking No.</th>
                                                <th>Sender name & Address</th>
                                                <th>Remark</th>
                                                <th>Current User</th>
                                                <th>File Mode</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($file->tracking as $ft)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ Carbon\Carbon::parse($ft->created_at)->format('d-M-Y') }}</td>
                                                    <td>{{ $ft->id.'/'.Carbon\Carbon::parse($ft->created_at)->format('y') }}</td>
                                                    <td>{{$ft->transfer_by->full_name??''}} / {{$ft->transfer_by->OfficeDep->name??''}}</td>
                                                    <td>{{$ft->remark}}</td>
                                                    <td>{{$ft->userto->full_name}}</td>
                                                    <td>{{$ft->mode->name}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>


                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- Timeline Ends -->

        </div>
    </div>





@endsection
