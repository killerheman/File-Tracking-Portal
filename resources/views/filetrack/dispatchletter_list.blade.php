@extends('filetrack.includes.layout')

@section('title', 'Dispatch Letter List')
@section('header-area')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Dispatch Letter List</h4>
            <a href="{{route('filetrack.letter-dispatch-create')}}" class="btn btn-primary float-right">Dispatch New
                Letter</a>
        </div>
        <div class="card-body">
            <table id="user_table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Subject</th>
                        <th>File Number</th>
                        <th>Department / Office</th>
                        <th>Dispatch To</th>
                        <th>File</th>
                        <th>Letter</th>
                        <th>Created</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script-area')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('filetrack.letter-dispatch') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'file_title', name: 'file_title' },
                    { data: 'file_number', name: 'file_number' },
                    { data: 'department', name: 'department' },
                    { data: 'dispatchUsers', name: 'dispatchUsers' },
                    { data: 'file_link', name: 'file_link' },
                    { data: 'letter', name: 'letter' },
                    { data: 'created', name: 'created' }
                ]
            });
        });
    </script>
@endsection