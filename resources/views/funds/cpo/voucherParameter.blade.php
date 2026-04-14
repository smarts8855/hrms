@extends('layouts.layout')

@section('pageTitle')
    Voucher Parameters
@endsection


@section('styles')
<style>
    .row-space {
        margin-bottom: 20px;
    }

    .section-card {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 25px;
        background: #fff;
        border-radius: 4px;
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 16px;
        color: #2c3e50;
    }
</style>
@endsection


@section('content')

<div class="box box-default">
<div class="box-header with-border">

<h3>Voucher Parameters Setup</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('voucher.parameters.store') }}">
@csrf


{{-- ===================== CJN ===================== --}}
<div class="section-card">
    <div class="section-title">CJN</div>

    <input type="hidden" name="sections[0][employee_type]" value="2">
    <input type="hidden" name="sections[0][rows][0][gradelevel]" value="2">
    <input type="hidden" name="sections[0][rows][0][step]" value="1">
    <input type="hidden" name="sections[0][hr_employment_type]" value="1">

    <div class="row row-space">
        <div class="col-md-6 form-group">
            <label>Amount</label>
            <input type="text" name="sections[0][rows][0][totalamount]"
                   class="form-control amount-field"
                   placeholder="Enter Amount" required>
        </div>
    </div>
</div>


{{-- ===================== JUSTICES ===================== --}}
<div class="section-card">
    <div class="section-title">Justices</div>

    <input type="hidden" name="sections[1][employee_type]" value="2">
    <input type="hidden" name="sections[1][rows][0][gradelevel]" value="1">
    <input type="hidden" name="sections[1][rows][0][step]" value="1">
    <input type="hidden" name="sections[1][hr_employment_type]" value="1">

    <div class="row row-space">
        <div class="col-md-6 form-group">
            <label>Amount</label>
            <input type="text" name="sections[1][rows][0][totalamount]"
                   class="form-control amount-field"
                   placeholder="Enter Amount" required>
        </div>
    </div>
</div>


{{-- ===================== CHIEF REGISTRAR ===================== --}}
<div class="section-card">
    <div class="section-title">Chief Registrar</div>

    <input type="hidden" name="sections[2][employee_type]" value="6">
    <input type="hidden" name="sections[2][rows][0][gradelevel]" value="17">
    <input type="hidden" name="sections[2][rows][0][step]" value="10">
    <input type="hidden" name="sections[2][hr_employment_type]" value="1">

    <div class="row row-space">
        <div class="col-md-6 form-group">
            <label>Amount</label>
            <input type="text" name="sections[2][rows][0][totalamount]"
                   class="form-control amount-field"
                   placeholder="Enter Amount" required>
        </div>
    </div>
</div>


{{-- ===================== SPECIAL ASSISTANT ===================== --}}
<div class="section-card">
    <div class="section-title">Special Assistant</div>

    <input type="hidden" name="sections[3][employee_type]" value="7">
    <input type="hidden" name="sections[3][rows][0][gradelevel]" value="1">
    <input type="hidden" name="sections[3][rows][0][step]" value="1">
    <input type="hidden" name="sections[3][hr_employment_type]" value="1">

    <div class="row row-space">
        <div class="col-md-6 form-group">
            <label>Amount</label>
            <input type="text" name="sections[3][rows][0][totalamount]"
                   class="form-control amount-field"
                   placeholder="Enter Amount" required>
        </div>
    </div>
</div>


{{-- ===================== PERMANENT STAFF ===================== --}}
<div class="section-card">
    <div class="section-title">Permanent Staff</div>

    <input type="hidden" name="sections[4][employee_type]" value="1">
    <input type="hidden" name="sections[4][hr_employment_type]" value="1">

    <div id="permanentSection">

        <div class="row row-space">
            <div class="col-md-5 form-group">
                <label>Grade (Maximum)</label>
                <select name="sections[4][rows][0][gradelevel]" class="form-control">
                    @foreach($grades as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5 form-group">
                <label>Amount</label>
                <input type="text"
                       name="sections[4][rows][0][totalamount]"
                       class="form-control amount-field"
                       placeholder="Enter Amount">
            </div>

            <div class="col-md-2 form-group">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-success addPermanent btn-block">Add</button>
            </div>
        </div>

    </div>
</div>


{{-- ===================== CONTRACT STAFF ===================== --}}
<div class="section-card">
    <div class="section-title">Contract Staff</div>

    <input type="hidden" name="sections[5][employee_type]" value="1">
    <input type="hidden" name="sections[5][hr_employment_type]" value="2">

    <div id="contractSection">

        <div class="row row-space">
            <div class="col-md-5 form-group">
                <label>Grade (Maximum)</label>
                <select name="sections[5][rows][0][gradelevel]" class="form-control">
                    @foreach($grades as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5 form-group">
                <label>Amount</label>
                <input type="text"
                       name="sections[5][rows][0][totalamount]"
                       class="form-control amount-field"
                       placeholder="Enter Amount">
            </div>

            <div class="col-md-2 form-group">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-success addContract btn-block">Add</button>
            </div>
        </div>

    </div>
</div>


<div class="text-right">
    <button type="submit" class="btn btn-primary">Save Parameters</button>
</div>

</form>
</div>
</div>

@endsection


@section('scripts')
<script>

let permanentIndex = 1;
let contractIndex = 1;


// FORMAT AMOUNT WITH COMMAS
$(document).on('keyup', '.amount-field', function () {

    let value = $(this).val().replace(/,/g, '');
    value = value.replace(/\D/g, '');

    if (value !== '') {
        value = parseInt(value, 10).toLocaleString('en-US');
    }

    $(this).val(value);
});


// REMOVE COMMAS BEFORE SUBMIT
$('form').on('submit', function () {
    $('.amount-field').each(function () {
        let cleanValue = $(this).val().replace(/,/g, '');
        $(this).val(cleanValue);
    });
});


// ADD PERMANENT ROW
$('.addPermanent').click(function(){

    $('#permanentSection').append(`
        <div class="row row-space">
            <div class="col-md-5 form-group">
                <select name="sections[4][rows][${permanentIndex}][gradelevel]" class="form-control">
                    @foreach($grades as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5 form-group">
                <input type="text"
                       name="sections[4][rows][${permanentIndex}][totalamount]"
                       class="form-control amount-field"
                       placeholder="Enter Amount">
            </div>

            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-danger removeRow btn-block">Remove</button>
            </div>
        </div>
    `);

    permanentIndex++;
});


// ADD CONTRACT ROW
$('.addContract').click(function(){

    $('#contractSection').append(`
        <div class="row row-space">
            <div class="col-md-5 form-group">
                <select name="sections[5][rows][${contractIndex}][gradelevel]" class="form-control">
                    @foreach($grades as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5 form-group">
                <input type="text"
                       name="sections[5][rows][${contractIndex}][totalamount]"
                       class="form-control amount-field"
                       placeholder="Enter Amount">
            </div>

            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-danger removeRow btn-block">Remove</button>
            </div>
        </div>
    `);

    contractIndex++;
});


// REMOVE ROW
$(document).on('click', '.removeRow', function(){
    $(this).closest('.row').remove();
});

</script>
@endsection
