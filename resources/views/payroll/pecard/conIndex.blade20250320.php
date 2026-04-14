  @extends('layouts.layout')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  @section('pageTitle')
      PE-Card
  @endsection
  @section('content')
      <form method="POST" action="{{ url('/con-pecard/view') }}">
          <div class="box-body">
              <div class="row">
                  <div class="col-md-12"><!--1st col-->
                      @if (count($errors) > 0)
                          <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                      aria-hidden="true">&times;</span>
                              </button>
                              <strong>Error!</strong>
                              @foreach ($errors->all() as $error)
                                  <p>{{ $error }}</p>
                              @endforeach
                          </div>
                      @endif
                      @if (session('message'))
                          <div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                      aria-hidden="true">&times;</span></button>
                              <strong>Success!</strong>
                              {{ session('message') }}
                          </div>
                      @endif
                      @if (session('err'))
                          <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                      aria-hidden="true">&times;</span></button>
                              <strong>Error!</strong>
                              {{ session('err') }}
                          </div>
                      @endif
                  </div>
                  {{ csrf_field() }}
                  <div class="col-md-12">
                      <div class="row">

                          @if ($CourtInfo->courtstatus == 1)
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Select Court</label>
                                      <select name="court" id="court" class="form-control" style="font-size: 13px;">
                                          <option value="">Select Court</option>
                                          @foreach ($courts as $court)
                                              @if ($court->id == session('anycourt'))
                                                  <option value="{{ $court->id }}" selected="selected">
                                                      {{ $court->court_name }}</option>
                                              @else
                                                  <option value="{{ $court->id }}"
                                                      @if (old('court') == $court->id) selected @endif>
                                                      {{ $court->court_name }}</option>
                                              @endif
                                          @endforeach
                                      </select>

                                  </div>
                              </div>
                          @else
                              <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                          @endif

                          @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Select Division</label>
                                      <select name="division" id="division_" class="form-control" style="font-size: 13px;">
                                          <option value="">Select Division</option>
                                          @foreach ($courtDivisions as $divisions)
                                              <option value="{{ $divisions->divisionID }}"
                                                  @if (old('division') == $divisions->divisionID)  @endif>{{ $divisions->division }}
                                              </option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          @else
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Division</label>
                                      <input type="text" class="form-control" id="divisionName" name="divisionName"
                                          value="{{ $curDivision->division }}" readonly>
                                  </div>
                              </div>
                              <input type="hidden" id="division" name="division" value="{{ Auth::user()->divisionID }}">
                              <!--<input type="hidden" id="division" name="division" value="{{ $CourtInfo->divisionid }}">-->
                          @endif


                          @if ($CourtInfo->courtstatus == 1)
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="staff">STAFF NAME</label>
                                      <select name="staffName" class="form-control">
                                          <option>Select Staff</option>
                                          @foreach ($staff as $lists)
                                              <option value="{{ $lists->ID }}"> {{ $lists->surname }}
                                                  {{ $lists->first_name }} {{ $lists->othernames }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          @else
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="division">Select Staff Name</label>
                                      <input type="text" id="user" autocomplete="off" name='staffName'
                                          list="enrolledUsers" class="form-control" onchange="StaffSearchReload()">

                                      <datalist id="enrolledUsers" name="staffName">

                                          @foreach ($staffData as $b)
                                              <option value="{{ $b->ID }}">
                                                  {{ $b->fileNo }}:{{ $b->surname }} {{ $b->first_name }}
                                                  {{ $b->othernames }}
                                              </option>
                                          @endforeach
                                      </datalist>

                                  </div>
                                  @foreach ($staffData as $b)
                                      <input type="hidden" id="id{{ $b->ID }}"
                                          value="{{ $b->fileNo }}:{{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}">
                                  @endforeach
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="userName">Staff Name</label>
                                      <input type="hidden" id="fileNo" name="fileNo">
                                      <input type="text" id="staffname" class="form-control" readonly />
                                  </div>
                              </div>






                          @endif
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Select a Year </label>
                                  <select name="year" id="section" class="form-control">

                                      <option value="">Select Year</option>
                                      @for ($i = 2010; $i <= 2040; $i++)
                                          <option value="{{ $i }}">{{ $i }}</option>
                                      @endfor
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="row">

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label></label>
                                  <div>
                                      <button type="submit" class="btn btn-success pull-right">Display</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          </div>
          </div><!-- /.col -->
          </div><!-- /.row -->
      </form>
  @endsection
  <!--@section('styles')-->

  @section('scripts')
      <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

      <script type="text/javascript">
          (function() {
              $('#user').change(function() {

                  var myuser = $('#user').val();
                  document.getElementById('staffname').value = document.getElementById('id' + myuser).value;
                  $('#fileNo').val(myuser);
              });
          })();
      </script>

      <script type="text/javascript">
          $(document).ready(function() {
              $('#division').change(function() {
                  //alert('ok')
                  var d = 'division';
                  $.ajax({
                      url: murl + '/division/session',
                      type: "post",
                      data: {
                          'division': $('#division').val(),
                          'val': d,
                          '_token': $('input[name=_token]').val()
                      },
                      success: function(data) {
                          console.log(data);
                          location.reload(true);
                      }
                  });
              });
          });

          $(document).ready(function() {
              $('#staffName').change(function() {
                  //alert('ok')
                  var s = 'staff';
                  $.ajax({
                      url: murl + '/division/session',
                      type: "post",
                      data: {
                          'staff': $('#staffName').val(),
                          'val': s,
                          '_token': $('input[name=_token]').val()
                      },
                      success: function(data) {
                          console.log(data);
                          location.reload(true);
                      }
                  });
              });
          });
      </script>

      {{-- ///////////////////////////////////// --}}

      <script type="text/javascript">
          $(document).ready(function() {
              // alert('danger')

              $('select[name="division"]').on('change', function() {
                  var division_id = $(this).val();
                  // alert(division_id)

                  if (division_id) {
                      $.ajax({
                          url: "{{ url('/division/staff/ajax') }}/" + division_id,
                          type: "GET",
                          dataType: "json",
                          success: function(data) {
                              console.log(1111111111, data);
                              var d = $('select[name="staffName"]').html('');
                              $.each(data, function(key, value) {
                                  $('select[name="staffName"]').append(`<option value=${value.ID}>
                                ${value.surname}  ${value.first_name}  ${value.othernames}  </option>`);
                              });
                          }
                      });
                  } else {
                      alert('danger')
                  }

              }); // end sub category

          });
      </script>
      {{-- ///////////////////////////////////// --}}
  @endsection
