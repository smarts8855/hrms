@extends('layouts.layout')
@section('pageTitle')
    Council Members Payroll Location
@endsection
@section('content')

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle')</h3>
                </span>
            </div>

            <div class="table-responsive" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th width="1%">S/N</th>
                            <th>Justice</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Stage</th>
                            <th>Decision</th>
                        </tr>
                    </thead>
                    @php $serialNum = 1; @endphp

                    @if (count($salary) > 0)
                        @foreach ($salary as $b)
                            <tr class="{{ $b->is_rejected == 1 ? 'alert alert-danger' : '' }}">
                                <td>{{ $serialNum++ }} </td>
                                <td><button class="btn btn-xs btn-primary" id="locationButton"> <span class="fa fa-eye"></span> Justices Payroll</button></td>
                                <td>
                                    {{ $b->year }}
                                    <input type="hidden" value="{{$b->year}}" id="year">
                                </td>
                                <td>
                                    {{ $b->month }}
                                    <input type="hidden" value="{{$b->month}}" id="month">
                                </td>
                                <td>{{ $b->description }}</td>
                                <td>
                                    @if ($b->vstage == 6)
                                        {{ 'Approved' }}
                                    @else
                                        {{ 'Awaiting approval' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-danger"> No Records found...</td>
                        </tr>
                    @endif

                </table>

                <form id="location" method="post" action={{ url('/council-members/payroll-vc') }}>
                    {{ csrf_field() }}
                    <input type="hidden" id="locationMonth" name="month"/>
                    <input type="hidden" id="locationYear" name="year"/>
                </form>

            </div>
        </div>
    </div>


@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection
@section('scripts')
<script>
    document.getElementById('locationButton').addEventListener('click', function() {
        const month = document.getElementById('month').value
        const year = document.getElementById('year').value
        document.getElementById('locationMonth').value = month
        document.getElementById('locationYear').value = year
        document.getElementById('location').submit();
    });
  </script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

@endsection
