@extends('filetrack.includes.layout')

@section('title','Generate File')
@section('header-area')
<style>
    #qr div{
        max-height: 50px !important;
        max-width: 50px !important;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Generated Files</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.No</th><th>File Code</th><th>File Number</th><th>Barcode</th><th>QR</th><th>Subject</th><th>Type</th><Th>Status </Th><th>Mode</th> @can('show_all_files') <th>Created By</th> @endcan <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$file->file_code}}</td>
                        <td>{{$file->file_number}}</td>
                        <td>{!! DNS1D::getBarcodeHTML($file->file_number, 'UPCA') !!}</td>
                        <td><div id='qr'>{!! DNS2D::getBarcodeHTML($file->file_number, 'QRCODE',2,2) !!}</div></td>
                        <td>{{$file->subject}}</td>
                        <td>{{$file->type->name??''}}</td>
                        <td>{{$file->filestatus->name??''}}</td>
                        <td>{{$file->mode->name}}</td>
                        @can('show_all_files') <td>{{$file->created_by_user->full_name}}</td> @endcan
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-settings"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if($file->mode->name=='generated')
                                    <a class="dropdown-item" href="{{route('filetrack.file-generate.edit',Crypt::encrypt($file->id))}}"> <i class="fa fa-pencil-square-o text-warning"></i> Edit</a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('filetrack.file-generate.show',Crypt::encrypt($file->id))}}"> <i class="fa fa-eye text-primary"></i> View</a>
                                    @if($file->mode->name=='generated')
                                    <a class="dropdown-item" href="#"> <i class="fa fa-trash text-danger"></i> Delete</a>
                                    @endif
                                    <a class="dropdown-item transfer" href="javascript:void(0)" data-index="{{$file->id}}"> <i class="fa fa-share text-info"></i> Transfer</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection