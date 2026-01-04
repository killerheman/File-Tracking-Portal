<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DispatchTo;
use App\Models\Letter;
use App\Models\LetterDispatchUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
class LetterController extends Controller
{
    //
    public function letter_dispatch_list(Request $req)
    {
        if ($req->ajax()) {
            $data = Letter::query()->with('department', 'dispatchUsers')->where('type', Letter::$dispatch)->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    return $row->department->name;
                })
                ->addColumn('dispatchUsers', function ($row) {
                    $html = $row->dispatchUsers->pluck('name')->join(',');
                    return $html;
                })
                ->addColumn('file_link', function ($row) {
                    return $row->file ? '<a href="' . $row->file_url . '" target="_blank">View File</a>' : 'Not Uploaded';
                })
                ->addColumn('letter', function ($row) {
                    return '<a href="' . route('filetrack.letter-view', $row->id) . '" target="_blank">open</a>';
                })
                ->addColumn('created', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->rawColumns(['department', 'dispatchUsers', 'file_link', 'created', 'letter'])
                ->make(true);
        }
        return view('filetrack.dispatchletter_list');
    }

    public function letter_dispatch_create()
    {
        $department = Department::get();
        $dispatch_users = LetterDispatchUser::latest()->get();
        return view('filetrack.dispatchletter', compact('department', 'dispatch_users'));
    }
    public function store_letter_dispatch(Request $req)
    {
        $data = $req->validate([
            'file_title' => 'required',
            'department_id' => 'required|exists:departments,id',
            'comment' => 'required',
            'file' => 'nullable|file|mimes:pdf|max:5120',
            'dispatch_to' => 'required|array',
            'dispatch_to.*' => 'required|exists:letter_dispatch_users,id',
            'copy_forward_to' => 'nullable'
        ]);
        $data['created_by'] = Auth::guard('fileuser')->id();
        $dispatch_to = $req->dispatch_to;
        $dep = Department::find($req->department_id)->name ?? 'A';
        $data['number_start'] = (Letter::where('type', Letter::$dispatch)->latest()->first()->number_end ?? 0) + 1;
        if (count($req->dispatch_to) > 1) {
            $data['number_end'] = ($data['number_start'] + count($req->dispatch_to)) - 1;
            // dd($data['number_start'],$data['number_end']);
            $series = $data['number_start'] . '-' . $data['number_end'];
        } else {
            $series = $data['number_start'];
            $data['number_end'] = $data['number_start'];
        }
        $data['file_number'] = 'LNMU/' . $dep . '/' . $series . '/' . carbon::now()->year;
        $data['type'] = Letter::$dispatch;
        if ($req->hasFile('file')) {
            $data['file'] = $req->file->store('dispatch_letter', 'public');
            ;
        }
        $data['dispatch_to'] = NULL;
        $res = Letter::create($data);
        if ($res) {
            $res->dispatch($dispatch_to);
            return redirect()->route('filetrack.letter-dispatch')->with('success', 'File dispatched File No-' . $res->file_number);
        }
        return redirect()->back()->with('warning', 'Something went wrong');

    }

    public function letter_receive(Request $req)
    {
        if ($req->ajax()) {
            $data = Letter::query()->with('department')->where('type', Letter::$receive)->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    return $row->department->name;
                })
                ->addColumn('dispatch_to', function ($row) {
                    $html = implode(',', json_decode($row->dispatch_to));
                    return $html;
                })
                ->addColumn('file_link', function ($row) {
                    $lnk = $row->file ? asset('storage/' . $row->file) : '#';
                    return $row->file ? '<a href="' . $lnk . '" target="_blank">View File</a>' : 'Not Uploaded';
                })
                ->addColumn('created', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->rawColumns(['department', 'dispatch_to', 'file_link', 'created'])
                ->make(true);
        }
        $department = Department::get();
        return view('filetrack.letterreceive', compact('department'));
    }
    public function store_letter_receive(Request $req)
    {
        $data = $req->validate([
            'file_title' => 'required',
            'department_id' => 'required|exists:departments,id',
            'comment' => 'nullable',
            'file' => 'nullable|file|mimes:pdf|max:5120',
            'dispatch_to' => 'required',
        ]);
        $data['created_by'] = Auth::guard('fileuser')->id();
        $data['dispatch_to'] = json_encode(explode(',', $req->dispatch_to));
        $dep = Department::find($req->department_id)->name ?? 'A';
        $data['number_start'] = (Letter::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('type', Letter::$receive)->latest()->first()->number_end ?? 0) + 1;
        $dispatch_count = count(explode(',', $req->dispatch_to));
        if ($dispatch_count > 1) {
            $series = $data['number_start'] . '-' . $data['number_start'] + $dispatch_count - 1;
            $data['number_end'] = ($data['number_start'] + $dispatch_count) - 1;
        } else {
            $series = $data['number_start'];
            $data['number_end'] = $data['number_start'];
        }
        $data['file_number'] = 'LNMU-R/' . $dep . '/' . $series . '/' . carbon::now()->year;
        $data['type'] = Letter::$receive;
        if ($req->hasFile('file')) {
            $data['file'] = $req->file->store('receive_letter', 'public');
            ;
        }
        $res = Letter::create($data);
        if ($res) {
            return redirect()->back()->with('success', 'File received File No-' . $res->file_number);
        }
        return redirect()->back()->with('warning', 'Something went wrong');

    }

    public function add_letter_dispatch_user(Request $req)
    {
        $data = $req->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:letter_dispatch_users,email'
        ]);
        if ($res = LetterDispatchUser::create($data)) {
            $html = '<option value="' . $res->id . '">' . $res->name . ' (' . $res->email . ')' . '</option>';
            return response()->json(['data' => $html], 200);
        } else {
            return response()->json(['data' => NULL], 500);
        }
    }

    public function letter_view(Letter $id)
    {
        $letter = $id->toArray();
        $pdf = Pdf::loadView('filetrack.letter_viewpdf', $letter);
        return $pdf->stream('letter.pdf');
    }
}
