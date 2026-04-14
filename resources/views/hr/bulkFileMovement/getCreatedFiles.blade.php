@extends('layouts.layout')

@section('pageTitle')
    Registry
@endsection

<style type="text/css">
    .length {
        width: 80px;
    }

    .remove {
        padding-top: 12px;
        cursor: pointer;
    }
</style>

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                        id='processing'><strong><em>Created Files.</em></strong></span></h3>
            </div>

            <div class="box-body">
                <div class="row">

                        <h4 style="text-align: center">Created Files <i class="fa fa-files-o" aria-hidden="true"></i></h4>

                    @includeIf('Share.message')

                        <div class="col-md-12">
                            <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                                <thead>
                                    <tr>
                                        <th>FILE NO. / NAME</th>
                                        <th>SHELF NUMBER</th>
                                        <th>DESCRIPTION</th>
                                        <th>VOLUME</th>
                                        <th>CATEGORY</th>
                                        <th colspan="2" style="text-align: center;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($files) && $files)
                                        @foreach ($files as $list)
                                            <tr>
                                                <td>{{ $list->fileNo }} <input type="hidden" name="fileNo[]"
                                                        value="{{ $list->fileNo }}"></td>
                                                <td>{{ $list->shelfNo === 0 ? '--' : $list->shelfNo }}</td>
                                                <td>{{ $list->file_description }}</td>
                                                <td>{{ $list->volume_name }}</td>
                                                <td>{{ $list->category }}</td>
                                                <td><a href="{{ url('/edit-file/' . $list->file_ID) }}"
                                                        class="btn btn-success" title="edit file">
                                                        <i class="fa fa-edit"></a></td>
                                                <td>
                                                    <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-danger"
                                                        data-backdrop="false"
                                                        data-target="#deleteFile{{ $list->file_ID }}"
                                                        title="delete this file"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            {{-- delete modal --}}
                                            <div class="modal fade text-left d-print-none"
                                                id="deleteFile{{ $list->file_ID }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel123" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Remove File</h5>

                                                        </div>
                                                        <div class="modal-body">
                                                            <P>Are you sure you want to remove this file:
                                                                {{ $list->file_description }}?</P>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-danger"
                                                                data-dismiss="modal">{{ __('Close') }}</button>

                                                            <button type="submit" form="removeFile"
                                                                class="btn btn-sm btn-danger">DELETE!!</button>
                                                            <form action="/delete-file/{{ $list->file_ID }}"
                                                                id="removeFile" method="POST">
                                                                @csrf @method('DELETE')

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            {{ $files->links() }}
                        </div>

                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div>

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery-duplifer.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $(".find-duplicates").duplifer();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#servicedetail").on('click', '.remove', function() {
                //$(this).closest('tr').remove();
            });

            $("#servicedetail").on('click', '.remove', function() {
                var fileNo = $(this).attr('id');

                $.ajax({
                    url: murl + '/bulk-transfer/delete-temp',
                    type: "post",
                    data: {
                        'fileNo': fileNo,
                        '_token': $('input[name=_token]').val()
                    },

                    success: function(data) {
                        location.reload(true);

                    }
                })

            });

        });

    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            // function displayResult() {
            //save selected records to DB
            //setInterval(function(){
            $token = $("input[name='_token']").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $token
                },
                type: 'get',
                url: murl + '/bulk-transfer/get-temp',
                //data: {'_token': $('input[name=_token]').val()},

                success: function(datas) {
                    console.log(datas);

                    $.each(datas, function(index, obj) {
                        console.log(obj.fileNo);
                        //alert('ok');
                        var tr = $("<tr></tr>");
                        tr.append("<td>" + obj.fileNo +
                            " <input type='hidden' class='form-control length fileNo'  style='width:80px;' name='fileNo[]' value='" +
                            obj.fileNo + "'></td>");
                        tr.append("<td>" + obj.file_description + "</td>");
                        /*tr.append("<td>"+ obj.surname +"</td>");
                        tr.append("<td>"+ obj.othernames +"</td>");
                        tr.append("<td>"+ obj.Designation +"</td>");*/
                        tr.append(
                            "<td><input type='text' class='form-control length' style='width:80px;' name='volume[]'></td>"
                        );
                        tr.append(
                            "<td><input type='text' class='form-control length' style='width:80px;' name='lastPage[]'></td>"
                        );
                        tr.append("<td><i class='fa fa-close remove' id='" + obj.fileNo +
                            "'></i></td>");
                        //tr.append("<td><select name='type' class='form-control'><option>Incoming</option><option>Outgoing</option></select></td>");
                        //tr.append("<td><input type='checkbox' name='check'></td>");

                        $("#servicedetail").append(tr);

                    });

                    //$("#selectFile").html(datas);

                }


            });
            //end retrieve result
            // }, 2000);
            //}//end function
            //displayResult(); // To output when the page loads
            //setInterval(displayResult, (2 * 1000)); // x * 1000 to get it in seconds

        });
    </script>
@endsection
