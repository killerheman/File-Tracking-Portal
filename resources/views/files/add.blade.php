@extends('backend.includes.layout')

@push('head-area')
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/css/core/colors/palette-gradient.cs')}}">
<link rel="stylesheet" type="text/css" href="{{asset('backend/app-assets/vendors/css/forms/select/select2.min.css')}}">
@endpush
@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Genarate New File</h4>
    </div>
    <div class="card-body">
        
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>File Title</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="File Title">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-file-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>File Type</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="position-relative has-icon-left">
                                                    <div class="form-group">
                                                        <select data-placeholder="Select a state..." class="select2-icons form-control" id="select2-icons">
                                                          
                                                                <option value="wordpress2" data-icon="fa fa-wordpress" value='' selected hidden>--Select File Type --</option>
                                                                <option value="" data-icon="fa fa-codepen">Official</option>
                                                                <option value="codepen" data-icon="fa fa-codepen">Departmental</option>
                                                          
                                                             
                                                        </select>
                                                    </div>
                                                    <div class="form-control-position">
                                                        <i class="fa fa-book"></i>
                                                    </div>
                                                </div>
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
                                                    <input type="text" id="contact-icon" class="form-control" name="contact-icon" placeholder="Subject">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
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
                                                        <textarea data-length=500 class="form-control char-textarea" id="textarea-counter" rows="3" placeholder="description"></textarea>
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
                                    <div class="form-group col-md-10 offset-md-4">
                                        <fieldset class="checkbox">
                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                <input type="checkbox">
                                                <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Remember me</span>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-10 offset-md-4">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    </div>
      
</div>
@endsection

@push('script-area')
<script src="{{asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('backend/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
    
@endpush