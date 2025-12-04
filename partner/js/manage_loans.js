$('#disburse-btn').click(function () {
  $('tr.loan-record').hide();

  $('tr.disbursed').show(250);
});

$('#approve-btn').click(function () {
  $('tr.loan-record').hide();

  $('tr.approved').show(250);
});

$('#decline-btn').click(function () {
  $('tr.loan-record').hide();

  $('tr.declined').show(250);
});

$('#settle-btn').click(function () {
  $('tr.loan-record').hide();

  $('tr.settled').show(250);
});

$('#pending-btn').click(function () {
  $('tr.loan-record').hide();

  $('tr.pending').show(250);
});

// default viewing (disbursed loans)
$('tr.loan-record').hide();

$('tr.disbursed').show();
