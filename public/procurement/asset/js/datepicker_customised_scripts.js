function termination1() {
	$token = $("input[name='_token']").val();
$.ajax({

            headers: {'X-CSRF-TOKEN': $token},
            type: 'POST',
            url: murl +'/getRecords',
            data: {'usid': $("#uid").val()},
            success: function(data) {
                //console.log(res);
              $('#terminationdate').val(data.dateTerminated);
        $('#pencont').val(data.pension_contract_terminate);
        $('#penamt').val(data.pensionAmount);
        $('#peranum').val(data.pensionperanumfrom); 
        $('#gratuity').val(data.gratuity);
        $('#contractgratuity').val(data.contractGratuity);
            },
            error: function(res) {
                console.log('Error:' + res);
            }
        });

}

function termination2() {
$token = $("input[name='_token']").val();
$.ajax({

            headers: {'X-CSRF-TOKEN': $token},
            type: 'POST',
            url: murl +'/getRecords',
            data: {'usid': $("#uid").val()},
            success: function(data) {
                //console.log(res);
              $('#dateofdeath').val(data.dateOfDeath);
        $('#gratuityestate').val(data.gratuityPaidEstate);
        $('#widowspension').val(data.widowsPension);
        $('#widperanum').val(data.widowsPensionFrom); 
        $('#orphanpen').val(data.orphanPension);
        $('#orpanperanum').val(data.orphanPensionFrom);
            },
            error: function(res) {
                console.log('Error:' + res);
            }
        });

}

function termination3() {
	$token = $("input[name='_token']").val();
$.ajax({

            headers: {'X-CSRF-TOKEN': $token},
            type: 'POST',
            url: murl +'/getRecords',
            data: {'usid': $("#uid").val()},
            success: function(data) {
                //console.log(res);
              $('#transferdate').val(data.dateOfTransfer);
        $('#transpencon').val(data.pension_contract_transfer);
        $('#years').val(data.aggregateYears);
        $('#months').val(data.aggregateMonths); 
        $('#days').val(data.aggregateDays);
        $('#aggrsalary').val(data.aggregateSalary);
            },
            error: function(res) {
                console.log('Error:' + res);
            }
        });

}