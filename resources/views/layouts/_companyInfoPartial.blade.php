@php
$g = DB::table('tbl_court')->where('id','=',9)->first();
@endphp
<h3>{{$g->court_name}}</h3>
