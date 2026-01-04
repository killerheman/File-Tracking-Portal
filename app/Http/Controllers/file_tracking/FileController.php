<?php

namespace App\Http\Controllers\file_tracking;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentFileReq;
use App\Listeners\NewFileGenerate;
use App\Models\Branch;
use App\Models\Department;
use App\Models\DocumentFile;
use App\Models\FileMode;
use App\Models\FileStatus;
use App\Models\FileTracking;
use App\Models\FileType;
use App\Models\FileUser;
use App\Models\OfficeDepartment;
use App\Models\OldFile;
use Database\Seeders\filemode as SeedersFilemode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use League\CommonMark\Node\Block\Document;
use App\Notifications\NewFile;
class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //     $types=FileType::all();
        $status = FileStatus::all();
        if (Auth::guard('fileuser')->user()->hasAnyRole(['Master File User', 'Admin', 'Super Admin'])) {
            $department = Department::where('active', true)->get();
            return view('filetrack.add', compact('status', 'department'));
        } else if (Auth::guard('fileuser')->user()->hasRole('Mid File User')) {
            $department = Department::where('id', Auth::guard('fileuser')->user()->department_id)->get();
            $branch = Branch::where('active', true)->where('department_id', Auth::guard('fileuser')->user()->department_id)->get();
            return view('filetrack.add', compact('status', 'branch', 'department'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = DocumentFile::where('created_by', Auth::guard('fileuser')->user()->id)->paginate(10);
        $users = FileUser::all()->except(Auth::guard('fileuser')->user()->id);
        $status = FileStatus::all();
        return view('filetrack.showfiles', compact('files', 'users', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentFileReq $req)
    {
        $res = DocumentFile::create([
            'title' => $req->title,
            'file_code' => substr(Branch::find($req->branch)->department->name ?? 'department', 0, 3) . substr(Branch::find($req->branch)->name ?? 'branch', 0, 3) . '-' . DocumentFile::max('id') + 1,
            'file_number' => $req->fileno,
            'file_type_id' => $req->depoff,
            'file_type_main_id' => $req->branch,
            'subject' => $req->subject,
            'description' => $req->description,
            'file_mode_id' => FileMode::where('name', 'generated')->first()->id,
            'status' => $req->status,
            'created_by' => Auth::guard('fileuser')->user()->id,
            'current_user' => Auth::guard('fileuser')->user()->id,
        ]);
        // return $res;
        if ($res) {

            FileTracking::create([
                'file_id' => $res->id,
                'sender_id' => Auth::guard('fileuser')->user()->id,
                'mode_id' => FileMode::where('name', 'generated')->first()->id,
                'status' => $req->status,
                'remark' => 'File Generated'
            ]);
            Session::flash('info', 'File Generated <br/> <b>File Code - </b>' . $res->file_code);
            Auth::user()->notify(new NewFile($res));


        } else {
            Session::flash('error', 'Something went wrong Please try again ');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = DocumentFile::find(crypt::decrypt($id));
        return view('filetrack.show', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $file = DocumentFile::find($id);
        $types = FileType::all();
        $status = FileStatus::all();
        return view('filetrack.add', compact('types', 'status', 'file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $req->validate([
            'title' => 'required',
            'type' => 'required',
            'subject' => 'required',
            'fileno' => 'required|unique:document_files,file_number,' . Crypt::decrypt($id),
            'status' => 'required'

        ]);
        $res = DocumentFile::find(Crypt::decrypt($id))->update([
            'title' => $req->title,
            'file_type_id' => $req->type,
            'subject' => $req->subject,
            'description' => $req->description,
            'status' => $req->status,
        ]);
        if ($res) {
            Session::flash('info', 'File Updated');

        } else {
            Session::flash('error', 'Something went wrong Please try again ');
        }
        return redirect()->route('filetrack.file-generate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generatedFiles()
    {

        $files = DocumentFile::where('created_by', Auth::guard('fileuser')->user()->id)->where('file_mode_id', FileMode::where('name', 'generated')->first()->id)->paginate(10);


        return view('filetrack.generated-file', compact('files'));
    }


    public function transfer_file(Request $req)
    {
        $res = DocumentFile::find($req->fileid)->update([
            'file_mode_id' => FileMode::where('name', 'transfering')->first()->id,
            'status' => $req->status,
            'transfer_by' => Auth::guard('fileuser')->user()->id,
            'current_user' => $req->transferid,

        ]);
        if ($res) {
            $res2 = FileTracking::create([
                'file_id' => $req->fileid,
                'reciever_id' => $req->transferid,
                'mode_id' => FileMode::where('name', 'transfering')->first()->id,
                'status' => $req->status,
                'remark' => $req->Remark,
                'description' => $req->description,
            ]);

            if ($res2) {
                Session::flash('info', 'File is transfer');
            } else {
                Session::flash('error', 'File can\'t transfer right now');
            }
            return redirect()->back();

        }
    }


    public function arriving_files()
    {
        $files = DocumentFile::where('file_mode_id', FileMode::where('name', 'transfering')->first()->id)->where('current_user', Auth::guard('fileuser')->user()->id)->get();
        return view('filetrack.arriving-files', compact('files'));
    }

    public function pending_files()
    {
        $files = DocumentFile::where('file_mode_id', FileMode::where('name', 'recieved')->first()->id)->where('current_user', Auth::guard('fileuser')->user()->id)->get();
        return view('filetrack.pending-files', compact('files'));
    }

    public function accept_reject_file(Request $req)
    {
        $file = DocumentFile::find($req->fileid)->update([
            'file_mode_id' => FileMode::where('name', $req->mode)->first()->id,
        ]);
        if ($file) {
            $ft = FileTracking::create([
                'file_id' => $req->fileid,
                'reciever_id' => Auth::guard('fileuser')->user()->id,
                'mode_id' => FileMode::where('name', $req->mode)->first()->id,
                'status' => $req->name,
                'remark' => $req->Remark,
            ]);
            if (isset($ft)) {
                Session::flash('success', 'File ' . $req->mode . ' By ' . $req->name);
            } else {
                Session::flash('error', 'Tracking not Possible for this stage');
            }
        }
        return redirect()->back();

    }

    public function file_search()
    {
        return view('filetrack.search');
    }

    public function showAllFiles()
    {

        if (Auth::guard('fileuser')->user()->hasAnyRole('Master File User', 'Admin', 'Super Admin')) {
            $files = DocumentFile::paginate(20);
        } else if (Auth::guard('fileuser')->user()->hasRole('Mid File User')) {
            $files = DocumentFile::where('department_id', Auth::guard('fileuser')->user()->department_id)->paginate(20);
        } else {

        }
        return view('filetrack.allfiles', compact('files'));
    }

    public function notice_read($id)
    {
        $notification = Auth::guard('fileuser')->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

    public function oldfile()
    {
        $status = FileStatus::all();
        if (Auth::guard('fileuser')->user()->hasAnyRole(['Master File User', 'Admin', 'Super Admin'])) {
            $department = Department::where('active', true)->get();
            $branch = Branch::where('active', true)->get();
            $files = OldFile::latest()->get();
            return view('filetrack.oldadd', compact('status', 'department', 'branch', 'files'));
        } else if (Auth::guard('fileuser')->user()->hasRole('Mid File User')) {
            $department = Department::where('id', Auth::guard('fileuser')->user()->department_id)->get();
            $branch = Branch::where('active', true)->where('department_id', Auth::guard('fileuser')->user()->department_id)->get();
            $files = OldFile::latest()->get();
            return view('filetrack.oldadd', compact('status', 'branch', 'department', 'files'));
        }

    }

    public function storeold(Request $req)
    {
        $req->validate([
            'fileno' => 'required',
            'filecode' => 'required',
            // 'inidepoff'=>'required',
            'inibranch' => 'required',
            // 'senderdepoff'=>'required',
            'departure' => 'required',
            'senderbranch' => 'required',
            'subject' => 'required',
            'description' => 'nullable',
            'file_receiving_date' => 'required|date',
            'file_approval_date' => 'required|date',
            'remark' => 'nullable',
            'file' => 'nullable',
            'status' => 'nullable'
        ]);
        $file = '';
        if ($req->hasFile('file')) {
            $file = 'oldfile-' . $req->fileno . '.' . $req->file->extension();
            $req->file->move(public_path('upload/oldfile'), $file);
        }
        $res = OldFile::create([
            'file_no' => $req->fileno,
            'file_code' => $req->filecode,
            'ini_department' => $req->inidepoff,
            'ini_branch' => $req->inibranch,
            'sender_department' => $req->senderdepoff,
            'sender_branch' => $req->senderbranch,
            'subject' => $req->subject,
            'matter' => $req->description,
            'receiving_date' => $req->file_receiving_date,
            'approval_date' => $req->file_approval_date,
            'departure' => $req->departure ?? '',
            'file' => 'upload/oldfile/' . $file,
            'remark' => $req->remark,
            'status' => $req->status,
            'created_by' => Auth::guard('fileuser')->user()->id,
        ]);
        // return $res;
        if ($res) {
            Session::flash('info', 'File Generated <br/> <b>File Code - </b>' . $res->file_code);
            Auth::user()->notify(new NewFile($res));


        } else {
            Session::flash('error', 'Something went wrong Please try again ');
        }
        return redirect()->back();
    }

    public function trackingFile($id)
    {
        $file = DocumentFile::find(crypt::decrypt($id));
        // dd($file);
        return view('filetrack.track_file', compact('file'));
    }

}
