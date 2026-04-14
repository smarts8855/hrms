@extends('layouts.layout')

@section('pageTitle')
    Edit File Document {{ $getDocument->fileNo }}
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
            </div>
            <div class="box-body">
                <div class="row">

                    @includeIf('Share.message')

                    <div class="col-md-12">
                        <!--2nd col-->
                        <form method="post" action="{{ url('/edit-document/' . $getDocument->documentID) }}">
                            @csrf @method('PUT')
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label for="description">File Document Description</label>
                                        <input type="text" name="fileDescription"
                                            value="{{ $getDocument->document_description }}" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="month">Volume</label>
                                            <select name="volume" id="volume" class="form-control">
                                                <option value="">Select</option>
                                                @if (isset($getVolume) && $getVolume)
                                                    @foreach ($getVolume as $Vol)
                                                        <option value="{{ $Vol->ID }}"
                                                            {{ $Vol->ID == (isset($getDocument) && $getDocument ? $getDocument->volumeID : '') ? 'selected' : '' }}>
                                                            {{ $Vol->volume_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-9">
                                        <div align="right" class="form-group">
                                            <label for="month">&nbsp;</label><br />
                                            <button name="action" class="btn btn-success" type="submit">
                                                Update<i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div><!-- /.col -->

                <a href="{{ url('/document-file-upload') }}"><button type="button" class="btn btn-primary">Back</button></a>
            </div><!-- /.row -->

        </div>
    </div>

@endsection
