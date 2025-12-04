var true_check = document.getElementById('trueCheck');
var false_check = document.getElementById('falseCheck');
var loan_alias_input = document.getElementById('loan-alias');

$('#loanDateGroup').hide();
$('#remain_inst').hide();

true_check.onclick = function () {
  $('#loanDateGroup').show(300);
  $('#remain_inst').show(300);
  loan_alias_input.value = loan_alias2;
}

false_check.onclick = function () {
  $('#remain_inst').hide(300);
  $('#loanDateGroup').hide(300);
  loan_alias_input.value = loan_alias;
}
