var finance_form = document.getElementById('finance-form');
var exp_cont = document.getElementById('expense-container');
var exp_plus = document.getElementById('exp-plus');
var exp_minus = document.getElementById('exp-minus');
var exp_index = 0;

// if there are expense inputs already move the index indicator
if (exp_cont.getElementsByClassName('form-group')) {
  exp_index = exp_cont.getElementsByClassName('form-group').length;
}

exp_plus.onclick = function () {

  var div_element = document.createElement('div');

  div_element.setAttribute('class', 'form-group');

  div_element.innerHTML =   '<label class="col-sm-2 col-sm-2 control-label">Expense ' + (++exp_index) + '</label>\
                            <div class="col-sm-10">\
                              <input type="number" step="0.01" class="form-control" placeholder="Expense ' + exp_index + ' Amount" name="expenses[]" value="<?php echo $exp; ?>">\
                            </div>';

  exp_cont.appendChild(div_element);
};

exp_minus.onclick = function () {
  $('#expense-container div.form-group').last().fadeOut(50, function () {
    $(this).remove();
  });
  if (exp_index > 0) {
    exp_index--;
  }
};

finance_form.onsubmit = function () {

  if (this.gross_salary.value == '') {
    return false;
  } else if (this.net_salary.value == '') {
    return false;
  } else if (this.pay_date.value == '') {
    return false;
  } else {
    return true;
  }
};
