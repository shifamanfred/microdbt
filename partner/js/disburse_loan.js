var disburse_form = document.getElementById('disburse-form');

var pay_cash_radio = document.getElementById('pay-cash');
var bank_transfer_radio = document.getElementById('bank-transfer');
var e_wallet_radio = document.getElementById('e-wallet');

var e = document.getElementsByClassName('dmbox');

var disburse_form_submit_btn = disburse_form.elements.namedItem('submit-btn');
disburse_form_submit_btn.setAttribute('disabled', '');

function elementHighlighter(element) {

  for (var index = 0; index < e.length; index++) {
    e[index].style.border = '1px solid #EDEDED';
  }

  element.style.border = '1px solid #4ECDC4';
}

$(pay_cash_radio).hide();
$(bank_transfer_radio).hide();
$(e_wallet_radio).hide();

$('#pay-cash-btn').click(function () {
  disburse_form_submit_btn.removeAttribute('disabled');
  pay_cash_radio.checked = true;
  elementHighlighter(e[0]);
});

$('#bank-transfer-btn').click(function () {
  disburse_form_submit_btn.removeAttribute('disabled');
  bank_transfer_radio.checked = true;
  elementHighlighter(e[1]);
});

$('#e-wallet-btn').click(function () {
  disburse_form_submit_btn.removeAttribute('disabled');
  e_wallet_radio.checked = true;
  elementHighlighter(e[2]);
});
