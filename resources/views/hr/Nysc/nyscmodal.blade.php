<form method="post" action="{{ url('nysc-edit/' . $value->id) }}" class="form-horizontal">
    @csrf
    <input type="hidden" name="recordID" value="{{ $value->id }}" />
    <!-- Modal -->
    <div class="modal fade text-left d-print-none" id="editApplication{{ $key }}"
        role="dialog" aria-labelledby="myModalLabel12" tableindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Corper/Intern Information
                    </h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- <input type="hidden" name="recordID" value="{{$value->Id}}" /> --}}
                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">First Name</label>
                            <input type="hidden" name="recordID" class="form-control"
                                value="{{ $value->id }}" />
                            <input type="text" name="firstname" class="form-control"
                                value="{{ $value->firstname }}" required />
                        </div>
                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control"
                                value="{{ $value->lastname }}" required />
                        </div>
                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control"
                                value="{{ $value->email }}" required />
                        </div>
                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ $value->phone }}" required />
                        </div>
                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">Course</label>
                            <input type="text" name="course" class="form-control"
                                value="{{ $value->course }}" required />
                        </div>


                        <div class="col-md-6">
                            <label for="category">Category</label>
                            <select id="newcategory" name="category" class="form-control">

                                @if (isset($category) && $category)
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat }}"
                                            {{ $cat == old('category') ? 'selected' : '' }}>
                                            @if ($cat == 'IT')
                                                Internship
                                            @else
                                                Nysc
                                            @endif
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">State Code</label>
                            <input type="text" id="newstate" name="statecode" class="form-control"
                                value="{{ $value->statecode }}" required />
                        </div>



                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">
                                Start Date</label>
                            <input type="date" class="form-control" id="startdate"
                                name="startdate" aria-label="Server" placeholder="set POP date"
                                class="form-control" value="{{ $value->startdate }}"
                                required />

                        </div>

                        <div class="col-md-6" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">
                                End Date</label>
                            <input type="date" class="form-control" id="pop" name="pop"
                                aria-label="Server" placeholder="set POP date"
                                class="form-control" value="{{ $value->pop }}" required />

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">Update changes</button>
                    </div>
                </div>
            </div>
        </div>
</form>
