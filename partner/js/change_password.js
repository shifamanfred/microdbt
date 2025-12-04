var form = document.getElementById('change-password-form');
var confirm_container = document.getElementById('conf-container');
var confirm_container_msg = document.getElementById('conf-container-msg');

form.change_password_btn.setAttribute('disabled', '');

form.conf.onkeyup = function () {
  if (form.new_pass.value === form.conf.value) {
    confirm_container.setAttribute('class', 'form-group has-success');
    confirm_container_msg.innerHTML = 'Passwords Match!';
    form.change_password_btn.removeAttribute('disabled');
  } else {
    confirm_container.setAttribute('class', 'form-group has-error');
    confirm_container_msg.innerHTML = 'Passwords Are Not Matching!';
    form.change_password_btn.setAttribute('disabled', '');
  }
}

form.onsubmit = function () {

  if (form.username.value == '') {
    return false;
  }

  if (form.old_pass.value == '') {
    return false;
  }

  if (form.new_pass.value == '') {
    return false;
  }

  if (form.conf.value == '') {
    return false;
  }

  return true;
}
