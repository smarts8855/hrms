{{-- <form action="{{url('/documentation-nextofkin')}}" method="POST">
		{{csrf_field()}}
			<div class="tab-pane" role="tabpanel" id="step3">
				<div class="col-md-offset-0">
					<h3 class="text-success text-center">
						<i class="glyphicon glyphicon-envelope"></i> <b>Next of Kin</b>
					</h3>
					<div align="right" style="margin-top: -35px;">
						Field with <span class="text-danger"><big>*</big></span> is important
					</div>
				</div>
				<br />
				<p>
				@php $i=1; @endphp
				@foreach($nextOfKins as $nextOfKin)
					<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="row">
							<div class="col-md-6">
									<div class="form-group">
									<label>Full Name <span class="text-danger"><big>*</big></span></label>

										<input type="text" name="fullName[{{$i}}]" id="fullName" class="form-control input-lg" value="{{$nextOfKin->fullname}}" required />

								</div>
							</div>

							<div class="col-md-6">
									<div class="form-group">
										<label>Phone Number <span class="text-danger"><big>*</big></span></label>

												<input type="number" name="phoneNumber[{{$i}}]" id="phoneNumber" class="form-control input-lg" value="{{$nextOfKin->phoneno}}" required/>


									</div>
								</div>

						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Resident Address</label>

										<textarea name="physicalAddress[{{$i}}]" id="physicalAddress" class="form-control input-lg">{{$nextOfKin->address}}</textarea>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Relationship <span class="text-danger"><big>*</big></span></label>

										<select type="text" id="relationship" name="relationship[{{$i}}]"  class="formex form-control input-lg"  required>
											<option value="">Select</option>
											@foreach($relationship as $b)
												<option value="{{$b->relationship}}" {{ ($nextOfKin->relationship == $b->relationship || old("relationship") == $b->relationship )? "selected" :"" }}>{{$b->relationship}} </option>
													@endforeach
											</select>


								</div>
							</div>
						</div><!--//row 2-->
					</div>
				</div>
				@php $i+=1; @endphp
				@endforeach
				</p>
				<hr />
				<div align="center">
					<ul class="list-inline">
						<li><a href="{{url('/documentation-marital-status')}}" class="btn btn-default">Previous</a></li>
						<li><button type="submit" class="btn btn-primary">Save and continue</button></li>
					</ul>
				</div>
			</div>
</form> --}}

<style>
.card-panel {
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

.card-header {
    padding: 15px;
    border-bottom: 1px solid #eee;
    /* background: #f9f9f9; */
}

.card-header h3 {
    margin: 0;
    font-weight: bold;
    color: #337ab7;
}

.card-body {
    padding: 20px;
}

.section-note {
    text-align: right;
    font-size: 13px;
    margin-top: -10px;
}
</style>

<form action="{{ url('/documentation-nextofkin') }}" method="POST">
    {{ csrf_field() }}

    <div class="tab-pane" role="tabpanel" id="step3">

        <!-- CARD START -->
        <div class="col-md-12  card-panel">

            <!-- HEADER -->
            <div class="card-header text-center">
                <h3>
                    <i class="glyphicon glyphicon-user"></i> Next of Kin
                </h3>
            </div>

            {{-- <div class="section-note">
                Field with <span class="text-danger"><b>*</b></span> is important
            </div> --}}

            <!-- FORM INSIDE CARD -->
            <div class="card-body">

                @php $i = 1; @endphp

                @foreach($nextOfKins as $nextOfKin)

                    <!-- ROW: 4 COLUMNS -->
                    <div class="row">

                        <div class="col-md-3">
                            <label>Full Name </label>
                            <input type="text"
                                   name="fullName[{{ $i }}]"
                                   class="form-control input-sm"
                                   value="{{ $nextOfKin->fullname }}"
                                   required>
                        </div>

                        <div class="col-md-3">
                            <label>Phone Number </label>
                            <input type="number"
                                   name="phoneNumber[{{ $i }}]"
                                   class="form-control input-sm"
                                   value="{{ $nextOfKin->phoneno }}"
                                   required>
                        </div>

                        <div class="col-md-3">
                            <label>Relationship </label>
                            <select name="relationship[{{ $i }}]"
                                    class="form-control input-sm"
                                    required>
                                <option value="">Select</option>
                                @foreach($relationship as $b)
                                    <option value="{{ $b->relationship }}"
                                        {{ $nextOfKin->relationship == $b->relationship ? 'selected' : '' }}>
                                        {{ $b->relationship }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Resident Address</label>
                            <textarea name="physicalAddress[{{ $i }}]"
                                      class="form-control input-sm"
                                      rows="1">{{ $nextOfKin->address }}</textarea>
                        </div>

                    </div>

                    <hr>

                    @php $i++ @endphp
                @endforeach

                <!-- BUTTONS INSIDE CARD -->
                <div class="text-center" style="margin-top: 20px;">
                    <ul class="list-inline">
                        <li>
                            <a href="{{ url('/documentation-marital-status') }}" class="btn btn-default">
                                Previous
                            </a>
                        </li>
                        <li>
                            <button type="submit" class="btn btn-primary">
                                Save and continue
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
            <!-- END CARD BODY -->

        </div>
        <!-- END CARD -->

    </div>
</form>

