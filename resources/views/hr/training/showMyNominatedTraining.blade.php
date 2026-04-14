@extends('layouts.layout')

@section('pageTitle')
    MY NOMINATED TRAINING
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
            </div>
            
            <div class="box-body">
                
            </div><!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <em class="text-danger"></em>
                    <table class="table table-bordered table-striped" id="holidayTable" width="100%">
                        <div class="text-center" style="margin-bottom: 6px;">{{$loggedUser->surname}}, THESE ARE THE TRAINING YOU WERE NOMINATED FOR:</div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>COURSE TITLE</th>
                                <th>START DATE</th>
                                <th>END DATE</th>
                                <th>TIME</th>
                                <th>VENUE</th>
                                <th>CONSULTANT</th>
                                <th>NOMINATION LETTER</th>

                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse ($nominated as $key => $n)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    
                                    <td>{{$n->title}}</td>
                                    <td>{{$n->training_date}}</td>
                                    <td>{{$n->training_end_date ?? $n->training_date}}</td>
                                    <td>{{$n->training_time}}</td>
                                    <td>{{$n->venue}}</td>
                                    <td>{{$n->consultant}}</td>
                                    <td>
                                        <a class="btn btn-primary" href='{{url("nomination-letter/$n->ID/for/$loggedUser->ID")}}' target="_blank"> 
                                            View Letter 
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <em><h4>No Training was found</h4></em>
                            @endforelse
                        </tbody>
                    </table>
        
                </div>
            </div>

        </div>
    </div>


@endsection