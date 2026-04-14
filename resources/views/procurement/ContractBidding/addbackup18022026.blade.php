@extends('layouts_procurement.app')
@section('pageTitle', 'Add Bid')
@section('pageMenu', 'active')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default"> <!-- Bootstrap 3 card alternative -->

                <div class="panel-heading">
                    <h4 class="panel-title">Add Contract Bid</h4>
                </div>

                <div class="panel-body">


                    <form method="post" action="{{ url('/add-bidding') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contract <span class="text-danger">*</span></label>
                                    <select class="form-control" name="contract">
                                        <option value="">Select...</option>
                                        @foreach ($contract as $list)
                                            <option value="{{ $list->contract_detailsID }}"
                                                @if ($list->contract_detailsID == session('contractSess')) selected @endif>
                                                {{ $list->contract_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contractor <span class="text-danger">*</span></label>
                                    <select class="form-control" name="contractor">
                                        <option value="">Select...</option>
                                        @foreach ($contractor as $list)
                                            <option value="{{ $list->contractor_registrationID }}"
                                                @if ($list->contractor_registrationID == session('contractorSess')) selected @endif>
                                                {{ $list->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bid Amount <span class="text-danger">*</span></label>
                                    <input type="text" name="biddingAmount" class="form-control"
                                        value="{{ session('amountSess') }}" placeholder="Bid Amount">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" max="{{ date('Y-m-d') }}"
                                        value="{{ session('dateSess') }}">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Remark <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="contractorRemark">{{ session('contractRemarkSess') }}</textarea>
                        </div>

                        <h4 class="text-center">Upload Technical Documents</h4>
                        <hr>
                        <div class="row">
                            @foreach ($requiredDocsTechnical as $item)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ $item->bid_doc_description }}</label>
                                        <input type="hidden" name="docDescId[]" value="{{ $item->id }}">
                                        <input type="file" name="document[]" class="form-control">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <h4 class="text-center">Upload Financial Documents</h4>
                        <hr>
                        <div class="row">
                            @foreach ($requiredDocsFinancial as $item)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ $item->bid_doc_description }}</label>
                                        <input type="hidden" name="docDescId[]" value="{{ $item->id }}">
                                        <input type="file" name="document[]" class="form-control">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-right" style="margin-top: 20px;">
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>

                    </form>

                </div><!-- panel-body -->

            </div><!-- panel -->
        </div>
    </div>

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
    <script src="{{ asset('assets/js/jquery.3.4.1.slim.min.js') }}"></script>
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
        /*$(document).ready(function () {
                              $(document).on('input', '#biddingAmount', function (e) {
                                if (/^[0-9.,]+$/.test($(this).val())) {
                                  $(this).val(
                                    parseFloat($(this).val().replace(/,/g, '')).toLocaleString('en');
                                  );
                                } else {
                                  $(this).val(
                                    $(this)
                                      .val()
                                      .substring(0, $(this).val().length - 1)
                                  );
                                }
                              });
                            });*/

        $(document).ready(function() {
            $("#biddingAmount").on('keyup', function(evt) {
                //if (evt.which != 110 ){//not a fullstop
                //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
                //$(this).val(n.toLocaleString());
                //}
            });
        });



        /*  $(document).ready(function() {
                          $('#add').click(function() {
                           var total_element = $(".wraps").length;
                           var lastid = $(".wraps:last").attr("id");
                           //var split_id = lastid.split('_');
                          var n = Number(lastid) + 1;
                          //alert(nextindex);
                            $('#inputWrap').append(
                                `<div class="wraps" id="'+n+'">
    <div class="row">
    <div class="col-md-5">
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
    <span class="delete bn"><i class="fa fa-times"></i></span>
    </div>
    </div>`
                                );
                          });
                          //end click function

                          $('.delete').last().click (function () {
                        						$('.wraps').last().remove();
                        					});

                        });*/
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
            <label for="">Evaluating Document</label>
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

    <script>
        $("#dateSubmitted").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2090', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "dd-mm-yy",
            onSelect: function(dateText, inst) {
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
                $('#dateSubmitted').val($.datepicker.formatDate('dd-mm-yy', theDate));
            },
        });
    </script>





@endsection
