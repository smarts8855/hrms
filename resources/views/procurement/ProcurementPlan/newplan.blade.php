@extends('layouts.app')
@section('pageTitle', 'Add Procurement Plan')
@section('pageMenu', 'active')
@section('content')

<div class="container-fluid">
<div class="row">
    <div class="col-lg-12">

        <h4 class="card-title mb-4">Procurement Plan Sheet</h4>
        <br/>
        <div id="vertical-example" class="vertical-wizard">
            <!-- Basic Data -->
            <h3>Basic Data</h3>
            <section style="margin-top: 2;">
                <form method="post" action="{{url('/procurement/new-plan')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-firstname-input">Budget Year</label>
                                <select class="form-control" name="budgetYear" required>
                                    @for($i=2020; $i <=2040; $i++)
                                    <option>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-lastname-input">Budget Code <span class="text-danger">*</span></label>
                                <input type="text" name="budgetCode" class="form-control" required placeholder="Budget code" >
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-phoneno-input">Package Number <span class="text-danger">*</span></label>
                                <input type="text" name="packageNumber" class="form-control" required placeholder="Package No">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Lot Number</label>
                                <input type="text" name="lotNumber" class="form-control" placeholder="Lot No">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Procurement Plan Date <span class="text-danger">*</span></label>
                                <input type="date" name="planDate" id="planDate" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Project Title <span class="text-danger">*</span></label>
                                <input type="text" name="projectTitle" class="form-control" required placeholder="Project Title">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Procurement Category <span class="text-danger">*</span></label>
                                <select class="form-control" name="category">

                                    <option value="">Select</option>
                                    @foreach($category as $list)
                                    <option>{{$list->category_name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Contract Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="contractType">
                                    <option value="">Select</option>
                                    @foreach($contractType as $list)
                                    <option>{{$list->type}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Budget Amount <span class="text-danger">*</span></label>
                                <input type="text" name="budget" id="budget" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Project Estimate <span class="text-danger">*</span></label>
                                <input type="text" name="estimate" id="estimate" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-email-input" style="font-size: 10px;">Procurement Method (ICB, NCB, Direct, Selective, Repeat, Shopping)</label>
                                <input type="text" name="procurementMethod" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Qualification (Pre/Post)</label>
                                <input type="text" name="qualification" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-email-input">Review (Pre/Post)</label>
                                <input type="text" name="review" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                    <hr />

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Create Plan</button>
                        </div>
                    </div>
                    </div>
                </form>
            </section>

            <!-- Planned Timelines -->
            <h3>Planned Timelines</h3>
            <section>
                {{-- form --}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-pancard-input">Preparation of Bid Document & Advert</label>
                                <input type="date" name="bidDocFrom" id="bidDocFrom" class="form-control" placeholder="Bid Document From"> <br>
                                <input type="date" name="bidDocTo" id="bidDocTo" class="form-control" placeholder="Bid Document To">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-vatno-input">Approval for Bid Document & Advert</label>
                                <input type="date" name="mdaApproveFrom" id="mdaApproveFrom" class="form-control" placeholder="MDA Approval From"><br>
                                <input type="date" name="mdaApproveTo" id="mdaApproveTo" class="form-control" placeholder="MDA Approval To">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-cstno-input" style="font-size: 11px;">Advertisement for Prequalification/Express of Interest (EOI)</label>
                                <input type="date" name="prequaliAdvertFrom" id="preQualiAdvertFrom" class="form-control" placeholder="Prequalification Advert From"><br>
                                <input type="date" name="preQualiAdvertTo" id="preQualiAdvertTo" class="form-control" placeholder="Prequalification Advert To">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-servicetax-input">Pre-qualification/EOI Closing/Opening Date</label>
                                <input type="date" name="preQualiClosingFrom" id="preQualiClosingFrom" class="form-control" placeholder="Prequalification Closing From"><br>
                                <input type="date" name="preQualiClosingTo" id="preQualiClosingTo" class="form-control" placeholder="Prequalification Closing To">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-companyuin-input">Financial Evaluation</label>
                                <input type="date" name="financialEvaluationFrom" id="financialEvaluationFrom" class="form-control" placeholder="Financial Evaluation From"><br>
                                <input type="date" name="financialEvaluationTo" id="financialEvaluationTo" class="form-control" placeholder="Financial Evaluation To">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-declaration-input">Submission of Bid/Proposal Evaluation Report</label>
                                <input type="date" name="submissionEvaluationFrom" id="submissionEvaluationFrom" class="form-control" placeholder="Submission of Evaluation From"><br>
                                <input type="date" name="submissionEvaluationTo" id="submissionEvaluationTo" class="form-control" placeholder="Submission of Evaluation To">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-companyuin-input">Approval of No Objection Date</label>
                                <input type="date" name="mdaObjectionFrom" id="mdaObjectionFrom" class="form-control" placeholder="MDA Objection From"><br>
                                <input type="date" name="mdaObjectionTo" id="mdaObjectionTo" class="form-control" placeholder="MDA Objection To">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-declaration-input">Certifiable Amount</label>
                                <input type="text" name="certifiableAmountFrom" id="certifiableAmountFrom" class="form-control" placeholder="Certifiable Amount From"><br>
                                <input type="text" name="certifiableAmountTo" id="certifiableAmountTo" class="form-control" placeholder="Certifiable Amount To">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-companyuin-input">Date of Contract Signature</label>
                                <input type="date" name="contractSignatureDateFrom" id="contractSignatureDateFrom" class="form-control" placeholder="Contract Signature Date From"><br>
                                <input type="date" name="contractSignatureDateTo" id="contractSignatureDateTo" class="form-control" placeholder="Contract Signature Date To">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-declaration-input">Mobilization/Advance Payment</label>
                                <input type="date" name="advancePaymentFrom" id="advancePaymentFrom" class="form-control" Placeholder="Advance Payment From"><br>
                                <input type="date" name="advancePaymentTo" id="advancePaymentTo" class="form-control" Placeholder="Advance Payment To">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-companyuin-input">Substantial Completion/Draft Final Report</label>
                                <input type="date" name="draftFinalReportFrom" id="draftFinalReportFrom" class="form-control" placeholder="Substantial Completion/Draft Finan Report From"><br>
                                <input type="date" name="draftFinalReportTo" id="draftFinalReportTo" class="form-control" placeholder="Substantial Completion/Draft Finan Report To">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="verticalnav-declaration-input">Arrival of Goods/Final Acceptance/Final Report</label>
                                <input type="date" name="finalAcceptanceFrom" id="finalAcceptanceFrom" class="form-control" placeholder="Arrival of Goods/Final Acceptance & Report From"><br>
                                <input type="date" name="finalAcceptanceTo" id="finalAcceptanceTo" class="form-control" placeholder="Arrival of Goods/Final Acceptance & Report To">
                            </div>
                        </div>
                    </div>


                {{-- /form --}}
            </section>

            <!-- Action Party(Name/Designation) -->
            <h3>Action Parties</h3>
            <section>
                <div>
                    {{-- form --}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="verticalnav-namecard-input">Action Party(Name/Designation)</label>
                                    <input type="text" class="form-control" id="actionPartyName" placeholder="Enter Name"><br>
                                    <select class="form-select">
                                        <option selected>Select Designation</option>
                                        <option value="ps">Permanent Secretary</option>
                                        <option value="dir">Dirctor</option>
                                        <option value="assdir">Assistant Director</option>
                                        <option value="tbs">Tenders Board Secretary</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="verticalnav-namecard-input">Champion (Name/Designation)</label>
                                <input type="text" class="form-control" id="PartyName" placeholder="Enter Name">
                                <br>
                                    <select class="form-select">
                                        <option selected>Select Designation</option>
                                        <option value="ps">Permanent Secretary</option>
                                        <option value="dir">Dirctor</option>
                                        <option value="assdir">Assistant Director</option>
                                        <option value="tbs">Tenders Board Secretary</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    {{-- /form --}}
                    </div>
            </section>

            <!-- Summary of Plan Details -->
            <h3>Plan Summary/Confirmation</h3>
            <section>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="mb-4">
                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                            </div>
                            <div>
                                <h5>Confirm Detail</h5>
                                <p class="text-muted">Confirm if everything is okay and as supplied into the form before submission.</p>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
            </section>
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
</div>
@endsection

@section('styles')
<style>
    .remove, .delete
    {
        margin-top:30px;
        padding-top:5px !important;
        padding-bottom:0px !important;

        margin-bottom:0px;
    }
    .fa-times
    {
        font-size:30px;
        cursor: pointer;
    }
    .compulsory
    {
        color:red;
    }
    table tr th
    {
        font-size:16px;
    }
</style>
@endsection


@section('scripts')
<script src="{{ asset('assets/js/datepickerScripts.js') }}"></script>

<script>
 $(document).ready(function() {
     $(document).on('click', '.bn', function(){
 //alert(0);
 $('.wraps').last().remove();
  var id = this.id;
  var deleteindex = id[1];

  // Remove <div> with id
  $("#" + deleteindex).remove();

 });
});

</script>

<script>

$("#biddingAmount").on('keyup', function(){
    var n = parseInt($(this).val().replace(/\D/g,''),10);
    if($(this).val() == "")
    {
      $(this).val(0);
    }
    else
    {
        $(this).val(n.toLocaleString());
    }
});

  /*  $(document).ready(function() {
  $('#add').click(function() {
   var total_element = $(".wraps").length;
   var lastid = $(".wraps:last").attr("id");
   //var split_id = lastid.split('_');
  var n = Number(lastid) + 1;
  //alert(nextindex);
    $('#inputWrap').append(
        `<div class="wraps" id="'+n+'">
        <div class="row">
        <div class="col-md-5">
        <div class="form-group dynFile">
            <label for="">Document</label>
            <input type="file" name="document[]" class="form-control" id=''>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group dynInput">
            <label for="">Document Description</label>
            <input type="text" name="description[]" class="form-control" id='' >
        </div>
        </div>
        <span class="delete bn"><i class="fa fa-times"></i></span>
        </div>
        </div>`
        );
  });
  //end click function

  $('.delete').last().click (function () {
						$('.wraps').last().remove();
					});

});*/
</script>

<script>
    $(document).ready(function() {
  $('#add').click(function() {
   var total_element = $(".wraps").length;
   var lastid = $(".wraps:last").attr("id");
   //var split_id = lastid.split('_');
  var n = Number(lastid) + 1;
  //alert(nextindex);
    $('#inputWrap').append(
        `<div class="wraps" id="'+n+'">
        <div class="row">
        <div class="col-md-12">
        <a class="delete bn remove_bank_field_btn pull-right align-right" href="javascript::void()">Remove</a>
        </div>
        <div class="col-md-6">
        <div class="form-group dynFile">
            <label for="">Document</label>
            <input type="file" name="document[]" class="form-control" id=''>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group dynInput">
            <label for="">Document Description</label>
            <input type="text" name="description[]" class="form-control" id='' >
        </div>
        </div>

        </div>
        </div>`
        );
  });
  //end click function

  $('.delete').last().click (function () {
						$('.wraps').last().remove();
					});

});
</script>

<script>
    $(document).ready(function () {
$("#budget").on('keyup', function(evt){
    //if (evt.which != 110 ){//not a fullstop
        //var n = parseFloat($(this).val().replace(/\,/g,''),10);

         $(this).val(function (index, value) {
        return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        //$(this).val(n.toLocaleString());
    //}
});
});


 $(document).ready(function () {
$("#estimate").on('keyup', function(evt){
    //if (evt.which != 110 ){//not a fullstop
        //var n = parseFloat($(this).val().replace(/\,/g,''),10);

         $(this).val(function (index, value) {
        return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        //$(this).val(n.toLocaleString());
    //}
});
});
</script>

<script>
function selectDate(selector)
{
    $("#" + selector).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#' selector).val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
}
</script>



@endsection

