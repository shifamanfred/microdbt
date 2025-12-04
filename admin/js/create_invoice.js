/* variables to take note of
 * partners : array
 * products : array
 */
// variables
var invoice_type_select = document.getElementById('invoiceType');
var company_name_text = document.getElementById('company-name');
var company_address_text = document.getElementById('address');
var partner_select = document.getElementById('partner-select');
var partner_id_input = document.getElementById('partnerId');

var add_row = document.getElementById('addRows');
var remove_row = document.getElementById('removeRows');
var invoice = document.getElementById('invoiceItem').getElementsByTagName('tbody')[0];

// variables for the products and services being listed
var product_codelist = document.getElementById('codelist');
var code_inputs = document.getElementsByName('productCode[]');
var pro_name_inputs = document.getElementsByName('productName[]');
var pro_quantity_inputs = document.getElementsByName('quantity[]');
var pro_price_inputs = document.getElementsByName('price[]');
var pro_total_inputs = document.getElementsByName('total[]');

function loadProductDetails(code_input_tag, quantity) {
  // flag for checking whether the code value is inputed manually or from selection info from database
  var selection_flag = false;

  // get index of the code input field
  for (var input_index = 0; input_index < code_inputs.length; input_index++) {
    if (code_inputs[input_index] == code_input_tag) {
      break;
    }
  }

  for (var x = 0; x < product_codelist.options.length; x++) {
    if (code_input_tag.value == product_codelist.options[x].value) {
      // turn on selection_flag
      selection_flag = true;

      // filling the rest of the product data if code has been selected from code list;

      pro_name_inputs[input_index].value = products[x].name;
      pro_quantity_inputs[input_index].value = quantity;
      pro_price_inputs[input_index].value = products[x].fee;
      pro_total_inputs[input_index].value = (products[x].fee * pro_quantity_inputs[input_index].value);

      changeInputStatus(code_inputs[input_index], true);
      changeInputStatus(pro_name_inputs[input_index], true);
      changeInputStatus(pro_price_inputs[input_index], true);

      break;
    }
  }

  // if selected info is from database update totals
  if (selection_flag) {
    updateInputTotals();
  } else {
    // otherwise show red flags
    changeInputStatus(code_inputs[input_index], false);
    changeInputStatus(pro_name_inputs[input_index], false);
    changeInputStatus(pro_price_inputs[input_index], false);
  }
}

function updateProductInputs() {
  code_inputs = document.getElementsByName('productCode[]');
  pro_name_inputs = document.getElementsByName('productName[]');
  pro_quantity_inputs = document.getElementsByName('quantity[]');
  pro_price_inputs = document.getElementsByName('price[]');
  pro_total_inputs = document.getElementsByName('total[]');

  var index = code_inputs.length - 1;

  code_inputs[index].onblur = function() {
    loadProductDetails(this, 1);
  };

  // load product details when quantity cell is edited
  pro_quantity_inputs[index].onblur = function () {
    loadProductDetails(code_inputs[index], Number(this.value));
  };

  pro_price_inputs[index].onblur = function () {
    loadProductDetails(code_inputs[index], Number(pro_quantity_inputs[index].value));
  }
}

function updateInputTotals() {
  subTotal = document.getElementById('subTotal');
  taxRate = document.getElementById('taxRate');
  taxAmount = document.getElementById('taxAmount');
  totalAftertax = document.getElementById('totalAftertax');
  amountPaid = document.getElementById('amountPaid');
  amountDue = document.getElementById('amountDue');

  amountPaid.onblur = function () {
    amountDue.value = Number(totalAftertax.value) - Number(amountPaid.value);
  }

  var total_num = 0;

  // update subtotal
  for (var x = 0; x < pro_total_inputs.length; x++) {
    if (isNaN(pro_total_inputs[x].value)) {
      subTotal.value = taxRate.value = taxAmount.value = total.value = amountPaid = amountDue = '';
      break;
    } else {
      total_num += Number(pro_total_inputs[x].value);
      subTotal.value = total_num;
    }
  }

  taxRate.value = 15;
  taxAmount.value = Number(total_num * taxRate.value / 100);

  totalAftertax.value = Number(total_num + (1 * taxAmount.value));

  amountPaid.value = Number(amountPaid.value);
  amountDue.value = Number(totalAftertax.value) - Number(amountPaid.value);
}

