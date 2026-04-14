@extends('layouts.layout')

@section('pageTitle')
Payroll Report - Difference in Months Payment
@endsection

@section('content')
<div class="box-body" style="background:#FFF;">
    <div style="clear:both"></div>
    <div class="row">
        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> 
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif  
            @if(session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> 
                    {{ session('message') }}
                </div>                        
            @endif
            @if(session('err'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> 
                    {{ session('err') }}
                </div>                        
            @endif
        </div>
    </div>
</div>

<div class="box-body" style="background:#FFF;">
    <h4 class="" style="text-transform:uppercase">Payroll Report</h4>
    <br />  
    <form id="paymentForm" action="{{ route('checkNewPersonnel') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="current_year">Current Year:</label>
                    <select name="current_year" id="current_year" class="form-control">
                        @foreach(range(date('Y'), 2000) as $year)
                            <option value="{{ $year }}" {{ old('current_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="current_month">Current Month:</label>
                    <select name="current_month" id="current_month" class="form-control">
                        @foreach(['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'] as $month)
                            <option value="{{ $month }}" {{ old('current_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <div class="col-md-6">
                <div class="form-group">
                    <label for="comparison_year">Comparison Year:</label>
                    <select name="comparison_year" id="comparison_year" class="form-control">
                        @foreach(range(date('Y'), 2000) as $year)
                            <option value="{{ $year }}" {{ old('comparison_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="comparison_month">Comparison Month:</label>
                    <select name="comparison_month" id="comparison_month" class="form-control">
                        @foreach(['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'] as $month)
                            <option value="{{ $month }}" {{ old('comparison_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    
        <button type="submit" class="btn btn-success pull-right">Check Personnel</button>
    </form>
    
        <br />
    
    <hr />  
    <!-- Result Display Area -->
    <div class="row">
        <div class="col-md-12" id="result"></div>
    </vid>
</div>

<style>
    /* Style for negative values (red) */
.negative {
    color: red;
}

/* Style for positive values (green) */
.positive {
    color: green;
}
</style>   
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#paymentForm").on('submit', function(e) {
        e.preventDefault();  // Prevent normal form submission

        var formData = $(this).serialize();  // Get form data

        // Log form data to the console before sending the request
        console.log(formData);  // This will output the form data in the browser console
        $.ajax({
            url: '{{ route("checkNewPersonnel") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);  // Log the response to verify the data structure
                if (response.newPersonnel && response.newPersonnel.length > 0) {
                    var resultHtml = '<table class="table table-striped">';
                    resultHtml += '<thead>';
                    resultHtml += '<tr>';
                    resultHtml += '<th>#</th>';
                    resultHtml += '<th>File No</th>';
                    resultHtml += '<th>Title</th>';
                    resultHtml += '<th>Fullnames</th>';
                    resultHtml += '<th>Division</th>';
                    resultHtml += '<th>Account No</th>';
                    resultHtml += '<th>Basic</th>';
                    resultHtml += '<th>Net Pay</th>';
                    resultHtml += '<th>Tax</th>';
                    resultHtml += '<th>Gross Pay</th>';
                    resultHtml += '</tr>';
                    resultHtml += '</thead>';
                    resultHtml += '<tbody>';

                    var counter = 1;  // Initialize counter
                    var totalBasic = 0;  // Initialize sum for Basic Pay
                    var totalNetPay = 0;  // Initialize sum for Net Pay
                    var totalTax = 0;  // Initialize sum for Tax
                    var totalGross = 0;  // Initialize sum for Gross Pay

                    response.newPersonnel.forEach(function(person) {
                        resultHtml += '<tr>';
                        resultHtml += '<td>' + counter++ + '</td>';
                        resultHtml += '<td>' + person.fileNo + '</td>';
                        resultHtml += '<td>' + person.title + '</td>';
                        resultHtml += '<td>' + person.surname + ' '+ person.first_name + ' ' + person.othernames +'</td>';
                        resultHtml += '<td>' + person.division + '</td>';
                        resultHtml += '<td>' + person.accNo + '</td>';
                        
                        // Add the pay values and color them based on whether they're negative or positive
                        resultHtml += '<td class="' + '">' + '&#8358;' + person.Bs.toLocaleString() + '</td>';
                        resultHtml += '<td class="' + '">' + '&#8358;' + person.NetPay.toLocaleString() + '</td>';
                        resultHtml += '<td class="' + '">' + '&#8358;' + person.Tax.toLocaleString() + '</td>';
                        resultHtml += '<td class="' + '">' + '&#8358;' + person.gross.toLocaleString() + '</td>';
                        // resultHtml += '<td class="' + (person.gross < 0 ? 'negative' : 'positive') + '">' + '&#8358;' + person.gross.toLocaleString() + '</td>';
                        resultHtml += '</tr>';

                        // Sum up the values for Basic, Net Pay, Tax, and Gross
                        totalBasic += parseFloat(person.Bs);  // Sum the Basic Pay
                        totalNetPay += parseFloat(person.NetPay);  // Sum the Net Pay
                        totalTax += parseFloat(person.Tax);  // Sum the Tax
                        totalGross += parseFloat(person.gross);  // Sum the Gross Pay
                    });

                    resultHtml += '</tbody>';

                    // Add a footer with the total sums and make it bold
                    resultHtml += '<tfoot style="font-weight: bold;">';
                    resultHtml += '<tr>';
                    resultHtml += '<td colspan="6"><strong>Total</strong></td>';  // Span across the first 8 columns
                    resultHtml += '<td class="' + (totalBasic < 0 ? 'negative' : 'positive') + '">' + '&#8358;' + totalBasic.toLocaleString() + '</td>';
                    resultHtml += '<td class="' + (totalNetPay < 0 ? 'negative' : 'positive') + '">' + '&#8358;' + totalNetPay.toLocaleString() + '</td>';
                    resultHtml += '<td class="' + (totalTax < 0 ? 'negative' : 'positive') + '">' + '&#8358;' + totalTax.toLocaleString() + '</td>';
                    resultHtml += '<td class="' + (totalGross < 0 ? 'negative' : 'positive') + '">' + '&#8358;' + totalGross.toLocaleString() + '</td>';
                    resultHtml += '</tr>';
                    resultHtml += '</tfoot>';

                    resultHtml += '</table>';

                    $('#result').html(resultHtml);  // Display results in table format
                } else {
                    $('#result').html('<p>No new personnel found for the selected months or period.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.log("Error: ", error);  // Log the error to the console for debugging
                $('#result').html('<p>Error occurred. Please try again.</p>');
            }
        });


    });
});

    </script>
    
@endsection
