// employee user form variables
var emp_cred_container = document.getElementById('emp-cred-container');
var add_emp = document.getElementById('add-emp-user');
var remove_emp = document.getElementById('remove-emp-user');
var emp_index = 1;

add_emp.onclick = function () {
  var div_element = document.createElement('div');

  div_element.setAttribute('class', 'emp-form-group');

  div_element.innerHTML = '<h4 class="emp-heading mb col-sm-12"><i class="fa fa-angle-right"></i> Partner Employee ' + (++emp_index) + ' Details</h4>\
  <div class="form-group col-sm-6">\
    <div class="col-sm-12">\
      <input type="email" class="form-control" placeholder="Email Address" name="emp_email[]">\
    </div>\
  </div>\
\
  <div class="form-group col-sm-6">\
    <div class="col-sm-12">\
      <input type="text" class="form-control" placeholder="Username" name="emp_username[]">\
    </div>\
  </div>\
\
  <div class="form-group col-sm-6">\
    <div class="col-sm-12">\
      <input type="password" class="form-control" placeholder="Password" name="emp_password[]">\
    </div>\
  </div>\
\
  <div class="form-group col-sm-6">\
    <div class="col-sm-12">\
      <input type="password" class="form-control" placeholder="Confirm Password" name="emp_confirm[]">\
      <p id="conf-message" class="help-block"></p>\
    </div>\
  </div>';

  emp_cred_container.appendChild(div_element);
};

remove_emp.onclick = function () {
  // $('#emp-cred-container div.emp-form-group').last().remove();
  $('#emp-cred-container div.emp-form-group').last().fadeOut(300, function () {
    $(this).remove();
  });
  if (emp_index != 1) {
    emp_index--;
  }
};
