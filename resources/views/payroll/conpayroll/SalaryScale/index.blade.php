@extends('layouts.layout')
@section('pageTitle')
@endsection
@section('content')
    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <h4 class="col-md-8 col-md-offset-2" style="text-transform:uppercase;"> View Salary Scale </h4>
            <div class="col-md-12">

                <form method="post" action="{{ url('/consol/salaryScale') }}">
                    {{ csrf_field() }}
                    <div class="row" style="padding: 1px 12px; margin-bottom: 20px;">
                        <div class="col-md-8 col-md-offset-2" style="background: #eee; padding: 10px 15px">
                            <div class="col-md-7" style="padding: 1px;">
                                <div class="form-group">
                                    <label>Select</label>
                                    <select name="court" id="court" class="form-control input-lg"
                                        style="font-size: 13px;">

                                        @foreach ($courts as $court)
                                            @if ($court->id == session('courtID'))
                                                <option value="{{ $court->id }}" selected="selected">
                                                    {{ $court->court_name }}</option>
                                            @else
                                                <option value="{{ $court->id }}">{{ $court->court_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-1" style="padding: 1px;">
                                <div class="form-group" style="padding-top: 23px;">

                                    <input type="submit" name="submit" id="display" class="btn btn-default input-lg"
                                        value="Display" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    @php
                        $ses = session('courtID');
                    @endphp

                    @if (session('courtID') > 0)
                        @foreach ($emptype as $type)
                            <div class="col-md-2" style="margin-top: 5px;">
                                {{-- <a href = "{{ url("/consol/salaryScale/$type->id/$CourtInfo->courtid") }}"
                                    class="btn btn-success" target="_blank" role="button">{{ $type->employmentType }}</a> --}}



                                <a href="{{ url("/consol/salaryScale/{$type->id}/{$CourtInfo->courtid}?employmentType=" . urlencode($type->employmentType)) }}"
                                    class="btn btn-success" target="_blank" role="button">
                                    {{ $type->employmentType }}
                                </a>




                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
