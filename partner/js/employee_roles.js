// $(document).ready(function () {
  $('button.clear-select').click(function () {
    $('input[name="'+ $(this).attr('name') +'"]').prop('checked', false);
  });
// });
