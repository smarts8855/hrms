@extends('layouts.layout')

@section('pageTitle')
    TRAINING REPORT PAGE
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
            </div>
            <div id="report">
            <div class="box-body">
                <div class="row">
                    <div style="border-bottom: 1px solid black;">
                        <div class="text-center" style="font-weight: bold;"><h4>Report for {{$title->title}} {{$title->date}} </h4> </div>
                        <div class="text-center"> <h5 style="font-weight: bold;"><em>Date of Training: {{$title->training_date}}</em></h5></div>
                        <div class="text-center"> <h5 style="font-weight: bold;"><em>Date Concluded: {{$title->date_concluded}}</em></h5></div>

                    </div>
                    
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <em class="text-danger"></em>
                    <table class="table table-bordered table-striped" id="holidayTable" width="100%">
                        <div class="text-center">SELECTED STAFF PARTICIPANTS FOR TRAINING</div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>STAFF</th>
                                <th>DEPARTMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($staffs as $key => $staff)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$staff->sname. ' '.$staff->fname.' '.$staff->others}}</td>
                                    <td>{{$staff->dept}}</td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                </div>
            </div>

            <div class="consultant">
                @if ($title->consultant != '')
                    CONSULTANT: @php echo strtoupper($title->consultant); @endphp
                @else{
                    <em>No Consultant</em>
                }
                @endif
            </div>
        </div>

        </div>
    </div>

    <a href="{{url('/search-training-report')}}"><button type="button" class="btn btn-primary">Back to report</button></a>
    <button class="btn btn-primary" type="button" onclick="printReport()">Print Report</button>

@endsection
<script>
    function printReport(){
  
      var divToPrint = document.querySelector('#report');
      var htmlToPrint = '' +
          '<style type="text/css">' +
          'table th, table td {' +
          'border:1px solid #000;' +
          'padding:0.5em;' +
          '}' +
          '</style>';
      htmlToPrint += divToPrint.outerHTML;
      newWin = window.open("");
      newWin.document.write(htmlToPrint);
      newWin.print();
      newWin.close();
    }
  </script>