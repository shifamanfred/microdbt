
$('#div-transfer-to').hide();

$('#budget-type').change(function () {
  if ($(this)[0].selectedIndex == 2) {
    $('#div-transfer-to').show(300);
  } else {
    $('#div-transfer-to').hide(300);
  }
});
