  @extends('layouts.layout')
  @section('pageTitle')
      NHIS
  @endsection
  @section('content')

      <div class="box box-default" style="border: none;">

          <div class="box-header with-border hidden-print">
              <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                      id='processing'><strong><em>NHIS Account.</em></strong></span></h3>
          </div>
          <div class="box box-success">
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
                          @if (session('msg'))
                              <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                          aria-hidden="true">&times;</span></button>
                                  <strong>Success!</strong>
                                  {{ session('msg') }}
                              </div>
                          @endif
                      </div>

                      <div class="col-md-12">

                          <form method="POST" action="{{ url('nhis-account/create') }}">
                              {{ csrf_field() }}
                              <div class="row">
                                  <div class="col-md-9">
                                      <div class="form-group">
                                          <label for="bankName">NHIS Account Number</label>
                                          <input type="text" name="account" class="form-control"
                                              value="{{ $nhisAcct->accountNo ?? ''}}">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="bankName" style="visibility: hidden">NHIS Account Number</label>
                                          <button type="submit"
                                              class="btn btn-success form-control btn-sm pull-">Update</button>
                                      </div>
                                  </div>
                              </div>
                          </form>

                      </div>

                      <div class="row">
                          <div class="col-md-12" style="margin-top:60px;">



                          </div>
                      </div>
                  </div>
              </div>
          </div>
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
