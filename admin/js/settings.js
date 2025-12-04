
  var debit_order = document.forms[0].debit_order
  var namfisa = document.forms[0].namfisa;

  debit_order.onblur = debit_order.onchange = namfisa.onblur = namfisa.onchange = function () {
    this.value = Number(this.value).toFixed(2);
  };
