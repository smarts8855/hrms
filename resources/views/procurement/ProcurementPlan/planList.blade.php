@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Procurement Plans Sheet') }}
@endsection
@section('pageMenu', 'active')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Procurement Plan Sheet</h4>
                </div>

                <div class="panel-body">


                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Project Title</th>
                                    <th>Budget Year</th>
                                    <th>Budget Code</th>
                                    <th>Package Number</th>
                                    <th>Lot Number</th>
                                    <th>View Detail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $n = 1; @endphp
                                @foreach ($display as $list)
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $list->project_title }}</td>
                                        <td>{{ $list->budget_year }}</td>
                                        <td>{{ $list->budget_code }}</td>
                                        <td>{{ $list->package_number }}</td>
                                        <td>{{ $list->lot_number }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('/view/procurement-plan/' . $list->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('/edit/procurement-plan/' . $list->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ url('/export/procurement-plan/' . $list->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-file-export"></i> Export
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div> <!-- end panel -->
        </div> <!-- end col -->
    </div> <!-- end row -->




@endsection

@section('styles')
    <style>
        .remove,
        .delete {
            margin-top: 30px;
            padding-top: 5px !important;
            padding-bottom: 0px !important;

            margin-bottom: 0px;
        }

        .fa-times {
            font-size: 30px;
            cursor: pointer;
        }

        .compulsory {
            color: red;
        }

        table tr th {
            font-size: 16px;
        }

        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('msg'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('msg') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif






    <script>
        $(document).ready(function() {
            $(document).on('click', '.bn', function() {
                //alert(0);
                $('.wraps').last().remove();
                var id = this.id;
                var deleteindex = id[1];

                // Remove <div> with id
                $("#" + deleteindex).remove();

            });
        });
    </script>

    <script>
        $("#biddingAmount").on('keyup', function() {
            var n = parseInt($(this).val().replace(/\D/g, ''), 10);
            if ($(this).val() == "") {
                $(this).val(0);
            } else {
                $(this).val(n.toLocaleString());
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#add').click(function() {
                var total_element = $(".wraps").length;
                var lastid = $(".wraps:last").attr("id");
                //var split_id = lastid.split('_');
                var n = Number(lastid) + 1;
                //alert(nextindex);
                $('#inputWrap').append(
                    `<div class="wraps" id="'+n+'">
        <div class="row">
        <div class="col-md-12">
        <a class="delete bn remove_bank_field_btn pull-right align-right" href="javascript::void()">Remove</a>
        </div>
        <div class="col-md-6">
        <div class="form-group dynFile">
            <label for="">Document</label>
            <input type="file" name="document[]" class="form-control" id=''>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group dynInput">
            <label for="">Document Description</label>
            <input type="text" name="description[]" class="form-control" id='' >
        </div>
        </div>

        </div>
        </div>`
                );
            });
            //end click function

            $('.delete').last().click(function() {
                $('.wraps').last().remove();
            });

        });
    </script>





@endsection
