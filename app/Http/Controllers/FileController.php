<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentFileReq;
use App\Models\FileStatus;
use App\Models\FileType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FileController extends Controller
{
    public function index()
    {
        $types=FileType::all();
        $status=FileStatus::all();
        return view('files.add',compact('types','status'));
    }

    public function store(DocumentFileReq $req)
    {
        return $req;
    }
}
