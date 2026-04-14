
    <table class="table table-hover" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Category</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Reminder</th>
                <th scope="col" colspan="2" class="text-center"> Actions</th>
            </tr>
        </thead>
        @php $i = 1; @endphp
        @foreach ($form as $key => $value)
            @php
                // assign variable to the value gotten from the DB to get other values

                //   $endDate = \Carbon\Carbon::parse($value->pop)
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
                    <td>{{ \Carbon\Carbon::parse($value->pop)->isoFormat('D MMMM Y') }}</td>
                    <td>
                        @if (\Carbon\Carbon::now()->isoFormat('MMMM Y') ===
\Carbon\Carbon::parse($value->pop)->subMonth(2)->isoFormat('MMMM Y'))
                            <div class="alert alert-success" role="alert">
                                {{-- <div class="col-lg-2" style=" width:18%; float:right;"><img src="https://upload.wikimedia.org/wikipedia/en/7/71/National_Youth_Service_Corps_logo.jpg" class="img-thumbnail" alt="NYSC LOGO"></div> --}}
                                I am passing out in 2 months!!
                            </div>
                        @endif
                    </td>
                    <td><a href="{{ url('/nysc-edit/' . $value->id) }}" class="btn btn-success"> <i
                                class="fa fa-edit"></a></td>
                    <!-- Button trigger modal -->
                    {{-- <a href="javascript:;" data-toggle="modal" id="editMe" class="btn btn-sm btn-warning"
                            data-backdrop="false" data-target="#editApplication{{ $key }}"
                            title="Edit this application"><i class="fa fa-edit"></i></a>
                        {{-- <button onclick="myFunction()" class="btn btn-danger">Delete</button> --}}

                    {{-- <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-danger"
                            data-backdrop="false" data-target="#deleteApplication{{ $value->id }}"
                            title="delete this application"><i class="fa fa-remove"></i></a> --}}

                    </td>
                    <td>
                        <form action="/nysc-delete/{{ $value->id }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i
                                    class="fa fa-remove"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>