function changeInputStatus(input_text, status) {
  // param 1: text input passed in
  // param 2: status - true if data is from database false if not

  if (status) {
    // apply this style
    input_text.style.backgroundColor = '#BBFFFF';
    input_text.style.color = '#555';
  } else {
    input_text.style.backgroundColor = '#CDCD00';
    input_text.style.color = '#800000';
  }
}

if (partner_select != null) {
  partner_select.onchange = function () {
    for (var i = 0; i < partners.length; i++) {
      if (partner_select.value == partners[i].id) {
        company_name_text.value = partners[i].name;
        company_address_text.value = partners[i].address;
        partner_id_input.value = partners[i].id;
        break;
      }
    }
  }
}

invoice_type_select.onchange = function () {
  switch (this.value) {
    case 'INVOICE':
      // change values according to invoice mode
      document.getElementById('invoiceHeading').firstChild.data = 'Issue Invoice';
      document.getElementById('saveInvoiceBtn').value = 'Save Invoice';
      break;

    case 'PROFORMA':
      // change values according to pro forma mode
      document.getElementById('invoiceHeading').firstChild.data = 'Issue Pro Forma Invoice';
      document.getElementById('saveInvoiceBtn').value = 'Save Pro Forma Invoice';
      break;

    case 'QUOTE':
      // change values according to quote mode
      document.getElementById('invoiceHeading').firstChild.data = 'Issue Quote';
      document.getElementById('saveInvoiceBtn').value = 'Save Quote';
      break;
    default:

  }
}

add_row.onclick = function () {
  table_row = document.createElement('tr');
  table_data = new Array();
  table_data[0] = document.createElement('td');
  table_data[1] = document.createElement('td');
  table_data[2] = document.createElement('td');
  table_data[3] = document.createElement('td');
  table_data[4] = document.createElement('td');

  table_data[0].innerHTML = '<input list="codelist" type="text" name="productCode[]" class="form-control" autocomplete="off">' + "\n";
  table_data[1].innerHTML = '<input type="text" name="productName[]" class="form-control" autocomplete="off">' + "\n";
  table_data[2].innerHTML = '<input type="number" name="quantity[]" class="form-control" autocomplete="off" min="1">' + "\n";
  table_data[3].innerHTML = '<input type="number" name="price[]" class="form-control" autocomplete="off">' + "\n";
  table_data[4].innerHTML = '<input type="number" name="total[]" class="form-control" autocomplete="off" readonly>' + "\n";

  table_row.appendChild(table_data[0]);
  table_row.appendChild(table_data[1]);
  table_row.appendChild(table_data[2]);
  table_row.appendChild(table_data[3]);
  table_row.appendChild(table_data[4]);
  invoice.appendChild(table_row);

  updateProductInputs();
}

remove_row.onclick = function () {
  if (invoice.getElementsByTagName('tr').length > 2) {
    invoice.removeChild(invoice.lastChild);
  }
}

// === This piece should be placed inside the updateProductInputs() function with appropriate index ===
// load product details when code cell is edited
code_inputs[0].onblur = function () {
  loadProductDetails(this, 1);
};

// load product details when quantity cell is edited
pro_quantity_inputs[0].onblur = function () {
  loadProductDetails(code_inputs[0], Number(this.value));
};

// load product details when price cell is edited
pro_price_inputs[0].onblur = function () {
  loadProductDetails(code_inputs[0], Number(pro_quantity_inputs[0].value));
}

pro_name_inputs[0].onchange = function () {
  for (var x = 0; x < products.length; x++) {
    if (this.value == products[x].name) {
      changeInputStatus(this, true);
      break;
    } else {
      changeInputStatus(this, false);
    }
  }
}

code_inputs[0].onchange = function () {
  for (var x = 0; x < products.length; x++) {
    if (this.value == products[x].name) {
      changeInputStatus(this, true);
      break;
    } else {
      changeInputStatus(this, false);
    }
  }
}
// === This piece should be placed inside the updateProductInputs() function with appropriate index (ENDING) ===
