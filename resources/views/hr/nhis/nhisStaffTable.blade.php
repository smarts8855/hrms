<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Staff Name</th>
            <th scope="col">Grade/Step</th>
            <th scope="col">Designation</th>
            <th scope="col">No. of Children</th>
            <th scope="col">Hospital</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    @php $i = 1; @endphp
    @foreach ($allStaffNhis as $key => $value)
        <tbody>
            <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>{{ $value->surname }} {{ $value->first_name }}</td>
                <td>{{ $value->grade }}/{{ $value->step }}</td>
                <td>{{ $value->designation }}</td>


                <td>
                    <span class="label label-danger">
                        {{ $children[$value->ID] ?? 0 }}
                    </span>
                </td>



                <td>
                    <strong>{{ $value->hospital }}</strong><br>
                    @if (!empty($value->category_name))
                        <span class="label label-success">{{ $value->category_name }}</span>
                        {{-- <small class="text-muted">{{ $value->category_name }}</small> --}}
                    @else
                        <small class="text-danger">N/A</small>
                    @endif
                </td>

                <td>
                    <a href="{{ url('/staff-nhis-child/' . $value->ID) }}" class="btn btn-sm btn-primary"
                        data-backdrop="false" title="Edit this application">
                        <i class="fa fa-user"></i> &nbsp;
                        Add Child
                    </a>
                    <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-success " data-backdrop="false"
                        data-target="#editApplication{{ $key }}" title="Edit this application">
                        <i class="fa fa-hospital-o" aria-hidden="true"></i> &nbsp; Add Hospital
                    </a>
                </td>
            </tr>
        </tbody>
        <!-- Modal -->
        <div class="modal fade text-left d-print-none" id="editApplication{{ $key }}" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel12" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Hospital</h5>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="row"> --}}
                        <form method="post" action="{{ url('/assign-hospital') }}" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="staffID" class="form-control" value="{{ $value->ID }}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="basic-url" class="form-label">Hospital Category</label>
                                    <select class="form-control hospitalCat" id="hospitalCat{{ $key }}"
                                        name="hospitalCat" required>
                                        <option selected disabled>Select Category</option>
                                        @foreach ($hospitalCats as $hospitalCat)
                                            <option value="{{ $hospitalCat->id }}">{{ $hospitalCat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="basic-url" class="form-label">Hospital</label>
                                    <select class="form-control hospitalID" id="hospitalID{{ $key }}"
                                        name="hospitalID" required>
                                        <option selected disabled>Select Hospital</option>
                                    </select>
                                </div>
                            </div>


                            <div class="modal-footer" style="border-top:none;">
                                <button type="button" class="btn btn-danger"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary"> Assign
                                    Hospital</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</table>

@if ($allStaffNhis instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="d-flex justify-content-center">
        {!! $allStaffNhis->links() !!}
    </div>
@endif
