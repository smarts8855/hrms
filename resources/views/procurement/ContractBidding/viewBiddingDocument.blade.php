@extends('layouts_procurement.app')
@section('pageTitle', 'Bidding Documents')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
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
                @if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                    	{{ session('msg') }}</div>                        
                @endif
                @if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                    	{{ session('err') }}</div>                        
                @endif
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Document Description</th>
                        <th>Date Uploaded</th>
                        <th width="50">Preview</th>
                        <!--<td width="10">Delete</td>-->
                    </tr>
                    </thead>

                    @php
                    $n=1;
                    @endphp
                    <tbody>
                        @foreach($viewDocuments as $list)
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$list->file_description}}</td>
                        <td>{{date("jS M, Y", strtotime($list->created_at))}}</td>
                        <td><a href="{{asset('/BiddingDocument/'.$list->file_name)}}" target="_blank" class="btn btn-success btn-sm float-right">preview</a></td>
                        <!--<td><a href="{{url('/delete-bidding/doc/'.$list->contractor_bidding_documentID)}}" class="text-danger float-right" title="" data-original-title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a</td>-->
                        
                    </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@endsection

@section('styles')

@endsection

@section('scripts')

@endsection
