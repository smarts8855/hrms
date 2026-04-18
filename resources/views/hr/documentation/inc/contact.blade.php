<style>
    .card-panel {
        border: 1px solid #337ab7;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        background: #fff;
    }

    .card-panel .card-header {
        padding: 12px;
        /* border-bottom: 1px solid #eee; */
        background-color: #337ab7;
        color: #fff;
    }

    .card-title {
        margin: 0;
        text-align: center;
        color: #fff;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }
</style>

{{-- <style>
    .card-panel {
        border: 1px solid #337ab7;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        background: #fff;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-panel .card-header {
        background-color: #337ab7;
        color: #fff;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .card-panel .card-body {
        padding: 15px;
    }

    /* Optional: hover effect */
    .card-panel:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        transition: 0.3s;
    }
</style> --}}

<div class="card-panel">

    <!-- HEADER -->
    <div class="card-header">
        <h3 class="card-title">
            <i class="glyphicon glyphicon-envelope"></i>
            Contact Information
        </h3>
        {{-- <div class="text-right text-danger" style="margin-top:-25px;">
            Field with <big>*</big> is important
        </div> --}}
    </div>

    <div class="card-body">

        <form action="{{ url('/documentation-contact') }}" method="POST">
            {{ csrf_field() }}

            <!-- ROW 1 -->
            <div class="row">

                <div class="col-md-6">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control input-md"
                        value="{{ $staffInfo->email ?? ($staffCandidateInfo->email ?? old('email')) }}" required>
                </div>

                <div class="col-md-6">
                    <label>Alternate Email</label>
                    <input type="email" name="alternateEmail" class="form-control input-md"
                        value="{{ $staffInfo->alternate_email ?? old('alternateEmail') }}">
                </div>

            </div>

            <br>

            <!-- ROW 2 -->
            <div class="row">

                <div class="col-md-6">
                    <label>Phone Number *</label>
                    <input type="number" name="phone" class="form-control input-md"
                        value="{{ $staffInfo->phone ?? ($staffCandidateInfo->phoneNo ?? old('phone')) }}" required>
                </div>

                <div class="col-md-6">
                    <label>Alternate Phone</label>
                    <input type="number" name="alternativePhone" class="form-control input-md"
                        value="{{ $staffInfo->alternate_phone ?? old('alternativePhone') }}">
                </div>

            </div>

            <br>

            <!-- ROW 3 -->
            <div class="row">

                <div class="col-md-12">
                    <label>Contact Address *</label>
                    <textarea name="physicalAddress" class="form-control input-md" required>{{ $staffInfo->home_address ?? old('physicalAddress') }}</textarea>
                </div>

            </div>

            <br>

            <!-- BUTTONS -->
            <div class="text-center">

                <a href="{{ route('getBasicInfo') }}"
                    onclick="event.preventDefault(); document.getElementById('basicinfo-form').submit();"
                    class="btn btn-default">
                    Previous
                </a>

                <form id="basicinfo-form" action="{{ route('getBasicInfo') }}" method="POST" style="display:none;">
                    @csrf
                </form>

                <button type="submit" class="btn btn-primary">
                    Save and Continue
                </button>

            </div>

        </form>

    </div>
</div>
