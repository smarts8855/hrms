      <!--//Alert Modal for Increment/promotion -->
          <div class="modal fade" id="overlayAlert">
            <div class="panel-body">
                            <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-users center white" style="color: white;">
                                   <b> INCREMENT ALERT </b>
                                </i>
                                <div style="border-radius:100px; background:#000; width:30px; padding:1px; height:30px; float: right">
                                    <span class="blink-text text-center" style="color: red; ">
                                        <b><big>{{count($passParameter)}}</big></b>
                                    </span>
                                </div>
                                <br />
                                <div align="left" style="font-size: 13px; margin-top: 5px;"> 
                                  Hey Sir/Ma, <br /> 
                                  Am glad to let you know that you have<br />
                                  <b style="color: white;">
                                    <big>
                                      {{count($passParameter)}}
                                    </big>
                                    staff due for Increment this Month 
                                  </b>
                                  <small>(or prev. Months)</small> of {{date('F')}}. <br />
                                  <small>I have also Notified Record &amp; Variation</small> - Click here to view...
                                </div>
                            </button>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div align="center" class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title text-success" id="myModalLabel">
                                              All Staff due for Increment this Month  <small>(or previous Months)</small> <br />
                                              In {{Session::get('this_division')}} Division
                                             </h4>
                                        </div>
                                        <span>
                                          <div class="modal-body" style="overflow-y: auto; height: 300px;">
                                            <table class="table table-hover table-striped">
                                              <thead>
                                                <tr>
                                                  <th></th>
                                                  <th>FileNo</th>
                                                  <th>Full Name</th>
                                                  <th>Appt. Date</th>
                                                  <th>Old Level</th>
                                                  <th>New Level</th>
                                                </tr>
                                              </thead>
                                              <tbody class="input-sm">
                                              @php $SN = 1; @endphp
                                              @foreach($passParameter as $field)
                                                <tr>
                                                  <td>{{$SN ++}}</td>
                                                  <td>JIPPIS/P/{{$field->fileNo}}</td>
                                                  <td>{{$field->surname .' '. $field->othernames .' '. $field->first_name}}</td>
                                                  <td>{{$field->appointment_date}}</td>
                                                  <td>{{'GL' . $field->grade .' | S '. $field->step}}</td>
                                                  <td>{{'GL' . $field->gradealert .' | S '. $field->stepalert}}</td>
                                                </tr>
                                @endforeach
                                </tbody>
                                
                              </table>
                                          </div>
                                        </span>
                                        <br />
                                        <div class="text-success" style="margin-left: 10px;">
                                            <small>
                                              I have Notified Record &amp; Variation and Estab. concerning this.
                                            </small>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <a href="{{url('/record-variation/view/increment')}}" class="btn btn-primary">
                                              Print All / View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
    <!--//ends here Increment Model-->

@if(((count($passParameter)) > 0) and (Session::get('hideAlert') != 1))

  @section('scripts')
    <!--<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>-->
    <script type="text/javascript">
        $('#overlayAlert').modal('show');
        /*setTimeout(function() {
              $('#overlayAlert').modal('hide');
        }, 50000);*/
    </script>
  @stop

@endif


