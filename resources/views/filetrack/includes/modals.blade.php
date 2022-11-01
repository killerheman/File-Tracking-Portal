<!-- Transfer Modal -->
<div class="modal fade" id="transfermodal" tabindex="-1" aria-labelledby="transfermodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="transfermodalLabel">Transfer Modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('filetrack.file-transfer')}}" method="post">
        <div class="modal-body">
         @csrf
            <input type="hidden" name="fileid" id='mfileid'>
            <div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                <div class="input-group mb-2">
                  <select name="transferid" id="" class="form-select select2" required>
                   
                    <option value="" selected disabled> --Select Department/Office to transfer-- </option>
                    @php $users = App\Models\FileUser::get()->except(Auth::guard('fileuser')->user()->id); @endphp
                    @isset($users)
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->full_name}}</option>
                    @endforeach
                    @endisset
                  </select>

                </div>
            </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Status</label>
                    <div class="input-group mb-2">
                      <select name="status" id="" class="form-select select2" required>
                        <option value="" selected disabled> --Select File Status-- </option>
                        @php $status=App\Models\FileStatus::get();  @endphp
                        @isset($status)
                        @foreach ($status as $st)
                            <option value="{{$st->id}}">{{$st->name}}</option>
                        @endforeach
                        @endisset
                      </select>
    
                    </div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fa fa-book"></i></div>
                    </div>
                   <input type="text" class="form-control" name="Remark" placeholder="Remark" required>
                    
                  </div>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fa fa-file-text-o"></i></div>
                    </div>
                  <textarea name="description" id="" class="form-control" placeholder="Description"></textarea>
                    
                  </div>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
</div>

{{-- Accept Modal --}}
<div class="modal fade" id="acceptmodal" tabindex="-1" aria-labelledby="acceptmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="acceptmodalLabel">Accept</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('filetrack.file-accept')}}" method="post">
      <div class="modal-body">
       @csrf
          <input type="hidden" name="fileid" id='acmfileid'>
          <input type="hidden" name="mode" id='acmmode'>
          
              
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
               <input type="text" id='name' class="form-control" name='name' placeholder="Your Name" required>

              </div>
         
             
              <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-book"></i></div>
                  </div>
                 <input type="text" class="form-control" name="Remark" placeholder="Remark" required>
                  
              </div>
              
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Accept File</button>
      </div>
    </form>
    </div>
  </div>
</div>

