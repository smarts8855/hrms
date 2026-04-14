@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Budget Market Survey Archive') }}
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Market Survey Item Archive</h4>
                    <hr />

                    <div class="row">
                        <div align="center" class="form-group mb-0 col-md-12">
                            <table class="table table-hover table-responsiv table-bordered" id="exportTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">SN</th>
                                        <th scope="col"> Item</th>
                                        <th scope="col">Specification</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Contract Price</th>
                                        <th scope="col">Market Price</th>
                                        <th colspan="2">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($getBudgetMarketSurvey) && is_iterable($getBudgetMarketSurvey))
                                        @foreach ($getBudgetMarketSurvey as $key => $value)
                                            <tr class="text-left" id="row{{ $key }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->item }}</td>
                                                <td>{{ $value->specification }}</td>
                                                <td>{{ $value->category }}</td>
                                                <td class="text-right">{{ number_format($value->price, 2) }}</td>
                                                <td class="text-right">{{ number_format($value->marketPrice, 2) }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($value->created_at)->format('F j, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div align="center" class="form-group mb-0 col-md-12">
                            <a href="{{ route('archive-generate-pdf') }}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Export to PDF
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>


@endsection

@section('styles')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script> --}}

    <style>
        /* Add custom styles here if needed */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/table2excel.js') }}"></script>
    <!--Format Amount while typing-->
    <script>
        //Number Format
        $(document).ready(function() {
            $("#formatAmountOnKeyPress").on('keyup', function(evt) {
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

        (function($, undefined) {
            "use strict";
            // When ready.
            $(function() {
                var $form = $(".formFormatAmount");
                var $input = $form.find(".format-amount");
                $input.on("keyup", function(event) {
                    // When user select text in the document, also abort.
                    var selection = window.getSelection().toString();
                    if (selection !== '') {
                        return;
                    }
                    // When the arrow keys are pressed, abort.
                    if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                        return;
                    }
                    var $this = $(this);
                    // Get the value.
                    var input = $this.val();
                    var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt(input, 10) : 0;
                    $this.val(function() {
                        return (input === 0) ? "" : input.toLocaleString("en-US");
                    });
                });

            });
        })(jQuery);
    </script>

    <script>
        $(document).ready(function() {
            $('#exportAllBtn').click(function() {
                // Instead of AJAX, redirect to the controller action that generates the PDF
                window.location.href = '{{ route('generate-pdf') }}';
            });
        });
    </script>
@endsection
