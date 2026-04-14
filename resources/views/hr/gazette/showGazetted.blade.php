@extends('layouts.layout')

@section('pageTitle')
    Gazettes for {{$staffName->surname. ' '.$staffName->first_name}}
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <div class="box-body">
		       
		            {{-- @includeIf('Share.message') --}}

                    <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="holidayTable" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>REASON FOR GAZETTE</th>
                                <th>DATE GAZETTED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $key = 1; @endphp
                            @forelse ($gazette as $key => $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->gazetteName}}</td>
                                <td>{{date('d-M-Y', strtotime($item->dateGazetted))}}</td>
                            </tr>
                            @empty
                                <tr>
                                    No Gazette was found
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>

                    </div>

		        
		    </div><!-- /.row -->

		    <div>
                <a href="{{url('search-gazetted-staff')}}"> <button type="button" class="btn btn-primary">Go Back</button> </a>
            </div> 
	</div>
</div>

@endsection

@section('styles')

@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>

@endsection
 