// partner form variables
var user = document.getElementById('user');
var pass = document.getElementById('pass');
var conf = document.getElementById('conf');
var submit = document.getElementById('submit');
var conf_message = document.getElementById('conf-message')
var conf_container = document.getElementById('conf-container')

// initialize
submit.disabled = true;

conf.onkeyup = function () {
  if (conf.value != pass.value) {
    conf_container.className = 'form-group col-sm-6 has-error';
    conf_message.innerHTML = 'Passwords Don\'t Match';
    submit.disabled = true;
  } else if (conf.value == "" || pass.value == ""){
    conf_container.className = 'form-group col-sm-6';
    conf_message.innerHTML = '';
    submit.disabled = false;
  } else {
    conf_container.className = 'form-group col-sm-6 has-success';
    conf_message.innerHTML = 'Passwords Match';
    submit.disabled = false;
  }
}
