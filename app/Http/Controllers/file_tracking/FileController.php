<?php

namespace App\Http\Controllers\file_tracking;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentFileReq;
use App\Models\DocumentFile;
use App\Models\FileMode;
use App\Models\FileStatus;
use App\Models\FileType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use League\CommonMark\Node\Block\Document;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types=FileType::all();
        $status=FileStatus::all();
        return view('filetrack.add',compact('types','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::guard('fileuser')->user()->hasPermissionTo('show_all_files')){
            $files=DocumentFile::paginate(10);
            
        }
        else
        {
            $files=DocumentFile::where('created_by',Auth::guard('fileuser')->user()->id)->paginate(10);
        }

        return view('filetrack.showfiles',compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentFileReq $req)
    {
        $res=DocumentFile::create([
            'title'=>$req->title,
            'file_code'=>substr(FileType::find($req->type)->name,0,3).DocumentFile::max('id')+1,
            'file_number'=>$req->fileno,
            'file_type_id'=>$req->type,
            'subject'=>$req->subject,
            'description'=>$req->description,
            'file_mode_id'=>FileMode::where('name','generated')->first()->id,
            'status'=>$req->status,
            'created_by'=>Auth::guard('fileuser')->user()->id,
        ]);
        if($res){
            Session::flash('info','File Generated <br/> <b>File Code - </b>'.$res->file_code);
            
        }
        else
        {
            Session::flash('error','Something went wrong Please try again ');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $file=DocumentFile::find($id);
        $types=FileType::all();
        $status=FileStatus::all();
        return view('filetrack.add',compact('types','status','file'));
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
                'title'=>'required',
                'type'=>'required',
                'subject'=>'required',
                'fileno'=>'required|unique:document_files,file_number,'.Crypt::decrypt($id),
                'status'=>'required'
            
        ]);
        $res=DocumentFile::find(Crypt::decrypt($id))->update([
            'title'=>$req->title,
            'file_type_id'=>$req->type,
            'subject'=>$req->subject,
            'description'=>$req->description,
            'status'=>$req->status,
        ]);
        if($res){
            Session::flash('info','File Updated');
            
        }
        else
        {
            Session::flash('error','Something went wrong Please try again ');
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
}
