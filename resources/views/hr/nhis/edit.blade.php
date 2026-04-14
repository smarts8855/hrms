  @extends('layouts.layout')
  @section('pageTitle')
      E-payment
  @endsection
  @section('content')

      <div class="box-body" style="background:#fff;">
          <div class="row">
              <div class="col-md-12">
                  <!--1st col-->
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
              </div>

              <div class="col-md-12">
                  <h4 class="" style="text-transform:uppercase">NHIS Short Pay and Over Pay
                  </h4>

                  <form method="POST" action="{{ url('nhis-balance/edit') }}">
                      {{ csrf_field() }}
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

                          @if ($CourtInfo->divisionstatus == 1)
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Select Division</label>
                                      <select name="division" id="division_" class="form-control" style="font-size: 13px;">
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
                              <input type="hidden" id="division" name="division" value="{{ $CourtInfo->divisionid }}">
                          @endif

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Select a Year</label>
                                  <select name="year" id="section" class="form-control">
                                      <option value="">Select Year</option>

                                      @for ($i = 2011; $i <= 2040; $i++)
                                          <option value="{{ $i }}"
                                              @if ($nhis->year == $i) selected @endif>{{ $i }}
                                          </option>
                                      @endfor
                                  </select>
                                  <input type="hidden" id="id" name="id" value="{{ $nhis->id }}">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label> Select a Month </label>
                                  <select name="month" id="section" class="form-control">
                                      <option value="">Select Month </option>
                                      <option value="JANUARY" @if ($nhis->month == 'JANUARY') selected @endif>January
                                      </option>
                                      <option value="FEBRUARY" @if ($nhis->month == 'FEBRUARY') selected @endif>February
                                      </option>
                                      <option value="MARCH" @if ($nhis->month == 'MARCH') selected @endif>March
                                      </option>
                                      <option value="APRIL" @if ($nhis->month == 'APRIL') selected @endif>April
                                      </option>
                                      <option value="MAY" @if ($nhis->month == 'MAY') selected @endif>May</option>
                                      <option value="JUNE" @if ($nhis->month == 'JUNE') selected @endif>June
                                      </option>
                                      <option value="JULY" @if ($nhis->month == 'JULY') selected @endif>July
                                      </option>
                                      <option value="AUGUST" @if ($nhis->month == 'AUGUST') selected @endif>August
                                      </option>
                                      <option value="SEPTEMBER" @if ($nhis->month == 'SEPTEMBER') selected @endif>
                                          September</option>
                                      <option value="OCTOBER" @if ($nhis->month == 'OCTOBER') selected @endif>October
                                      </option>
                                      <option value="NOVEMBER" @if ($nhis->month == 'NOVEMBER') selected @endif>November
                                      </option>
                                      <option value="DECEMBER" @if ($nhis->month == 'DECEMBER') selected @endif>December
                                      </option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="bankName">Amount</label>
                                  <input type="text" name="amount" class="form-control" value="{{ $nhis->amount }}">
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Purpose</label>
                                  <select name="purpose" class="form-control">
                                      <option value="">Select Purpose</option>
                                      <option value="Short Pay" @if ($nhis->purpose == 'Short Pay') selected @endif>Short
                                          Pay</option>
                                      <option value="Over Pay" @if ($nhis->purpose == 'Over Pay') selected @endif>Over Pay
                                      </option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <div>
                                      <button type="submit" class="btn btn-success btn-sm pull-right">Updated</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>

              </div>

              <div class="row">
                  <div class="col-md-12">

                      <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th>SN</th>
                                  <th>Month</th>

                                  <th>Year</th>
                                  <th>Amount</th>
                                  <th>Purpose</th>
                                  <th>Edit</th>

                          </thead>
                          <tbody>
                              @php $k= 1; @endphp
                              @foreach ($nhisBal as $list)
                                  <tr>
                                      <td>{{ $k++ }}</td>
                                      <td>{{ $list->month }}</td>
                                      <td>{{ $list->year }}</td>
                                      <td>{{ $list->amount }}</td>
                                      <td>
                                          {{ $list->purpose }}
                                      </td>
                                      <td><a href="{{ url('/nhis-balance/edit/' . $list->id) }}"><i
                                                  class="fa fa-edit"></i></a></td>

                                  </tr>
                              @endforeach
                          </tbody>
                      </table>


                  </div>
              </div>
          </div>
      </div><!-- /.col -->
      </div><!-- /.row -->

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
          });
      </script>
  @endsection
