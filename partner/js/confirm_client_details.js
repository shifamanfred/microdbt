var confirm_form = document.getElementById('confirm-client');

var new_loan_radio = document.getElementById('new-loan');
var add_client_radio = document.getElementById('add-client');
var customer_radio = document.getElementById('customer');

var e = document.getElementsByClassName('dmbox');

var confirm_form_submit_btn = confirm_form.elements.namedItem('submit-btn');
confirm_form_submit_btn.setAttribute('disabled', '');

function elementHighlighter(element) {
  for (var index = 0; index < e.length; index++) {
    e[index].style.border = '1px solid #EDEDED';
  }
  element.style.border = '1px solid #4ECDC4';
}

$(new_loan_radio).hide();
$(add_client_radio).hide();
$(customer_radio).hide();

$('#new-loan-btn').click(function () {
  confirm_form_submit_btn.removeAttribute('disabled');
  new_loan_radio.checked = true;
  elementHighlighter(e[0]);
});

$('#add-client-btn').click(function () {
  confirm_form_submit_btn.removeAttribute('disabled');
  add_client_radio.checked = true;
  elementHighlighter(e[1]);
});

$('#customer-btn').click(function () {
  confirm_form_submit_btn.removeAttribute('disabled');
  customer_radio.checked = true;
  elementHighlighter(e[2]);
});
