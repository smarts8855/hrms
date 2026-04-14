@extends('layouts.layout')
@section('pageTitle')
    Notifications
@endsection

@section('content')
    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:10px 20px;">
            <div class="row">
                <div align="center">
                    <h3>Notifications</h3>
                </div>
                <hr />
                @includeIf('Share.message')


            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sender</th>
                            <th scope="col">Message</th>
                            <th scope="col">Time</th>
                            <th scope="col" colspan="2" class="text-center">Actions</th>
                        </tr>
                    </thead>


                    @php $i = 1; @endphp
                    @foreach (auth()->user()->notifications as $value)
                        <tbody>
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>{{ $value->data['user']['name'] }}</td>
                                <td>{{ $value->data['msg'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->created_at)->isoFormat('D MMMM Y H:i:s A') }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($value->end)->isoFormat('D MMMM Y') }}</td> --}}
                                <td onclick="markAsRead('{{ $value->id }}')"><a href="{{$value->data['url']}}" class="btn btn-success"> <i
                                    class="fa fa-eye"></a></td>
                                <td>

                                </td>
                            </tr>
                        </tbody>

                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript">
        < script src = "{{ asset('assets/js/jquery-ui.min.js') }}" >
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </script>
    <script>
        // function myFunction() {
        //   var txt;
        //   if (confirm("Press a button!")) {
        //     txt = "You pressed OK!";
        //   } else {
        //     txt = "You pressed Cancel!";
        //   }
        //   document.getElementById("demo").innerHTML = txt;
        // }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection