<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Code</th>
            <th scope="col">Address</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>

            <th scope="col" colspan="2" class="text-center"> Actions</th>
        </tr>
    </thead>
    @php $i = 1; @endphp
    
    @foreach ($form as $key => $value)
        <tbody>
            <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>{{ $value->name }} </td>
                <td>
                    <span class="label label-danger">{{ $value->category_name }}</span>
                </td>

                <td>{{ $value->code }}</td>
                <td>
                    {{ $value->address }}
                </td>
                <td> {{ $value->email }}</td>
                <td> {{ $value->phone }}</td>

                <td>
                    <a href="{{ url('/hospital-edit/' . $value->id) }}" class="btn btn-success btn-sm">
                        <i class="fa fa-pencil"> </i> &nbsp; Edit
                    </a>
                </td>

                <td>
                    <button type="button" class="btn btn-danger delBtn btn-sm" hospitalId="{{ $value->id }}"
                        hospitalName="{{ $value->name }}" data-toggle="modal" data-target="#delModal"><i
                            class="fa fa-trash"></i> &nbsp; Delete
                    </button>
                </td>
            </tr>
        </tbody>
    @endforeach
</table>

<!-- Modal -->
<div class="modal fade" id="delModal" role="dialog" aria-labelledby="delModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Delete Warning!!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="/hospital-delete" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body">
                    Are you sure you want to delete <strong><span id="hsptl"></span></strong>
                    <input type="hidden" name="hsptlId" id="hsptlId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".delBtn").click(function() {

        var hospitalName = $(this).attr('hospitalName');
        var hospitalId = $(this).attr('hospitalId');

        $("#hsptl").html(hospitalName);
        $("#hsptlId").val(hospitalId);
    });
</script>
