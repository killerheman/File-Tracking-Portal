@extends('filetrack.includes.layout')

@section('title','Generate File')
@section('header-area')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('filetrack.store-receive-file')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="title" class="form-label">File Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="file_title" value="{{old('file_title')}}">
                        @error('file_title') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="department" class="form-label">Department/Office <span class="text-danger">*</span></label>
                        <select name="department_id" id="department" class="form-control">
                            <option value="">--Select Department--</option>
                            @foreach ($department as $dep)
                                <option value="{{$dep->id}}" @selected(old('department_id')==$dep->id)>{{$dep->name}}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="file" class="form-label">File <small>(pdf only)</small></label>
                        <input type="file" class="form-control-file" id="file" name="file" >
                        @error('file') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="comment" id="comment" class="form-control">{{old('comment')}}</textarea>
                        @error('comment') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="form-group">
                        <label for="dispatch_to">Incomming From <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="dispatch_to" id="dispatch_to" value="{{old('dispatch_to')}}" required>
                        @error('dispatch_to') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="user_table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Title</th>
                    <th>File Number</th>
                    <th>Department / Office</th>
                    <th>Dispatch To</th>
                    <th>Comment</th>
                    <th>File</th>
                    <th>Created</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('script-area')
<script src="{{asset('backend/app-assets/js/scripts/components/components-dropdowns.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
    $('#user_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('filetrack.letter-receive') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'file_title', name: 'file_title'},
            {data: 'file_number', name: 'file_number'},
            {data: 'department', name: 'department'},
            {data: 'dispatch_to', name: 'dispatch_to'},
            {data: 'comment', name: 'comment'},
            {data: 'file_link', name: 'file_link'},
            {data: 'created', name: 'created'}
        ]
    });
});
</script>
@endsection