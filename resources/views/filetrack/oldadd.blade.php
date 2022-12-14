@extends('filetrack.includes.layout')

@section('title','Generate File')
@push('head-area')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="{{asset('backend/gtransapi.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/css/core/colors/palette-gradient.cs')}}">
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/css/plugins/forms/validation/form-validation.css')}}">
@endpush
@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Add Old File</h4>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
    </div>
    <div class="card-body">

                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal"  method="post" action="{{isset($file)?route('filetrack.file-generate.update',Crypt::encrypt($file->id)):route('filetrack.storeold')}}">
                            @isset($file)
                                @method('PATCH')
                            @endisset
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>File Title</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="title" class="form-control" name="title" placeholder="File Title" value="{{$file->title??''}}" @error('title') aria-invalid="true" @enderror required>
                                                    <div class="form-control-position">
                                                        <i class="fa fa-file-o"></i>
                                                    </div>
                                                    @error('title') <div class="help-block"><ul role="alert"><li>{{$message}}</li></ul></div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>File Type</span>
                                            </div>
                                            <div class="col-md-3 mb-1">
                                                <label class="form-label" for="depoff">Department/Office</label>
                        
                                                <select name="depoff" id="depoff" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Department Or Office--'}}</option>
                                                    
                                                    @foreach ($department as $depoff)
                                                        <option value="{{$depoff->id}}">{{$depoff->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-1">
                                                <label class="form-label" for="branch"> Branch</label>
                        
                                                <select name="branch" id="branch" class="select2 form-control">
                                                    <option value="{{isset($editemployee)?$editemployee->off_dep_id:''}}">{{isset($editemployee)?$editemployee->OfficeDep->name:'--Select Branch--'}}</option>
                                                  @isset($branch)
                                                  @foreach ($branch as $br)
                                                      <option value="{{$br->id}}">{{$br->name}}</option>
                                                  @endforeach
                                                  @endisset
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-1">
                                                <label class="form-label" for="filecode"> File Code</label>
                        
                                                <input type="text" class="form-control" name='filecode' required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>subject</span>
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
                                                <span>Description</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="position-relative has-icon-left">
                                                    <fieldset class="form-label-group mb-0">
                                                        <textarea data-length=500 class="form-control char-textarea" id="description" rows="3" name='description' placeholder="description">
                                                            {{isset($file)?$file->description:''}}
                                                        </textarea>
                                                        <label for="textarea-counter">Description</label>
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
                                        <div class="mt-1">{!! DNS2D::getBarcodeHTML($code, 'QRCODE') !!}</div>
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

</div>
@endsection

@section('script-area')
<script type="text/javascript" src="https://www.google.com/jsapi">
<script src="{{asset('backend/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('backend/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('backend/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
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
        $(document).on('change','#depoff',function(){
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
                $('#branch').html('<option selected hidden>Fetching.........</option>');
            },
            success:function(p){
                   $('#branch').html(p);
            }
           });
        });
    </script>
@endsection
