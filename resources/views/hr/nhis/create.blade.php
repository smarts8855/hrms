  @extends('layouts.layout')
  @section('pageTitle')
      NHIS
  @endsection
  @section('content')

      <div class="box box-default">
          <div class="box-body box-profile">
              <div class="box-header with-border hidden-print">
                  <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                          id='processing'><strong><em>NHIS Balance.</em></strong></span></h3>
              </div>

              <div class="box box-success">
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-12">
                              @includeIf('hr.Share.message')
                              <form method="POST" action="{{ url('nhis-balance/create') }}">
                                  {{ csrf_field() }}
                                  <div class="row">

                                      @if ($CourtInfo->courtstatus == 1)
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>Select Court</label>
                                                  <select name="court" id="court" class="form-control"
                                                      style="font-size: 13px;">
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
                                          <input type="hidden" id="court" name="court"
                                              value="{{ $CourtInfo->courtid }}">
                                      @endif

                                      @if ($CourtInfo->divisionstatus == 1)
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label>Select Division</label>
                                                  <select name="division" id="division_" class="form-control"
                                                      style="font-size: 13px;">
                                                      <option value="">Select Division</option>
                                                      @foreach ($courtDivisions as $divisions)
                                                          <option value="{{ $divisions->divisionID }}"
                                                              @if (old('division') == $divisions->divisionID) selected @endif>
                                                              {{ $divisions->division }}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      @else
                                          <input type="hidden" id="division" name="division"
                                              value="{{ $CourtInfo->divisionid }}">
                                      @endif

                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Select a Year</label>
                                              <select name="year" id="section" class="form-control">
                                                  <option value="">Select Year</option>
                                                  @for ($i = 2011; $i <= 2040; $i++)
                                                      <option value="{{ $i }}"
                                                          @if (old('year') == $i) selected @endif>
                                                          {{ $i }}
                                                      </option>
                                                  @endfor
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label> Select a Month </label>
                                              <select name="month" id="section" class="form-control">
                                                  <option value="">Select Month </option>
                                                  <option value="JANUARY" @if (old('month') == 'JANUARY') selected @endif>
                                                      January
                                                  </option>
                                                  <option value="FEBRUARY"
                                                      @if (old('month') == 'FEBRUARY') selected @endif>
                                                      February
                                                  </option>
                                                  <option value="MARCH" @if (old('month') == 'MARCH') selected @endif>
                                                      March
                                                  </option>
                                                  <option value="APRIL" @if (old('month') == 'APRIL') selected @endif>
                                                      April
                                                  </option>
                                                  <option value="MAY" @if (old('month') == 'MAY') selected @endif>
                                                      May
                                                  </option>
                                                  <option value="JUNE" @if (old('month') == 'JUNE') selected @endif>
                                                      June
                                                  </option>
                                                  <option value="JULY" @if (old('month') == 'JULY') selected @endif>
                                                      July
                                                  </option>
                                                  <option value="AUGUST"
                                                      @if (old('month') == 'AUGUST') selected @endif>
                                                      August
                                                  </option>
                                                  <option value="SEPTEMBER"
                                                      @if (old('month') == 'SEPTEMBER') selected @endif>
                                                      September</option>
                                                  <option value="OCTOBER"
                                                      @if (old('month') == 'OCTOBER') selected @endif>
                                                      October
                                                  </option>
                                                  <option value="NOVEMBER"
                                                      @if (old('month') == 'NOVEMBER') selected @endif>
                                                      November
                                                  </option>
                                                  <option value="DECEMBER"
                                                      @if (old('month') == 'DECEMBER') selected @endif>
                                                      December
                                                  </option>
                                              </select>
                                          </div>
                                      </div>

                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="bankName">Amount</label>
                                              <input type="text" name="amount" class="form-control"
                                                  value="{{ old('amount') }}">
                                          </div>
                                      </div>

                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Purpose</label>
                                              <select name="purpose" class="form-control">
                                                  <option value="">Select Purpose</option>
                                                  <option value="Short Pay">Short Pay</option>
                                                  <option value="Over Pay">Over Pay</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <div>
                                                  <button type="submit"
                                                      class="btn btn-success btn-sm pull-right">Add</button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <div class="box box-default">
          <div class="box-body box-profile">
              <div class="box-header with-border">
                  <h4 class="box-title text-uppercase">
                      NHIS Short Pay and Over Pay
                  </h4>
              </div>
              <div class="box box-primary">

                  <div class="box-body">
                      <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                          <table class="table table-bordered table-striped table-highlight">
                              <thead>
                                  <tr>
                                      <th>SN</th>
                                      <th>MONTH</th>

                                      <th>YEAR</th>
                                      <th>AMOUNT</th>
                                      <th>PURPOSE</th>
                                      <th>EDIT</th>

                              </thead>
                              <tbody>
                                  @php $k= 1; @endphp
                                  @foreach ($nhis as $list)
                                      <tr>
                                          <td>{{ $k++ }}</td>
                                          <td>{{ $list->month }}</td>
                                          <td>{{ $list->year }}</td>
                                          <td>{{ $list->amount }}</td>
                                          <td>
                                              {{ $list->purpose }}
                                          </td>
                                          {{-- <td><a href="{{ url('/nhis-balance/edit/'.$list->id) }}" ><i class="fa fa-edit"></i></a></td> --}}
                                          <td><button class="btn editBtn btn-primary btn-sm" data-toggle="modal"
                                                  data-target="#editModal" month="{{ $list->month }}"
                                                  year="{{ $list->year }}" amount="{{ $list->amount }}"
                                                  purpose="{{ $list->purpose }}" listId="{{ $list->id }}"><i
                                                      class="fa fa-edit"></i> Edit</button></td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>

                          <!--EDIT Modal -->
                          <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                              aria-labelledby="editModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header" style="background-color: green">
                                          <h4 class="modal-title" id="exampleModalLabel">Edit NHIS Short Pay and Over Pay
                                          </h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <form action="{{ route('nhisBalance.edit') }}" method="post">
                                          @csrf

                                          <div class="modal-body">
                                              <input type="hidden" name="id" id="listId">
                                              <div class="row">
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label for="editYear">Select a Year</label>
                                                          <select name="year" id="editYear" class="form-control">

                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label for="editMonth">Select a Month</label>
                                                          <select name="month" id="editMonth" class="form-control">

                                                          </select>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="row">
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label for="editAmount">Amount</label>
                                                          <input type="number" name="amount" id="editAmount"
                                                              class="form-control">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label for="editPurpose">Purpose</label>
                                                          <select name="purpose" id="editPurpose" class="form-control">

                                                          </select>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary"
                                                  data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-success">Save changes</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                          {{-- EDIT MODEL END --}}
                      </div>
                  </div>
              </div>
          </div>
      </div>

  @endsection

  @section('styles')
  @endsection

  @section('scripts')
      <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

      <script type="text/javascript">
          $(document).ready(function() {

              $("#court").on('change', function(e) {
                  e.preventDefault();
                  var id = $(this).val();
                  //alert(id);
                  $token = $("input[name='_token']").val();
                  $.ajax({
                      headers: {
                          'X-CSRF-TOKEN': $token
                      },
                      url: murl + '/session/court',

                      type: "post",
                      data: {
                          'courtID': id
                      },
                      success: function(data) {
                          location.reload(true);
                          //console.log(data);
                      }
                  });

              });

              //When edit button is clicked
              $(".editBtn").click(function(e) {
                  e.preventDefault();

                  var year = $(this).attr('year');
                  var month = $(this).attr('month');
                  var amount = $(this).attr('amount');
                  var purpose = $(this).attr('purpose');
                  var id = $(this).attr('listId');

                  //setting the value for hidden value
                  $("#listId").val(id);

                  //setting year options\\
                  $("#editYear option").remove();

                  for (var i = 2011; i <= 2040; i++) {
                      var opt = "<option value='" + i + "'" + (i == year ? 'selected' : '') + ">" + i +
                          "</option>";
                      $("#editYear").append(opt);
                  }

                  //setting the month options\\
                  $("#editMonth option").remove();

                  let months = [
                      'JANUARY', 'FEBURARY', 'MARCH', 'APRIL', 'MAY', 'JUNE',
                      'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'
                  ];

                  for (var i = 0; i < months.length; i++) {
                      var monthOpt = "<option value='" + months[i] + "'" + (months[i] == month ? 'selected' :
                          '') + ">" + months[i] + "</option>";
                      $("#editMonth").append(monthOpt);
                  }

                  //setting the amount value\\
                  $("#editAmount").val(amount);

                  //setting the purpose options\\
                  $("#editPurpose option").remove();

                  if (purpose == 'Short Pay') {
                      var purposeOptions = "<option value='Short Pay' selected>Short Pay</option>" +
                          "<option value='Over Pay'>Over Pay</option>";
                  } else if (purpose == 'Over Pay') {
                      var purposeOptions = "<option value='Over Pay' selected>Over Pay</option>" +
                          "<option value='Short Pay'>Short Pay</option>";
                  }

                  $("#editPurpose").append(purposeOptions);
              });
          });
      </script>
  @endsection
