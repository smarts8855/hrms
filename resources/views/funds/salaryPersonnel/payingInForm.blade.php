@extends('layouts.layout')
@section('pageTitle')
    PAYING-IN-FORM
@endsection

@section('content')
    <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to delete this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="deleteid" name="deleteid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" name="delete" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div id="editModal" class="modal fade">
        <div class="modal-dialog " role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Record</h4>
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
                                <input type="text" value="" name="fileno" id="efileno" readonly
                                    class="form-control">
                            </div>
                            <div class="col-sm-12">
                                <label class=" control-label">Approval Page:</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" value="" name="approvalpage" id="eapprovalpage"
                                    class="form-control">
                            </div>
                            <div class="col-sm-12">
                                <label class=" control-label">Account Head</label>
                            </div>
                            <div class="col-sm-12">
                                <select name="contracttype" id="econtracttype" class="form-control">
                                    <option value="6">Personnel</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Description</label>
                            </div>

                            <div class="col-sm-12">
                                <textarea name="description" id="edescription" class="form-control"> </textarea>
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Total</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" value="" name="claimvalue" id="econtractvalue" placeholder=""
                                    class="form-control">
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Beneficiary</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" value="" name="benef" id="ebenef" placeholder=""
                                    class="form-control">
                            </div>

                            <div class="col-sm-12">
                                <label class="control-label">Approval Date</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" value="" name="approvaldate" id="eapprovaldate"
                                    autocomplete="off" class="form-control">
                            </div>
                            {{-- <div class="col-sm-12">
                                <label class="control-label">Attach file</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="file" name="filex" autocomplete="off" class="form-control">
                            </div> --}}
                            <div class="col-sm-12">
                                <label class=" control-label">Forward to</label>
                            </div>

                            <div class="col-sm-12">
                                <select name="attension" id="actionbyid" class="form-control">
                                    <option value="HC">{{ 'CHECKING' }}</option>
                                    <option value="HEC">{{ 'EXPENDITURE CONTROL' }}</option>
                                    <option value="HAUD">{{ 'AUDIT' }}</option>
                                    <option value="HCPO">{{ 'CPO' }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">

                                    <label class="control-label">Economic code</label>
                                    <select name="economiccode" id="eeco_code" class="select_picker form-control"
                                        data-live-search="true" required>
                                        <option value="">Select Economic Code</option>
                                        @php
                                            if (old('economiccode') !== '') {
                                                $economiccode = old('economiccode');
                                            }
                                        @endphp

                                        @foreach ($econocodeList as $list)
                                            <option value="{{ $list->ID }}"
                                                @if ($economiccode == $list->ID) {{ 'selected' }} @endif>
                                                {{ $list->economicCode }}:
                                                {{ $list->description }}-{{ $list->contractType }} </option>
                                        @endforeach
                                    </select>


                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class=" control-label">Payee Address:</label>
                                    <input type="text" name="payeeAddress" id="epayeeAddr" class="form-control">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="Submit" name="update" class="btn btn-success">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    <input type="hidden" value="13" name="companyid">
                    <input type="hidden" name="cid" id="cid">
                </form>
            </div>

        </div>
    </div>

    <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to delete this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="deleteid" name="deleteid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>




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
                    <div class="col-md-12">
                        <!--1st col-->
                        @include('funds.Share.message')

                        <form class="form-horizontal" id="form1" role="form" method="post" action=""
                            enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="col-md-12">
                                <!--2nd col-->
                                <!-- /.row -->
                                <div class="form-group">

                                    <div class="col-md-2">
                                        <label class="control-label">File No:</label>
                                        <input extarea required class="form-control" id="fileno"
                                            placeholder="e.g FHC/XXXX" name="fileno" value="{{ old('fileno') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="control-label">Approval Page:</label>
                                        <input extarea required class="form-control" id="approvalpage" placeholder="e.g 12"  name="approvalpage" value="{{old('approvalpage')}}" >
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">Account Head</label>
                                        <select required class="form-control" id="contracttype" name="contracttype">
                                            <option value="">--Select--</option>
                                            <option value="6">Personnel</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">Description</label>
                                        <textarea required class="form-control" id="description" name="description">Being payment of... {{ old('contract-desc') }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <!--2nd col-->
                                <!-- /.row -->
                                <div class="form-group">


                                    <div class="col-md-4">
                                        <label class="control-label">Beneficiary</label>
                                        <input required class="form-control" id="benef"
                                            value="{{ old('benef') ? $benef : '' }}" placeholder="e.g. XYZ and Others"
                                            type="text" name="benef">
                                        <input type="hidden" value="13" id="companyid" name="companyid">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">Amount</label>
                                        <input required class="form-control" id="contractvalue"
                                            value="{{ old('claimvalue') ? $claimvalue : '' }}"
                                            placeholder="e.g. N100000" type="text" name="claimvalue">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">Approved Date</label>
                                        <?php if (old('approvaldate') != '') {
                                            $approvaldate = old('approvaldate');
                                        } ?>
                                        <input type="date" required class="form-control" name="approvaldate"
                                            value="">
                                    </div>

                                    {{-- <div class="col-md-3">
                                        <label class="control-label">Attach file/Memo</label>
                                        <input class="form-control" type="file" id="file" autocomplete="off"
                                            name="filex">
                                    </div> --}}


                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <label class="control-label">Economic code</label>
                                                <select name="economiccode" id="economiccode"
                                                    class="select_picker form-control" data-live-search="true" required>
                                                    <option value="">Select Economic Code</option>
                                                    @php
                                                        if (old('economiccode') !== '') {
                                                            $economiccode = old('economiccode');
                                                        }
                                                    @endphp

                                                    @foreach ($econocodeList as $list)
                                                        <option value="{{ $list->ID }}"
                                                            @if ($economiccode == $list->ID) {{ 'selected' }} @endif>
                                                            {{ $list->economicCode }}:
                                                            {{ $list->description }}-{{ $list->contractType }} </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-md-4">
                                                <label class=" control-label">Payee Address:</label>
                                                <input type="text" name="payeeAddress"
                                                    value="{{ old('payeeAddress') }}" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="control-label">Attention</label>
                                                <select required name="attension" class="form-control">
                                                    <option value="HC">{{ 'CHECKING' }}</option>
                                                    <option value="HEC">{{ 'EXPENDITURE CONTROL' }}</option>
                                                    <option value="HAUD">{{ 'AUDIT' }}</option>
                                                    <option value="HCPO">{{ 'CPO' }}</option>
                                                </select>
                                                <input type="hidden" value="{{ Auth::user()->username }}" id="createdby"
                                                    name="createdby">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <!--2nd col-->
                                <!-- /.row -->
                                <div class="form-group">

                                    <div class="col-md-2">
                                        <button class="form-control btn btn-success" name="save">Submit</button>
                                        <!-- <input required class="form-control" id="todayDate"  name="allocation"> -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                    </div>
                    </form>
                    <!-- /.row -->
                    <div class="row">
                        {{ csrf_field() }}


                        <!-- /.col -->
                    </div>


                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">

                        <table id="res_tab" class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>S/N</th>
                                    <th>Entry No.</th>
                                    <th>File No.</th>
                                    <th>Approval Page</th>
                                    {{-- <th>Account Type</th> --}}
                                    {{-- <th>Description</th> --}}
                                    <th>Amount</th>
                                    <th>Beneficiary</th>
                                    <th>Created BY</th>
                                    <th>Status</th>
                                    <th>Next Officer</th>
                                    <th>Approved Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php $i = 1; @endphp
                            <tbody>

                                @foreach($salaryPayInForm as $list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $list->ID }}</td>
                                        <td>{{ $list->fileNo }}</td>
                                        <td>{{ $list->ref_no?$list->ref_no:'NA' }}</td>
                                        {{-- <td>{{ $list->contractType }}</td> --}}
                                        {{-- <td>{{ $list->ContractDescriptions }}</td> --}}

                                        <td>{{ number_format($list->contractValue ,2)}}</td>
                                        <td>{{ $list->beneficiary}}</td>
                                        <td>{{ $list->name }}</td>

                                        <td>
                                            @if($list->approvalStatus == 1)
                                            <b><span class="text-success">Voucher raised</span></b>
                                            @elseif($list->approvalStatus == 2)
                                                <b><span class="text-warning">Rejected</span></b>
                                            @else
                                                <b><span class="text-danger">Pending</span></b>
                                            @endif
                                        </td>
                                        <td>{{ $list->description }}</td>
                                        <td>{{ $list->approvalDate }} </td>
                                        <td>

                                            @if($list->approvalStatus == 0)
                                            <button onclick="return editfunc('{{ $list->ID }}', '{{$list->fileNo}}', '{{$list->contract_Type}}','{{$list->ContractDescriptions}}','{{ $list->contractValue }}','{{$list->beneficiary}}','{{ $list->dateAward }}','{{ $list->awaitingActionby }}','{{ $list->ref_no }}','{{ $list->eco_code }}','{{ $list->payee_address }}')" class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                            <!--<button onclick="return deletefunc('{{ $list->ID }}')" class="btn btn-danger btn-xs" > <i class="fa fa-trash"></i> </button>-->
                                            {{-- <a target ="_blank" href="/display/comment/{{$list->ID}}" class="btn btn-info btn-xs" >Attach more...</a> --}}
                                            <a target ="_blank" href="{{route('payingInVoucher', $list->ID)}}" class="btn btn-primary btn-xs" >Preview</a>

                                            @elseif($list->approvalStatus == 1)
                                                {{-- <a target ="_blank" href="/display/comment/{{$list->ID}}" class="btn btn-info btn-xs" >Attach more...</a> --}}
                                                <a target ="_blank"  href="{{route('payingInVoucher', $list->ID)}}" class="btn btn-primary btn-xs" >Preview</a>
                                            @elseif($list->approvalStatus == 2)
                                                <button onclick="return editfunc('{{ $list->ID }}', '{{$list->fileNo}}', '{{$list->contract_Type}}','{{$list->ContractDescriptions}}','{{ $list->contractValue }}','{{$list->beneficiary}}','{{ $list->dateAward }}','{{ $list->awaitingActionby }}','{{ $list->ref_no }}','{{ $list->eco_code }}','{{ $list->payee_addr }}')" class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                                <a target ="_blank"  href="{{route('payingInVoucher', $list->ID)}}" class="btn btn-info btn-xs" >Preview</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                        </table>

                    </div>
                    <input type="hidden" value="" id="co" name="court">
                    <input type="hidden" value="" id="di" name="division">
                    <input type="hidden" value="" name="status">
                    <input type="hidden" value="" name="chosen" id="chosen">
                    <input type="hidden" value="" id="type" name="type">

                    <hr />
                </div>

            </div>
        </div>



    @endsection
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    @stop

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
                "pageLength": 50
            });

            $("#contractvalue").on('keyup', function(evt) {

                //if (evt.which != 110){//not a fullstop
                //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                x = $(this).val().replace(/[ ]*,[ ]*|[ ]+/g, '');
                $(this).val(x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                //if(isNaN(n)){

                //}
                //else{
                //$(this).val(n.toLocaleString());
                //}
                //}

            });

            $(function() {
                $("#todayDate").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });
            $(function() {
                $("#eapprovaldate").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });


            function editfunc(id, fileno, cont, desc, amt, ben, appdate, actby, ref_no, eco_code, payee_addr) {
                document.getElementById('cid').value = id;
                document.getElementById('efileno').value = fileno;
                document.getElementById('econtracttype').value = cont;
                document.getElementById('edescription').value = desc;
                document.getElementById('econtractvalue').value = amt;
                document.getElementById('ebenef').value = ben;
                document.getElementById('actionbyid').value = actby;
                document.getElementById('eapprovaldate').value = appdate;
                document.getElementById('eapprovalpage').value = ref_no;
                document.getElementById('eeco_code').value = eco_code;
                document.getElementById('epayeeAddr').value = payee_addr;
                $("#editModal").modal('show')
            }

            function deletefunc(x) {
                //$('#deleteid').val() = x;

                document.getElementById('deleteid').value = x;
                $("#DeleteModal").modal('show');
            }
        </script>
    @stop
