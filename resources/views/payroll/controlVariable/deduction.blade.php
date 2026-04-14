@extends('layouts.layout')

@section('pageTitle')

    Deductions

@endsection










@section('content')










    <div class="box box-default">

        <div id="editModal" class="modal fade">

            <div class="modal-dialog box box-default" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h4 class="modal-title">Edit Particular</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                </div>




            </div>

        </div>




        <div class="box-body box-profile">

            <div class="box-header with-border hidden-print">

                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>

            </div>

            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">

                        <!--1st col-->

                        @include('funds.Share.message')







                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">

                        <table id="mytable" class="table table-bordered table-striped table-highlight">

                            <thead>

                                <tr bgcolor="#c7c7c7">







                                    <th>S/N</th>

                                    <th>Deduction</th>

                                    <th> <br>

                                        Is payable

                                        <input type="checkbox" class="selectall">

                                    </th>

                                </tr>

                            </thead>

                            @foreach ($deductions as $key=>$deduction)

                                <tr>

                                    <td>{{ ($deductions->currentpage()-1) * $deductions->perpage() + (1+$key ++) }}</td>

                                    <td>{{ $deduction->description }}</td>




                                    <td>

                                        <form action="{{ route("controldectuction.updateDeduction") }}" method="post">

                                            {{ csrf_field() }}

                                            <input name="description" type="hidden" value="{{$deduction->description}}">

                                            <div>




                                                @if($deduction->isPayable)

                                                    <input name="isPayableValue[]" type="hidden" id="isPayableValueSet{{$deduction->ID}}" value="{{$deduction->isPayable}}" />

                                                    <input  type="checkbox" id="Set{{$deduction->ID}}" class="setValue" name="payableStatus[]" checked/> 

                                                @else

                                                    <input name="isPayableValue[]" type="hidden" id="isPayableValueSet{{$deduction->ID}}" value="{{$deduction->isPayable}}" />

                                                    <input  type="checkbox" id="Set{{$deduction->ID}}" class="setValue" name="payableStatus[]" /> 

                                                @endif




                                            </div>




                                    </td>




                                </tr>







                            @endforeach

                        </table>

                        <div>

                            <button class="btn btn-success" type="submit">Update</button>

                        </div>

                    </form>




                    </div>




                    <hr />

                    <div class="row">

                        <div align="right" class="col-xs-12 col-sm-12">

                            Showing {{($deductions->currentpage()-1)*$deductions->perpage()+1}}

                            to {{$deductions->currentpage()*$deductions->perpage()}}

                            of  {{$deductions->total()}} entries

                            <br />

                            <div class="hidden-print">{{ $deductions->links() }}</div> 

                        </div>

                    </div>

                </div>




            </div>

        </div>

    </div>







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

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>




    {{-- Set Check Value --}}

    <script>

        $('.setValue').click(function() {

            id = this.id;

            if ($('#' + id).is(":checked") == true) {

                $('#isPayableValue' + id).val('1');

            } else {

                $('#isPayableValue' + id).val('0');

            }

        });

    </script>




    {{-- Select all checkbox --}}

    <script>

        $('.selectall').click(function() {

            if ($(this).is(':checked')) {

                $('div input').attr('checked', true);

            } else {

                $('div input').attr('checked', false);

            }

        });

    </script>







    <script>

        function editfunc(id, desc, status, rank) {

            document.getElementById('partid').value = id

            document.getElementById('e-desc').value = desc

            // document.getElementById('e-bank').value = bank

            // document.getElementById('e-aname').value = accname

            // document.getElementById('e-anumber').value = accnum

            document.getElementById('e-status').value = status

            document.getElementById('e-rank').value = rank



            $("#editModal").modal('show');

        }

        function deletefunc(id, desc, status, rank) {

            // document.getElementById('id').value = id

            // document.getElementById('desc').value = desc

            // document.getElementById('status').value = status

            // document.getElementById('e-rank').value = rank



            $("#deleteModal").modal('show');

        }

        





        function TextBoxState() {

            var p = document.getElementById("particulars").value;



            if (p == "2") {

                document.getElementById('accounthead').setAttribute('disabled', 'disabled');

                document.getElementById('allocationtype').setAttribute('disabled', 'disabled');

                document.getElementById('economiccode').setAttribute('disabled', 'disabled');

            }

            if (p == "1") {

                document.getElementById('accounthead').removeAttribute('disabled');

                document.getElementById('allocationtype').removeAttribute('disabled');

                document.getElementById('economiccode').removeAttribute('disabled');

            }

            return;

        }



        function Reload() {

            document.forms["mainform"].submit();



            return;

        }

    </script>

@stop