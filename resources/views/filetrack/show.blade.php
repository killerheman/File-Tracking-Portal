@extends('filetrack.includes.layout')

@section('title','Generate File')
@section('header-area')
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/vendors/css/forms/select/select2.min.css')}}">
<style>
    #qr div{
        max-height: 50px !important;
        max-width: 50px !important;
        margin-top:-15px;
        margin-left:20px;
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
                        <div class='col-3 mt-2'><b>File Code - </b>{{$file->file_code}}</div>
                        <div class='col-3 mt-2'><b>File No - </b>{{$file->file_number}}</div>
                        <div class='col-3 mt-2' style="display:flex"><b>Bar-Code -  </b> &nbsp;&nbsp;&nbsp;{!! DNS1D::getBarcodeHTML($file->file_number, 'UPCA') !!}</div>
                        <div class='col-3 mt-2' style="display:flex"><b>QR - </b><div id='qr' class="mb-2">&nbsp;&nbsp;&nbsp;{!! DNS2D::getBarcodeHTML($file->file_number, 'QRCODE',2,2) !!}</div></div>
                        <div class='col-6'><b>Subject - </b>{{$file->subject}}</div>
                        <div class='col-3 mt-2'><b>File Type - </b>{{$file->type->name??''}}</div>
                        <div class='col-3 mt-2'><b>File Status - </b>{{$file->filestatus->name??''}}</div>
                        <div class='col-3 mt-2'><b> Mode - </b>{{$file->mode->name}}</div>
                        <div class='col-3 mt-2'><b> Created By  - </b>{{$file->created_by_user->full_name}}</div>
        </div>

    </div>
    <div class="card-footer">
          <!-- Timeline Starts -->
          <section class="basic-timeline">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Basic</h4>
                        </div>
                        <div class="card-body">
                            <ul class="timeline">
                                @foreach ($file->tracking as $ft)
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                            <h6>{{$ft->mode->name}} by/to {{$ft->userto->first_name}}</h6>
                                            <span class="timeline-event-time">{{$ft->created_at->diffForHumans()}}</span>
                                        </div>
                                        <p>{{$ft->description??'There is no any Description available'}}<br/>
                                            <b>Remark : </b>{{$ft->remark}}
                                        </p>
                                        <div class="d-flex flex-row align-items-center">
                                            {{-- <img class="me-1" src="../../../app-assets/images/icons/file-icons/pdf.png" alt="invoice" height="23" />
                                            <span>invoice.pdf</span> --}}
                                        </div>
                                    </div>
                                </li> 
                                @endforeach
                                
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