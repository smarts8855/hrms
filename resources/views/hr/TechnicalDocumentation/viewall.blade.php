@extends('layouts.printlayout')
@section('pageTitle')
Project Documentation
@endsection

@section('content')

<div class="container">
	<div class="col-md-12">
		<h2 class="col-md-6 col-md-offset-3 text-center">DOCUMENTATION REPORT FOR MODULE <b>{{ strtoupper($module) }}</b> UNDER CATEGORY <b>{{ strtoupper($category) }}</b> </h2>
	</div>
</div>
<div class="clearfix"></div>
<br><br><br>
<div class="fluid-container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<b>
			<table class="table
			table-striped">
				<tr>
					<td>PROJECT NAME:</td>
					<td>{{ strtoupper($module) }}</td>
				</tr>
				<tr>
					<td>DEVELOPED BY:</td>
					<td>{{ strtoupper($developedby) }}</td>
				</tr>
				<tr>
					<td>CATEGORY:</td>
					<td>{{ strtoupper($category) }}</td>
				</tr>
			</table>
			</b>
		</div>
		<div class="form-group">
			
			<div class="col-md-6 col-md-offset-3">          
                    <label class="control-label"> Description </label>
                    <textarea class="form-control" disabled="disabled"> {{ $desc }}</textarea>
                    <span class="pull-right"> <i>Created</i> {{ $date }}</span>
            </div>
        </div>

            <p class="col-md-6 col-md-offset-3 text-center"><b>{{ strtoupper('Modifications') }}</b></p>
            @if(!empty($modifications))
	            @foreach($modifications as $list)
	            <div class="form-group">
	            	<div class="col-md-6 col-md-offset-3">     
		                    <label class="control-label">  Description </label>
		                    <textarea class="form-control" disabled="disabled"> {{ $list->description }}</textarea>
		                    <span class="pull-left"> Modified by {{ $list->modifiedby }}</span>
		                    <span class="pull-right"> <i>Created</i> {{ $list->datemodified }}</span>
		            </div>
		        </div>
	            @endforeach
	        @else
	        	<p class="col-md-6 col-md-offset-3 text-center"><b class="text-danger">{{ strtoupper('There are no modifications yet') }}</b></p>
	        @endif
	        <div class="form-group">
            <div class="col-md-12"> 
            	<div class="col-md-2 col-md-offset-5">
            		<button onclick="window.print()" class="btn btn-success form-control">Print</button>
            	</div>
		            
		     </div>
		    </div>
		</div>
		
	</div>
</div>

@endsection