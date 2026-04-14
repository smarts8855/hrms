@extends('layouts.layout')
@section('pageTitle')
    Payroll Comments
@endsection
@section('content')
        <div class="box-body" style="background:#FFF;">
            <div class="row">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <!--2nd col-->
                    <h4 class="" style="text-transform:uppercase">Comments On {{$division}} {{$month}} {{$year}}  Payroll Report</h4>
                    {{-- {{$month}} --}}
                    <div class="row">
                    </div>
                </div>
            </div>
            <br><br>
            <div class="table-responsive" style="font-size: 12px; padding:10px;" id="dontBrk">
                <table class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th width="1%">S/N</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Attachment</th> <!-- NEW COLUMN -->
                            <th>Date</th>
                        </tr>
                    </thead>
                    @php $serialNum = 1; @endphp

                    @if(count($allcomments) > 0)
                    @foreach ($allcomments as $b)
                        <tr>
                            <td>{{ $serialNum++ }} </td>
                            <td>{{ $b->name }}</td>
                            <td>{{ $b->comment }}</td>
                            <td>
                                <!-- DISPLAY ATTACHMENT IF EXISTS -->
                                @if(!empty($b->attachment))
                                    <a href="{{ $b->attachment }}" target="_blank" class="btn btn-xs btn-info">
                                        <i class="fa fa-paperclip"></i> View
                                    </a>
                                    <small class="text-muted">({{ substr(strrchr($b->attachment, "."), 1) }})</small>
                                @else
                                    <span class="text-muted">No attachment</span>
                                @endif
                            </td>
                            <td>{{ date('M d, Y h:i A', strtotime($b->updated_at)) }}</td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-danger"> No Comments found...</td> <!-- UPDATED COLSPAN -->
                        </tr>
                    @endif
                </table>
            </div>
            <div class="">
                <button class="print-window btn btn-primary fa fa-print" onclick="window.print()" type="button" id="pBtn"> Print</button>
            </div>
        </div><!-- /.col -->
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <style>
        @media print {
            #pBtn{
                display: none;
            }
            #dontBrk{
                page-break-inside: avoid;
            }
            .btn-info {
                display: none;
            }
            .text-muted {
                color: #999 !important;
            }
        }
    </style>
@endsection