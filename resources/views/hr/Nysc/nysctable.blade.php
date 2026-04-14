<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NAME</th>
            <th scope="col">PHONE</th>
            <th scope="col">CATEGORY</th>
            <th scope="col">START DATE</th>
            <th scope="col">END DATE</th>
            <th scope="col">REMINDER</th>
            <th scope="col" colspan="2" class="text-center"> ACTION</th>
        </tr>
    </thead>
    @php $i = 1; @endphp
    @foreach ($form as $key => $value)
        @php
            //assign variable to the value gotten from the DB to get other values

            //   $endDate = \Carbon\Carbon::parse($value->startdate)
            //   ->addMonths(11)
            //     ->isoFormat('MMMM Y');
        @endphp

        <tbody>
            <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>{{ $value->firstname }} {{ $value->lastname }}</td>
                <td>{{ $value->phone }}</td>
                <td>
                    @if ($value->category == 'IT')
                        Internship
                    @else
                        {{ $value->category }}
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($value->startdate)->isoFormat('D MMMM Y') }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($value->pop)->isoFormat('D MMMM Y') }}
                </td>
                <td>
                    @if ($value->category == 'Nysc')
                        @if (\Carbon\Carbon::now()->isoFormat('MMMM Y') ===
                            \Carbon\Carbon::parse($value->pop)->subMonth(2)->isoFormat('MMMM Y'))
                            <div class="badge badge-success" role="alert">
                                {{-- <div class="col-lg-2" style=" width:18%; float:right;"><img src="https://upload.wikimedia.org/wikipedia/en/7/71/National_Youth_Service_Corps_logo.jpg" class="img-thumbnail" alt="NYSC LOGO"></div> --}}
                                I am passing out in 2 months!!
                            </div>
                        @endif
                    @endif
                </td>
                <td>
                    <a href="{{ url('/nysc-edit/' . $value->id) }}" class="btn btn-success"> <i
                            class="fa fa-edit"></i></a>

                    <!-- Button trigger modal -->
                    {{-- <a href="javascript:;" data-toggle="modal" id="editMe" class="btn btn-sm btn-warning"
                            data-backdrop="false" data-target="#editApplication{{ $key }}"
                            title="Edit this application"><i class="fa fa-edit"></i></a>
                        {{-- <button onclick="myFunction()" class="btn btn-danger">Delete</button> --}}
                        {{-- <a href="#"
                        data-id={{$value->id}}
                        class="btn btn-danger delete"
                        data-toggle="modal"
                        data-target="#deleteModal">
                        <i class=" fa fa-remove"></i>
                    </a> --}}

                    <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-danger" data-backdrop="false"
                        data-target="#deleteApplication{{ $value->id }}" title="delete this application"><i
                            class="fa fa-remove"></i></a>

                </td>
                <td>
                    {{-- <form action="/nysc-delete/{{ $value->id }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i
                                    class="fa fa-remove"></i></button>
                        </form> --}}
                </td>
            </tr>
        </tbody>


        {{-- delete modal --}}
        <div class="modal fade text-left d-print-none" id="deleteApplication{{ $value->id }}" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel123" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Remove Corper</h5>

                    </div>
                    <div class="modal-body">
                        <P>Are you sure you want to delete {{$value->firstname}} {{$value->lastname}} record?</P>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        {{-- <a href="{{ url('nysc-delete/' . $value->id) }}" type="submit" class="btn btn-danger ">Yes,
                            delete!!</a> --}}
                        <button type="submit" form="removeCandidate" class="btn btn-sm btn-danger">DELETE!!</button>
                        <form action="/nysc-delete/{{ $value->id }}" id="removeCandidate" method="POST">
                            @csrf @method('DELETE')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</table>
