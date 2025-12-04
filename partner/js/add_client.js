var client_id_div = document.getElementById('client-id');
var client_id_input = document.getElementById('customerID');
var client_id_help = document.getElementById('customerIDHelp');
var client_name_input = document.getElementById('customerName');

var submit_btn = document.getElementById('submit_btn');

$('#btn-edit').hide();

client_id_input.onkeyup = client_id_input.onchange = client_id_input.onblur = function () {
	for (var index = 0; index < borrowers.length; index++) {
		if (this.value == borrowers[index].id_num) {
      if (borrowers[index].edit) {
        client_id_div.setAttribute('class', 'form-group has-success');
        submit_btn.setAttribute('disabled', '');
        client_id_help.innerHTML = 'ID number exists: Client records may be modified';
        client_id_div.getElementsByTagName('div')[0].setAttribute('class', 'col-sm-7');
        $('#btn-edit').attr('href', 'client_profile.php?id_num=' + borrowers[index].id_num + '&mode=edit') ;
        $('#btn-edit').show(300);
      } else {
        $('#btn-edit').hide(200);
        $('#btn-edit').attr('href', '#');
        client_id_div.setAttribute('class', 'form-group has-error');
  			submit_btn.setAttribute('disabled', '');
  			client_id_help.innerHTML = 'ID number already exists: probably added by another partner';

        setTimeout(function () {
          client_id_div.getElementsByTagName('div')[0].setAttribute('class', 'col-sm-8');
        }, 300);
      }

      $('#customer-details-container').hide(400);

			break;
		} else {
      $('#btn-edit').hide(200);
      $('#btn-edit').attr('href', '#');
      setTimeout(function () {
        client_id_div.getElementsByTagName('div')[0].setAttribute('class', 'col-sm-8');
      }, 300);
      $('#customer-details-container').show(400);
      client_id_div.setAttribute('class', 'form-group');
			submit_btn.removeAttribute('disabled');
			client_id_help.innerHTML = '';
		}
	}
};
