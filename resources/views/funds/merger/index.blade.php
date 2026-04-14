  @extends('layouts.layout')
  @section('pageTitle')
      payment
  @endsection
  @section('content')
      <div class="box box-default">
          <div class="box-body box-profile">
              <div class="box-header with-border hidden-print">
                  <h3 class="box-title"><b>@yield('pageTitle')</b>
                  </h3>
              </div>
              <div class="box box-primary">
                  <div class="box-body">
                      <div class="table-responsive" id="tableID">
                          <form method="POST" action="{{ url('payroll-merger') }}">

                              <div class="box-body">
                                  <div class="row">
                                      <div class="col-md-12"><!--1st col-->
                                          @if (count($errors) > 0)
                                              <div class="alert alert-danger alert-dismissible" role="alert">
                                                  <button type="button" class="close" data-dismiss="alert"
                                                      aria-label="Close"><span aria-hidden="true">&times;</span>
                                                  </button>
                                                  <strong>Error!</strong>
                                                  @foreach ($errors->all() as $error)
                                                      <p>{{ $error }}</p>
                                                  @endforeach
                                              </div>
                                          @endif

                                          @if ($message)
                                              <div class="alert alert-success alert-dismissible" role="alert">
                                                  <button type="button" class="close" data-dismiss="alert"
                                                      aria-label="Close"><span aria-hidden="true">&times;</span>
                                                  </button>
                                                  <strong>Success!</strong>
                                                  {{ $message }}
                                              </div>
                                          @endif

                                          @if ($errormessage)
                                              <div class="alert alert-danger alert-dismissible" role="alert">
                                                  <button type="button" class="close" data-dismiss="alert"
                                                      aria-label="Close"><span aria-hidden="true">&times;</span>
                                                  </button>
                                                  <strong>Error!</strong>
                                                  {{ $errormessage }}
                                              </div>
                                          @endif
                                      </div>
                                      {{ csrf_field() }}
                                      <div class="col-md-12">
                                          <div class="row">
                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label> Select Economic Code </label>
                                                      <select name="economic_code" id="section"
                                                          class="form-control input-sm">
                                                          <option value="">Select Type </option>
                                                          <option value="257"
                                                              {{ old('economic_code') == 257 || $economic_code == 257 ? 'selected' : '' }}>
                                                              SALARY
                                                          </option>
                                                          {{-- <option value="73"
                                                              {{ old('economic_code') == 74 || $economic_code == 74 ? 'selected' : '' }}>
                                                              Consolidated</option> --}}

                                                      </select>
                                                  </div>
                                              </div>

                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label> Select a month </label>
                                                      <select name="month" id="section" class="form-control input-sm">
                                                          <option value="">Select Month </option>
                                                          <option value="JANUARY"
                                                              {{ old('month') == 'JANUARY' || $month == 'JANUARY' ? 'selected' : '' }}>
                                                              January
                                                          </option>
                                                          <option value="FEBRUARY"
                                                              {{ old('month') == 'FEBRUARY' || $month == 'FEBRUARY' ? 'selected' : '' }}>
                                                              February</option>
                                                          <option value="MARCH"
                                                              {{ old('month') == 'MARCH' || $month == 'MARCH' ? 'selected' : '' }}>
                                                              March
                                                          </option>
                                                          <option value="APRIL"
                                                              {{ old('month') == 'APRIL' || $month == 'APRIL' ? 'selected' : '' }}>
                                                              April
                                                          </option>
                                                          <option value="MAY"
                                                              {{ old('month') == 'MAY' || $month == 'MAY' ? 'selected' : '' }}>
                                                              May</option>
                                                          <option value="JUNE"
                                                              {{ old('month') == 'JUNE' || $month == 'JUNE' ? 'selected' : '' }}>
                                                              June</option>
                                                          <option value="JULY"
                                                              {{ old('month') == 'JULY' || $month == 'JULY' ? 'selected' : '' }}>
                                                              July</option>
                                                          <option value="AUGUST"
                                                              {{ old('month') == 'AUGUST' || $month == 'AUGUST' ? 'selected' : '' }}>
                                                              August
                                                          </option>
                                                          <option value="SEPTEMBER"
                                                              {{ old('month') == 'SEPTEMBER' || $month == 'SEPTEMBER' ? 'selected' : '' }}>
                                                              September</option>
                                                          <option value="OCTOBER"
                                                              {{ old('month') == 'OCTOBER' || $month == 'OCTOBER' ? 'selected' : '' }}>
                                                              October
                                                          </option>
                                                          <option value="NOVEMBER"
                                                              {{ old('month') == 'NOVEMBER' || $month == 'NOVEMBER' ? 'selected' : '' }}>
                                                              November</option>
                                                          <option value="DECEMBER"
                                                              {{ old('month') == 'DECEMBER' || $month == 'DECEMBER' ? 'selected' : '' }}>
                                                              December</option>
                                                      </select>
                                                  </div>
                                              </div>
                                              {{-- <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label>Select a Year</label>
                                                      <select name="year" id="section" class="form-control input-sm">
                                                          <option value="">Select Year</option>
                                                          <option value="2010"
                                                              {{ old('year') == '2010' || $year == '2010' ? 'selected' : '' }}>
                                                              2010</option>
                                                          <option value="2011"
                                                              {{ old('year') == '2011' || $year == '2011' ? 'selected' : '' }}>
                                                              2011</option>
                                                          <option value="2012"
                                                              {{ old('year') == '2012' || $year == '2012' ? 'selected' : '' }}>
                                                              2012</option>
                                                          <option value="2013"
                                                              {{ old('year') == '2013' || $year == '2013' ? 'selected' : '' }}>
                                                              2013</option>
                                                          <option value="2014"
                                                              {{ old('year') == '2014' || $year == '2014' ? 'selected' : '' }}>
                                                              2014</option>
                                                          <option value="2015"
                                                              {{ old('year') == '2015' || $year == '2015' ? 'selected' : '' }}>
                                                              2015</option>
                                                          <option value="2016"
                                                              {{ old('year') == '2016' || $year == '2016' ? 'selected' : '' }}>
                                                              2016</option>
                                                          <option value="2017"
                                                              {{ old('year') == '2017' || $year == '2017' ? 'selected' : '' }}>
                                                              2017</option>
                                                          <option value="2018"
                                                              {{ old('year') == '2018' || $year == '2018' ? 'selected' : '' }}>
                                                              2018</option>
                                                          <option value="2019"
                                                              {{ old('year') == '2019' || $year == '2019' ? 'selected' : '' }}>
                                                              2019</option>
                                                          <option value="2020"
                                                              {{ old('year') == '2020' || $year == '2020' ? 'selected' : '' }}>
                                                              2020</option>
                                                          <option value="2021"
                                                              {{ old('year') == '2021' || $year == '2021' ? 'selected' : '' }}>
                                                              2021</option>
                                                          <option value="2022"
                                                              {{ old('year') == '2022' || $year == '2022' ? 'selected' : '' }}>
                                                              2022</option>
                                                          <option value="2023"
                                                              {{ old('year') == '2023' || $year == '2023' ? 'selected' : '' }}>
                                                              2023</option>
                                                          <option value="2024"
                                                              {{ old('year') == '2024' || $year == '2024' ? 'selected' : '' }}>
                                                              2024</option>
                                                          <option value="2025"
                                                              {{ old('year') == '2025' || $year == '2025' ? 'selected' : '' }}>
                                                              2025</option>
                                                          <option value="2026"
                                                              {{ old('year') == '2026' || $year == '2026' ? 'selected' : '' }}>
                                                              2026</option>
                                                          <option value="2027"
                                                              {{ old('year') == '2027' || $year == '2027' ? 'selected' : '' }}>
                                                              2027</option>
                                                          <option value="2028"
                                                              {{ old('year') == '2028' || $year == '2028' ? 'selected' : '' }}>
                                                              2028</option>
                                                          <option value="2029"
                                                              {{ old('year') == '2029' || $year == '2029' ? 'selected' : '' }}>
                                                              2029</option>
                                                          <option value="2030"
                                                              {{ old('year') == '2030' || $year == '2030' ? 'selected' : '' }}>
                                                              2030</option>
                                                          <option value="2031"
                                                              {{ old('year') == '2031' || $year == '2031' ? 'selected' : '' }}>
                                                              2031</option>
                                                          <option value="2032"
                                                              {{ old('year') == '2032' || $year == '2032' ? 'selected' : '' }}>
                                                              2032</option>
                                                          <option value="2033"
                                                              {{ old('year') == '2033' || $year == '2033' ? 'selected' : '' }}>
                                                              2033</option>
                                                          <option value="2024"
                                                              {{ old('year') == '2034' || $year == '2034' ? 'selected' : '' }}>
                                                              2034</option>
                                                          <option value="2035"
                                                              {{ old('year') == '2035' || $year == '2035' ? 'selected' : '' }}>
                                                              2035</option>
                                                          <option value="2036"
                                                              {{ old('year') == '2036' || $year == '2036' ? 'selected' : '' }}>
                                                              2036</option>
                                                          <option value="2037"
                                                              {{ old('year') == '2037' || $year == '2037' ? 'selected' : '' }}>
                                                              2037</option>
                                                          <option value="2038"
                                                              {{ old('year') == '2038' || $year == '2038' ? 'selected' : '' }}>
                                                              2038</option>
                                                          <option value="2039"
                                                              {{ old('year') == '2039' || $year == '2039' ? 'selected' : '' }}>
                                                              2039</option>
                                                          <option value="2040"
                                                              {{ old('year') == '2040' || $year == '2040' ? 'selected' : '' }}>
                                                              2040</option>
                                                      </select>
                                                  </div>
                                              </div> --}}

                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for="year">Select a Year</label>
                                                      <select name="year" id="year" class="form-control input-sm">
                                                          <option value="">Select Year</option>
                                                          @for ($y = 2024; $y <= 2040; $y++)
                                                              <option value="{{ $y }}"
                                                                  {{ old('year') == $y || (isset($year) && $year == $y) ? 'selected' : '' }}>
                                                                  {{ $y }}
                                                              </option>
                                                          @endfor
                                                      </select>
                                                  </div>
                                              </div>


                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label> &nbsp; </label>
                                                      <div class="col-12">
                                                          <button type="submit"
                                                              class="btn btn-success btn-sm w-100">Submit</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div><!-- /.col -->
                      </div><!-- /.row -->

                      </form>
                  </div>
              </div>
          </div>
      </div>
      </div>

  @endsection
  @section('styles')
  @endsection
