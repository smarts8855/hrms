@extends('layouts.layout')

@section('content')
    <div class="box-body" style="background:#FFF;">

        <div class="col-md-12" style="background:#FFF;">
            <section style="background:#FFF;">
                <div align="center">
                    <span class="banner">
                        <h2 style="font-weight: 700;color: green"></h2>
                    </span>

                    <div class="row">
                        <div class="slip-wrapper">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <p style="background-color: #00A65A; color:#FFF">{{$upload[0]->description}}</p>
                                </div>
                            </div>

                            <div class="col-xs-1"></div>

                            <div class="col-xs-12" style="height:1200;">
                                <div>
                                    <img class="img-fluid img-responsive" src="{{asset($upload[0]->upload)}}" alt="adams">
                                </div>
                            </div>

                            <div class="clearfix"></div>

                        </div>

                        <div class="clearfix"></div>
                    </div>

                </div>
                {{-- <div class="col-md-12" style="padding-left:1px;">
                    <table width="700" border="" class="tables">
                        <tr>
                            <td width="150"><strong>PREPARED BY: </strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="150"><strong>SIGNATURE: </strong></td>
                            <td></td>
                        </tr>
                    </table>

                </div> --}}
                <div class="col-md-2 hidden-print" style="margin-top:20px;"><a href="javascript:0"
                        onclick="window.print();return false;" class="btn btn-success">print</a></div>
            </section>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
@endsection

@section('styles')
    <style type="text/css">
        .table {
            border: 1px solid #000;
            font-size: 16px
        }

        .table thead>tr>th {
            border-bottom: none;
        }

        .table thead>tr>th,
        .table tbody>tr>th,
        .table tfoot>tr>th,
        .table thead>tr>td,
        .table tbody>tr>td,
        .table tfoot>tr>td {
            border: 1px solid #000;
        }

        .slip-wrapper {
            border: 1px solid #333;
            padding: 15px;
            width: 100%;
            float: left;
        }

        .border {
            border: 1px solid #333;
        }

        .tables {
            margin-top: 20px;
            border: none;
        }

        .tables tr td {
            padding: 15px 6px;
            border: none;
            margin-bottom: 10px;

        }
    </style>
    <style type="text/css" media="print">
        .col-xs-6.text-left h3,
        .col-xs-6.text-right h3 {
            font-size: 16px;
        }

        .pr {
            padding: 0px;
        }

        .col-xs-5 {
            width: 48%;
        }

        .lt {
            margin-left: 2%;
        }

        .l .col-xs-6 {
            padding: 0px;
        }
    </style>
@endsection
