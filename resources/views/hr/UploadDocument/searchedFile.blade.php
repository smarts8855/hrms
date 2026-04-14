@extends('layouts.layout')

@section('pageTitle')
    File Documents For {{$file}}
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>x
                                <th>FILE NO. / NAME</th>
                                <th>FILE DOCUMENT DESCRIPTION</th>
                                <th>VOLUME</th>
                                <th>CATEGORY</th>
                                <th colspan="2" style="text-align: center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $key => $document)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$document->fileNo}}</td>
                                    <td>{{$document->document_description}}</td>
                                    <td>{{$document->documentVolumeID}}</td>
                                    <td>{{$document->category}}</td>
                                    <td><a href="{{url('/edit-document/'.$document->documentID)}}"><button class="btn btn-primary">Edit</button></a></td>
                                    <td><form action="{{url('/remove-document/'.$document->documentID)}}" method="post">
                                        @csrf @method('DELETE')
                                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <em>This File has no Documents</em>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{url('/search-file')}}"><button class="btn btn-primary">Search New File</button></a>
        </div>
    </div>
@endsection
