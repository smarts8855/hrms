<!--NOTE: 0- false, 1-true-
 include('layouts.allReportHeader', ['companyName'=>'defaultName', 'companyAddress'=>'defaultAddress', 'title1'=>'payrol Report', 'title2'=>'date', 'showOnlyTitle1'=>1, 'showOnlyTitle2'=>0, 'hideLogos'=>0, 'hideAddress'=>0])
-->
   @php
	$oldRecord = DB::table('report_head_logo')->where('id', 1)->first();
   @endphp
	
<br />
 <div class="row">
    @if($hideLogos == 0)
    <div align="center" class="col-xs-3">
	<img width ="120" src="{{ ($oldRecord) ? asset('companyLogos/'.$oldRecord->company_logo) : ''}}" class="img-responsive">
    </div>
    @endif
    <span class="{!! ($hideLogos == 0) ? 'col-xs-6' : 'col-xs-12' !!}">
    	<div align="center" style="color:#06c;">
    		@if($companyName == ('defaultName'))
    		    <h4 class="text-success"> <b> {!! ($oldRecord) ? strtoupper($oldRecord->company_name) : '' !!} </b> </h4> 
    		@else
    		    <h4 class="text-success"> <b> {!! strtoupper($companyName) !!} </b> </h4>
    		@endif
    		
    		@if($hideAddress == 0)
    		    @if($companyAddress == ('defaultAddress'))
    		         <h5 class="text-success"> <b> {!! ($oldRecord) ? strtoupper($oldRecord->address) : '' !!} </b> </h5> 
    		    @else
    		         <h5 class="text-success"> <b> {!! strtoupper($companyAddress) !!} </b> </h5>
    		    @endif 
    		@endif
    		
    		@if($showOnlyTitle1 == 1)
    		    <h5 class="text-success"> <strong>{!! ($title1 == 'Generated' or $title1 == 'date') ? 'Generated: ' . date('d-M-Y') : strtoupper($title1) !!}</strong> </h5>
    		@endif
    		
    		@if($showOnlyTitle2 == 1)
    		    <h6 class="text-success"> {!! ($title2 == 'Generated' or $title2 == 'date') ? 'Generated: ' . date('d-M-Y') : strtoupper($title2) !!} </h6>
    		@endif
	</div>
    </span>
    @if($hideLogos == 0)
    <div align="center" class="col-xs-3">
    	<img width="120" src="{{ ($oldRecord) ? asset('companyLogos/'.$oldRecord->report_logo) : ''}}" width ="120" class="img-responsive">
    </div>
    @endif
</div>



