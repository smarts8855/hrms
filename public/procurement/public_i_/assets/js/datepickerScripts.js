    $("#planDate").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#planDate').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  
$("#bidDocFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#bidDocFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#bidDocTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#bidDocTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  
  $("#mdaApproveFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#mdaApproveFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
$("#mdaApproveTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#mdaApproveTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /*****************************/
  $("#preQualiAdvertFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiAdvertFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#preQualiAdvertTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiAdvertTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
  /*****************************/
  $("#preQualiClosingFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiClosingFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#preQualiClosingTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiClosingTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
  /*****************************/
  $("#preQualiEvaluationFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiEvaluationFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#preQualiEvaluationTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiEvaluationTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
  /*****************************/
  $("#preQualiEvaluateReportFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiEvaluateReportFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#preQualiEvaluateReportTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiEvaluateReportTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  /*****************************/
  $("#mdaApprovalPreQualiFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#mdaApprovalPreQualiFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#mdaApprovalPreQualiTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#mdaApprovalPreQualiTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/

  /*****************************/
  $("#invitationTenderFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#invitationTenderFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#invitationTenderTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#invitationTenderTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  /*****************************/
  $("#invitationTenderFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#invitationTenderFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#invitationTenderTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#invitationTenderTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  /*****************************/
  $("#technicalBidOpeningFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#technicalBidOpeningFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#technicalBidOpeningTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#technicalBidOpeningFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  /*****************************/
  $("#financialBidOpeningFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#financialBidOpeningFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#financialBidOpeningTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#financialBidOpeningTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  /*****************************/
  $("#preQualiCloseOpenFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiCloseOpenFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#preQualiCloseOpenTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#preQualiCloseOpenTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
   /*****************************/
  $("#financialEvaluationFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#financialEvaluationFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#financialEvaluationTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#financialEvaluationTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
  /*****************************/
  $("#financialEvaluationFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#financialEvaluationFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#financialEvaluationTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#financialEvaluationTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  /*****************************/
  $("#submissionEvaluationFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#submissionEvaluationFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#submissionEvaluationTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#submissionEvaluationTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
  /*****************************/
  $("#mdaObjectionFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#mdaObjectionFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#mdaObjectionTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#mdaObjectionTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
  /*****************************/
  $("#certifiableAmountFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#certifiableAmountFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#certifiableAmountTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#certifiableAmountTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
   /*****************************/
  $("#fecApprovalFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#fecApprovalFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#fecApprovalTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#fecApprovalTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
   /*****************************/
  $("#dateContractOfferFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#dateContractOfferFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#dateContractOfferTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#dateContractOfferTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
   /*****************************/
  $("#contractSignatureDateFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#contractSignatureDateFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#contractSignatureDateTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#contractSignatureDateTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
   /*****************************/
  $("#advancePaymentFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#advancePaymentFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#advancePaymentTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#advancePaymentTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  
   /*****************************/
  $("#draftFinalReportFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#draftFinalReportFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#draftFinalReportTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#draftFinalReportTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/
  /*****************************/
  $("#finalAcceptanceFrom").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#finalAcceptanceFrom').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  $("#finalAcceptanceTo").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd-mm-yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
       $('#finalAcceptanceTo').val($.datepicker.formatDate('dd-mm-yy', theDate));
    },
  });
  /***********************************/


