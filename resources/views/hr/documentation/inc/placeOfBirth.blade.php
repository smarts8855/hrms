<style>
    .card-panel {
         border: 1px solid #337ab7;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        background: #fff;
    }

    .card-header {
        padding: 12px;
        border-bottom: 1px solid #eee;
        /* background: #f9f9f9; */
        background-color: #337ab7;
    }

    .card-title {
        text-align: center;
        font-weight: bold;
        color: #fff;
        margin: 0;
    }

    .card-body {
        padding: 20px;
    }
</style>

<div class="card-panel">

    <!-- HEADER -->
    <div class="card-header">
        <h3 class="card-title">
            <i class="glyphicon glyphicon-map-marker"></i>
            State of Origin
        </h3>


    </div>

    <div class="card-body">

        <form action="{{ url('/documentation-placeofbirth') }}" method="POST">
            {{ csrf_field() }}

            <!-- ROW 1 -->
            <div class="row">

                <div class="col-md-6">
                    <label>State of Origin *</label>

                    {{-- <select name="state" id="states" class="form-control input-md" required>
                        <option value="">Select State</option>
                        @foreach ($StateList as $b)
                            <option value="{{ $b->StateID }}"
                                {{ ($staffInfo->stateID ?? old('state')) == $b->StateID ? 'selected' : '' }}>
                                {{ $b->State }}
                            </option>
                        @endforeach
                    </select> --}}

                    @if ($staffInfo !== '')
                        <select type="text" id="states" name="state" class="formex form-control input-md"
                            required>
                            <option value="">Select State</option>
                            @foreach ($StateList as $b)
                                <option value="{{ $b->StateID }}"
                                    {{ $staffInfo->stateID == $b->StateID || old('state') == $b->StateID ? 'selected' : '' }}>
                                    {{ $b->State }} </option>
                            @endforeach
                        </select>
                    @else
                        <select type="text" id="states" name="state" class="formex form-control input-lg"
                            required>
                            <option value="">Select State</option>
                            <option value="">Select State</option>
                            @foreach ($StateList as $b)
                                <option value="{{ $b->StateID }}" {{ old('state') == $b->StateID ? 'selected' : '' }}>
                                    {{ $b->State }}
                                </option>
                            @endforeach
                        </select>


                    @endif

                </div>

                <div class="col-md-6">
                    <label>L.G.A *</label>

                    {{-- <select name="lga" id="lga" class="form-control input-md" required>
                        @if ($staffInfo != '')
                            @foreach ($Lga as $l)
                                <option value="{{ $l->lgaId }}"
                                    {{ $staffInfo->lgaID == $l->lgaId ? 'selected' : '' }}>
                                    {{ $l->lga }}
                                </option>
                            @endforeach
                        @endif
                    </select> --}}

                    @if ($staffInfo !== '')
                        <select type="text" id="lga" name="lga" class="form-control input-md formex"
                            required>

                            @foreach ($Lga as $l)
                                <option value="{{ $l->lgaId }}"
                                    {{ $staffInfo->lgaID == $l->lgaId || old('lga') == $l->lgaId ? 'selected' : '' }}>
                                    {{ $l->lga }} </option>
                            @endforeach
                        </select>
                    @else
                        <select type="text" id="lga" name="lga" class="form-control input-lg formex">


                        </select>
                    @endif

                </div>

            </div>

            <br>

            <!-- ROW 2 -->
            <div class="row">

                <div class="col-md-12">
                    <label>Contact Address *</label>

                    <textarea name="address" class="form-control input-md" required>{{ $staffInfo->permanent_addr ?? old('address') }}</textarea>

                </div>

            </div>

            <br>

            <!-- BUTTONS -->
            <div class="text-center">

                <a href="{{ url('/documentation-contact') }}" class="btn btn-default">
                    Previous
                </a>

                <button type="submit" class="btn btn-primary">
                    Save and Continue
                </button>

            </div>

        </form>

    </div>
</div>
