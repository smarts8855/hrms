@php
$g = DB::table('tbl_court')->where('id','=',session('currentCourt'))->first();
@endphp
<h3>{{$g->court_name}}</h3>
