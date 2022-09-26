@extends('filetrack.includes.layout')

@section('title','Generate File')
@section('header-area')
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/vendors/css/forms/select/select2.min.css')}}">
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
        <h3 class="card-title">All Files</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.No</th><th>File Code</th><th>File Number</th><th>Barcode</th><th>QR</th><th>Subject</th><th>Type</th><Th>Status </Th><th>Mode</th> @can('Show_all_files') <th>Created By</th> @endcan <th>Current User</th><th>Action</th>
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
                        <td>{{$file->current_location->full_name}}</td>
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
                                    @if($file->current_user==Auth::guard('fileuser')->user()->id || Auth::guard('fileuser')->user()->hasPermissionTo('Show_all_files_edit'))
                                    <a class="dropdown-item transfer" href="#" data-index='{{$file->id}}' > <i class="fa fa-share-square-o text-info"></i>Transfer</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




<!-- Transfer Modal -->
<div class="modal fade" id="transfermodal" tabindex="-1" aria-labelledby="transfermodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="transfermodalLabel">Transfer Modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('filetrack.file-transfer')}}" method="post">
        <div class="modal-body">
         @csrf
            <input type="hidden" name="fileid" id='mfileid'>
            <div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                <div class="input-group mb-2">
                  <select name="transferid" id="" class="form-select select2" required>
                    <option value="" selected disabled> --Select Department/Office to transfer-- </option>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->full_name}}</option>
                    @endforeach
                  </select>

                </div>
            </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Status</label>
                    <div class="input-group mb-2">
                      <select name="status" id="" class="form-select select2" required>
                        <option value="" selected disabled> --Select File Status-- </option>
                        @foreach ($status as $st)
                            <option value="{{$st->id}}">{{$st->name}}</option>
                        @endforeach
                      </select>
    
                    </div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fa fa-book"></i></div>
                    </div>
                   <input type="text" class="form-control" name="Remark" placeholder="Remark" required>
                    
                  </div>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fa fa-file-text-o"></i></div>
                    </div>
                  <textarea name="description" id="" class="form-control" placeholder="Description"></textarea>
                    
                  </div>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>
@endsection

@section('script-area')
<script src="{{asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('backend/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script>
    $(document).on('click','.transfer',function(){
        var fileid=$(this).data('index');
       $('#mfileid').val(fileid);
       $('#transfermodal').modal('show');
    });
</script>
@endsection