@extends('layouts.layout')
@section('pageTitle')
    Payroll Comments
@endsection
@section('content')
        <div class="box-body" style="background:#FFF;">
            <div class="row">
                <div class="col-md-12">
                    <!--1st col-->
                  
                </div>
                {{ csrf_field() }}
                <div class="col-md-12">
                    <!--2nd col-->
                    <h4 class="" style="text-transform:uppercase">Comments On Justices Payroll {{$year}} {{$month}} Payroll Report</h4>
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
                            <td>{{ $b->updated_at }}</td>
                            	
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-danger"> No Comments found...</td>
                        </tr>
                    @endif

                </table>
            </div>
            <div class="">
                <button class="print-window btn btn-primary fa fa-print" onclick="window.print()" type="button" id="pBtn"> Print</button>
            </div>
        </div><!-- /.col -->
        </div><!-- /.row -->

        @endsection
        @section('styles')
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
        @endsection

        <style>
            @media print {
                #pBtn{
                    display: none;
                }
                #dontBrk{
                    page-break-inside: avoid;
                }
            }
        </style>
       
