@extends('filetrack.includes.layout')

@section('title', 'Generate File')
@section('header-area')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{asset('backend/app-assets/vendors/css/forms/select/select2.min.css')}}">
    <style>
        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            min-height: 400px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Dispatch New Letter</h4>
            <a href="{{route('filetrack.letter-dispatch')}}" class="btn btn-primary float-right">Back to List</a>
        </div>
        <div class="card-body">
            <form action="{{route('filetrack.store-dispatch-file')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="title" class="form-label">File Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="file_title"
                                value="{{old('file_title')}}">
                            @error('file_title') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="department" class="form-label">Department/Office <span
                                    class="text-danger">*</span></label>
                            <select name="department_id" id="department" class="form-control">
                                <option value="">--Select Department--</option>
                                @foreach ($department as $dep)
                                    <option value="{{$dep->id}}" @selected(old('department_id') == $dep->id)>{{$dep->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="file" class="form-label">File <small>(pdf only)</small></label>
                            <input type="file" class="form-control-file" id="file" name="file">
                            @error('file') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="dispatch_to">Dispatch to </label>
                            <select class="select2 form-select" id="dispatch_to" name="dispatch_to[]" multiple>
                                @forelse($dispatch_users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                                @empty
                                    <option value="">-- No data available --</option>
                                @endforelse
                            </select>
                            @error('dispatch_to') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="comment">Your Letter</label>
                            <textarea name="comment" id="comment" class="form-control"
                                style="height: 400px !important">{!!old('comment')!!}</textarea>
                            @error('comment') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="copy_forward_to">Copy forwarded for Information & needful to:</label>
                            <textarea name="copy_forward_to" id="copy_forward_to"
                                class="form-control">{!!old('copy_forward_to')!!}</textarea>
                            @error('copy_forward_to') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>


                    <div class="col-4">
                        <button class="btn btn-primary " type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script-area')
    <script src="{{asset('backend/app-assets/js/scripts/components/components-dropdowns.js')}}"></script>
    <script src="{{asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('backend/app-assets/js/scripts/forms/select/form-select2.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#comment'), {
                placeholder: "Type your Letter here ......"
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#copy_forward_to'), {
                placeholder: "Type Copy forwarded content here ......"
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection