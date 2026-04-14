@extends('layouts.layout')
@section('pageTitle')
    Staff Liability
@endsection
@section('content')
    <div id="editModal" class="modal fade">
        <div class="modal-dialog " role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    {{-- <h4 class="modal-title">Edit Record</h4> --}}
                    <h4 class="modal-title">Take/Clear Liability</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="editpartModal" name="editpartModal" role="form" method="POST"
                    action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class=" control-label">File No:</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" value="" name="fileno" id="file_no" class="form-control">
                                <input type="hidden" value="" name="id" id="eid">
                            </div>
                            <div class="col-sm-12">
                                <label class=" control-label">Economic Code</label>
                            </div>
                            <div class="col-sm-12">
                                <select class="form-control" name="economics" id="eeconomics" required>
                                    <option value="">-Select-</option>
                                    @foreach ($economiccodes as $list)
                                        <option value="{{ $list->ID }}"
                                            {{ old('economics') == $list->ID || $economics == $list->ID ? 'selected' : '' }}>
                                            {{ $list->economicCode }}|{{ $list->description }}({{ $list->economicHead }}-{{ $list->contractType }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Contract Description</label>
                            </div>

                            <div class="col-sm-12">
                                <textarea name="description" id="edescription" class="form-control"> </textarea>
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Contract Values</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" value="" name="contractvalue" id="econtractvalue" placeholder=""
                                    class="form-control">
                            </div>
                            {{-- <div class="col-sm-12">
                                <label class="control-label"> Company </label>
                            </div>

                            <div class="col-sm-12">
                                <select name="companyid" id="ecompanyid" class="form-control">
                                    <option value=""></option>
                                    @foreach ($companyDetails as $list)
                                        <option value="{{ $list->id }}">{{ $list->contractor }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-sm-12">
                                <label class="control-label">Liability Date</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" value="" name="date_awarded" id="edate_awarded"
                                    autocomplete="off" class="form-control">
                            </div>
                            <div class="col-sm-12">
                                <label class=" control-label">Liability Taken Status</label>
                            </div>
                            <div class="col-sm-12">
                                <select class="form-control" name="istaken" id="istaken" required>
                                    <option value="">-Select-</option>
                                    @foreach ($TakenStatus as $list)
                                        <option value="{{ $list->codestatus }}">{{ $list->status_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-sm-12">
                                <label class=" control-label">Clearance Status</label>
                            </div>
                            <div class="col-sm-12">
                                <select class="form-control" name="iscleared" id="iscleared" required>
                                    <option value="">-Select-</option>
                                    @foreach ($ClearanceStatus as $list)
                                        <option value="{{ $list->codestatus }}">{{ $list->status_description }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" name="update" class="btn btn-success">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <!--decline modal-->
    <div id="declineModal" class="modal fade">
        <form class="form-horizontal" role="form" method="post" action="">
            {{ csrf_field() }}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Liability Rejection</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> You are about to reject this Document from liability processing! Do you still want to continue?
                        </h5>
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="control-label"><b>Enter Reason for Decline</b></label>
                            </div>
                            <div class="col-sm-12">
                                <textarea name="comment" class="form-control" required> </textarea>
                            </div>
                            <input type="hidden" id="vdid" name="lid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" name="decline" class="btn btn-success">Continue</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!--end of decline modal--> <!--reason modal-->


    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>
            <div class="col-md-12">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if ($error != '')
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        <p>{{ $error }}</p>
                    </div>
                @endif
                @if ($success != '')
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ $success }}
                    </div>
                @endif
                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('funds.Share.message')
                        <form class="form-horizontal" id="form1" role="form" method="post" action=""
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label">Economics Code</label>
                                        <select class="form-control" name="economics" required>
                                            <option value="">-Select-</option>
                                            @foreach ($economiccodes as $list)
                                                <option value="{{ $list->ID }}"
                                                    {{ old('economics') == $list->ID || $economics == $list->ID ? 'selected' : '' }}>
                                                    {{ $list->economicCode }}|{{ $list->description }}({{ $list->economicHead }}-{{ $list->contractType }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Contract File No:</label>
                                        <input extarea required class="form-control" id="fileno"
                                            placeholder="e.g SCN/XXXX" name="fileno" value="{{ old('fileno') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Contract Description</label>
                                        <textarea required class="form-control" name="description">{{ old('description') ? old('description') : $description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Contract Value</label>
                                        <input required class="form-control" id="contractvalue"
                                            value="{{ old('contractvalue') ? old('contractvalue') : $contractvalue }}"
                                            placeholder="e.g. N100000" type="text" name="contractvalue">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Beneficiary Name</label>
                                        <select required class="form-control" id="companyid" name="companyid">
                                            <option value="">Select Company</option>
                                            @foreach ($companyDetails as $list)
                                                <option value="{{ $list->id }}"
                                                    {{ old('companyid') == $list->id ? 'selected' : '' }}>
                                                    {{ $list->contractor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Liability Date</label>
                                        <input type="date" required class="form-control" autocomplete="off"
                                            name="date_awarded" value="{{ old('date_awarded') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Attach file</label>
                                        <input class="form-control" type="file" id="file" autocomplete="off"
                                            name="filex">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button class="form-control btn btn-success" name="add">Submit</button>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                    </form>
                    <!-- /.row -->

                    {{-- <!--     <div class="row" style="background: #f9f9f9; padding: 10px 0;">-->
			<!--<div align="left" class="col-md-6">-->
			<!--	<form method="post" action="{{url('/voucher/view')}}">-->
			<!--	{{ csrf_field() }}-->
			<!--	@includeif('layouts._searchByDatePatialView')-->
   <!--        	  </form>-->
   <!--        </div>-->
   <!--     </div>--> --}}

                    <div class="row">
                    </div>
                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table id="res_tab" class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>S/N</th>
                                    <th>File No</th>
                                    <th>Beneficiary</th>
                                    <th>Economic code</th>
                                    <th>Contract description</th>
                                    <th>Contract value</th>
                                    <!--<th>Beneficiary</th>-->
                                    <th>Is Liability taken</th>
                                    {{-- <th>Is Liability cleared</th> --}}
                                    <th>Liability Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php $i = 1; @endphp
                            <tbody>
                                @foreach ($procurementlist as $list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $list->fileno }} <br>{{ $list->voucherFileNo }}</td>
                                        <td>{{ $list->beneficiary }}</td>
                                        <td>{{ $list->economicCode }}|{{ $list->ecotext }}-{{ $list->contractType }}</td>
                                        <td>{{ $list->decription }}</td>
                                        <td>&#8358; {{ number_format($list->amount, 2) }}</td>
                                        <!--<td>{{ $list->contractor }}</td>-->
                                        <td>
                                            @if ($list->status == 1)
                                                <b><span class="text-success">Taken</span></b>
                                            @else
                                                <b><span class="text-danger">Pending</span></b>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if ($list->is_cleared == 1)
                                                <b><span class="text-success">Cleared</span></b>
                                            @else
                                                <b><span class="text-danger">Pending</span></b>
                                            @endif
                                        </td> --}}
                                        <td>{{ $list->date_awarded }}</td>
                                        <td>
                                            {{-- <button
                                                onclick="return editfunc('{{ $list->id }}', '{{ $list->fileno }}','{{ $list->decription }}','{{ $list->amount }}','{{ $list->beneficiary_id }}','{{ $list->date_awarded }}','{{ $list->economic_id }}','{{ $list->status }}','{{ $list->is_cleared }}')"
                                                class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button> --}}
                                            <button
                                                onclick='editfunc(
                                                    {{ $list->id }},
                                                    @json($list->fileno),
                                                    @json($list->decription),
                                                    {{ $list->amount }},
                                                    {{ $list->beneficiary_id }},
                                                    @json($list->date_awarded),
                                                    {{ $list->economic_id }},
                                                    {{ $list->status }}
                                                )'
                                                class="btn btn-success btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            @if ($list->status == 0)
                                                <button class="btn btn-danger btn-xs " type="button"
                                                    onclick="return decline('{{ $list->id }}')">
                                                    Decline
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr />
                </div>
            </div>
        </div>
    @endsection

    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
        <!-- Include Required Prerequisites -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
        <!-- Include Date Range Picker -->
        <link rel="stylesheet" type="text/css"
            href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    @endsection


    @section('styles')
        <style type="text/css">
            .modal-dialog {
                width: 13cm
            }

            .modal-header {
                background-color: #006600;
                color: #FFF;
            }

            #partStatus {
                width: 2.5cm
            }
        </style>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script>
            $('#res_tab').DataTable({
                "iDisplayLength": 100
            });
            $("#contractvalue").blur(function(evt) {
                if (evt.which != 190) { //not a fullstop
                    var n = parseFloat($(this).val().replace(/\,/g, ''), 10);
                    $(this).val(n.toLocaleString());
                    //$(this).val(n.toLocaleString());
                }
            });

            $(function() {
                $("#todayDate").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });

            $(function() {
                $("#dateawd").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });
            $("#check-all").change(function() {
                $(".checkitem").prop("checked", $(this).prop("checked"))
            })
            $(".checkitem").change(function() {
                if ($(this).prop("checked") == false) {
                    $("#check-all").prop("checked", false)
                }
                if ($(".checkitem:checked").length == $(".checkitem").length) {
                    $("#check-all").prop("checked", true)
                }
            })

            function editfunc(id, fileno, discription, amount, company, dateawarded, economiccode, istaken) {
                console.log("clicked");
                document.getElementById('eid').value = id;
                document.getElementById('file_no').value = fileno;
                document.getElementById('edescription').value = discription;
                document.getElementById('econtractvalue').value = amount;
                // document.getElementById('ecompanyid').value = company;
                document.getElementById('edate_awarded').value = dateawarded;
                document.getElementById('eeconomics').value = economiccode;
                document.getElementById('istaken').value = istaken;
                $("#editModal").modal('show')
            }

            function deletefunc(x) {
                document.getElementById('deleteid').value = x;
                $("#DeleteModal").modal('show');
            }

            function ReloadForm() {
                document.getElementById('form1').submit();
                return;
            }

            function decline(a = "") {
                document.getElementById('vdid').value = a;
                $("#declineModal").modal('show')
                return false;
            }
        </script>

        @includeif('layouts._searchByDatePatial')
    @endsection
