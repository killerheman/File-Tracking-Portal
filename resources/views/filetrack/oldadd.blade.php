@extends('filetrack.includes.layout')

@section('title','Generate File')
@push('head-area')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="{{asset('backend/gtransapi.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/css/core/colors/palette-gradient.cs')}}">
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/css/plugins/forms/validation/form-validation.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('content')

<div class="card">
    <div class="card-header ">
            <h4 class="card-title">VCS File Movement Detail </h4>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
    </div>
    <div class="card-body">

                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal"  method="post" action="{{isset($file)?route('filetrack.file-generate.update',Crypt::encrypt($file->id)):route('filetrack.storeold')}}" enctype="multipart/form-data">
                            @isset($file)
                                @method('PATCH')
                            @endisset
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>File No</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative has-icon-left">
                                                   
                                                    @php $code=isset($file)?$file->file_number:time().rand(0,9); @endphp
                                                    <input type="number" id="fileno" class="form-control" name="fileno" placeholder="Subject" value='{{$code}}' readonly required>
                                                    <div class="form-control-position">
                                                        <i class="fa fa-database"></i>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="">{!! DNS1D::getBarcodeHTML($code, 'UPCA') !!}</div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mb-1">
                                        <label class="form-label" for="filecode"> Old File No</label>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <input type="text" class="form-control" name='filecode' required>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="" style="max-size: 50px">{!! DNS2D::getBarcodeHTML($code, 'QRCODE',2,2) !!}</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-1">
                                                <span>Initiating/Relating Department</span>
                                            </div>
                                            {{-- <div class="col-md-3 mb-1">
                                                <label class="form-label" for="inidepoff">Department/Office</label>
                        
                                                <select name="inidepoff" id="inidepoff" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Department Or Office--'}}</option>
                                                    
                                                    @forelse ( $department as $depoff )
                                                    <option value="{{$depoff->id}}">{{$depoff->name}}</option>
                                                    @empty
                                                    
                                                    @endforelse
                                                </select>
                                            </div> --}}
                                            <div class="col-md-6 mb-1">
                                                <select name="inibranch" id="inibranch" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Branch--'}}</option>
                                                  @isset($branch)
                                                  @foreach ($branch as $br)
                                                      <option value="{{$br->id}}">{{$br->name}}</option>
                                                  @endforeach
                                                  @endisset
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-1">
                                                <span>File Receive From</span>
                                            </div>
                                            {{-- <div class="col-md-3 mb-1">
                                                <label class="form-label" for="senderdepoff">Department/Office</label>
                        
                                                <select name="senderdepoff" id="senderdepoff" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Department Or Office--'}}</option>
                                                    
                                                    @foreach ($department as $depoff)
                                                        <option value="{{$depoff->id}}">{{$depoff->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="col-md-6 mb-1">
                                                <select name="senderbranch" id="senderbranch" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Branch--'}}</option>
                                                  @isset($branch)
                                                  @foreach ($branch as $br)
                                                      <option value="{{$br->id}}">{{$br->name}}</option>
                                                  @endforeach
                                                  @endisset
                                                </select>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Subject</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="subject" value="{{isset($file)?$file->subject:''}}" class="form-control" placeholder="Subject" name='subject' @error('subject') aria-invalid="true" @enderror  required >
                                                    <div class="form-control-position">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                @error('subject') <div class="help-block"><ul role="alert"><li>{{$message}}</li></ul></div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Matter/Summary Of file</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="position-relative has-icon-left">
                                                    <fieldset class="form-label-group mb-0">
                                                        <textarea data-length=500 class="form-control char-textarea" id="description" rows="3" name='description' placeholder="description">
                                                            {{isset($file)?$file->description:''}}
                                                        </textarea>
                                                        <label for="textarea-counter">Matter/Summary Of file</label>
                                                    </fieldset>
                                                    <small class="counter-value float-right"><span class="char-count">0</span> / 500 </small>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>File Receiving Date</span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative has-icon-left">
                                                   
                                                    <input type="date" id="date" class="form-control" name="file_receiving_date" placeholder="File Receiving Date">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-database"></i>
                                                    </div>

                                                </div>
                                            </div>   
                                            <div class="col-2">
                                                <span>Date of approval</span>
                                            </div>
                                           <div class="col-4">
                                            <div class="position-relative has-icon-left">
                                                   
                                                <input type="date" id="date" class="form-control" name="file_approval_date" placeholder="File Receiving Date">
                                                <div class="form-control-position">
                                                    <i class="fa fa-database"></i>
                                                </div>

                                            </div>       
                                        </div>                                 
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-1">
                                                <span>Departure</span>
                                            </div>
                                            {{-- <div class="col-md-3 mb-1">
                                                <label class="form-label" for="inidepoff">Department/Office</label>
                        
                                                <select name="inidepoff" id="inidepoff" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Department Or Office--'}}</option>
                                                    
                                                    @forelse ( $department as $depoff )
                                                    <option value="{{$depoff->id}}">{{$depoff->name}}</option>
                                                    @empty
                                                    
                                                    @endforelse
                                                </select>
                                            </div> --}}
                                            <div class="col-md-6 mb-1">
                                                <select name="departure" id="departure" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Branch--'}}</option>
                                                  @isset($branch)
                                                  @foreach ($branch as $br)
                                                      <option value="{{$br->id}}">{{$br->name}}</option>
                                                  @endforeach
                                                  @endisset
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                               <span>Remark</span>
                                            </div>
                                            <div class="col-md-4">
                                               
                                                <input type="text" name="remark" class="form-control" id="">

                                                </div>
                                                <div class="col-md-2">
                                                    Upload <span class="text-info"> (scan copy of approval)</span>
                                                   
                                                </div> 
                                                <div class="col-md-4">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"  name='file' id="inputGroupFile01">
                                                        <label class="custom-file-label" for="inputGroupFile01">scan copy of approval</label>
                                                    </div>
                                                </div>   
                                            </div>
                                            
                                            
                                                                             
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Status Type</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="position-relative has-icon-left">
                                                    <select data-placeholder="Select a state..." class="select2-icons form-control" id="status" name='status' @error('status') aria-invalid="true" @enderror required>

                                                        <option {{isset($file)?"value=$file->status":"value=''"}} data-icon="fa fa-wordpress" value='' selected hidden>{{isset($file)?$file->filestatus->name:'--Select File Status --'}}</option>
                                                      @foreach ($status as $st)
                                                          <option value="{{$st->id}}">{{strtoupper($st->name)}}</option>
                                                      @endforeach


                                                </select>
                                                    <div class="form-control-position">
                                                        <i class="fa fa-th-list"></i>
                                                    </div>
                                                </div>
                                                @error('status') <div class="help-block"><ul role="alert"><li>{{$message}}</li></ul></div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 row">
                                    <div class="col-md-6 offset-md-2">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                    </div>
                                    <div class="col-md-4">
                                       
                                    </div>
                                </div>

                                {{-- <button type="button" class="btn btn-outline-success mr-1 mb-1" id="type-success">Success</button> --}}

                                    {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML('4445645656', 'UPCA') !!}</div> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    </div>



<div class="card">
    <div class="card-header">
        All Old Files
    </div>
    <div class="card-body">
        <table class="table scroll-horizontal-vertical w-100">
            <thead >
                <tr>
                    <th>Sr No</th>
                    <th>File Code</th>
                    <th>Initiating/Relating Department</th>
                    <th>File Receive From</th>
                    <th>Subject</th>
                    <th>File Receiving Date</th>
                    <th>Date of approval</th>
                    <th>Departure</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                <tr>
                    <td>{{++$loop->index}}</td>
                    <td>{{$file->file_code}}</td>
                    <td>{{$file->initiating->name}}</td>
                    <td>{{$file->sender->name}}</td>
                    <td>{{$file->subject}}</td>
                    <td>{{$file->receiving_date}}</td>
                    <td>{{$file->approval_date??''}}</td>
                    <td>{{$file->departureto->name??''}}</td>
                    <td><a href="{{asset($file->file)}}" target="_blank">view</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>







\
@endsection

@section('script-area')
<script type="text/javascript" src="https://www.google.com/jsapi">
<script src="{{asset('backend/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('backend/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('backend/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>


<script src="{{asset('backend/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('backend/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/app-assets/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/app-assets/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
    // <script src="{{asset('backend/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    
    <script src="{{asset('backend/app-assets/js/scripts/datatables/datatable.js')}}"></script>
<script type="text/javascript">
    google.load("elements", "1", { packages: "transliteration" });
    var control;
    function onLoad() {         
        var options = {
            //Source Language
            sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
            // Destination language to Transliterate
            destinationLanguage: [google.elements.transliteration.LanguageCode.HINDI],
            shortcutKey: 'ctrl+g',
            transliterationEnabled: true
        };                     
        control = new google.elements.transliteration.TransliterationControl(options);  
        control.makeTransliteratable(['description']);   
    }
    google.setOnLoadCallback(onLoad);         
</script>
<script>
        $(document).on('change','#senderdepoff',function(){
            var did=$(this).val();
            var nurl="{{url('/filetracking')}}";
           $.ajax({
            url:nurl+'/get-branch',
            method:'post',
            data:{
                "_token":"{{csrf_token()}}",
                'dep_id':did
            },
            beforeSend:function(){
                $('#senderbranch').html('<option selected hidden>Fetching.........</option>');
            },
            success:function(p){
                   $('#senderbranch').html(p);
            }
           });
        });
        $(document).on('change','#inidepoff',function(){
            var did=$(this).val();
            var nurl="{{url('/filetracking')}}";
           $.ajax({
            url:nurl+'/get-branch',
            method:'post',
            data:{
                "_token":"{{csrf_token()}}",
                'dep_id':did
            },
            beforeSend:function(){
                $('#inibranch').html('<option selected hidden>Fetching.........</option>');
            },
            success:function(p){
                   $('#inibranch').html(p);
            }
           });
        });
    </script>
@endsection
