$('#search-input').keyup(function() {
  var search_input = $(this).val().toLowerCase();
  var search_records = document.getElementsByClassName('search-records');

  for (var index = 0; index < search_records.length; index++) {
    var show = false;

    search_data = search_records[index].getElementsByClassName('search-data');

    for (var sub_index = 0; sub_index < search_data.length; sub_index++) {
      var data_str = search_data[sub_index].textContent.toLowerCase();

      if (data_str && data_str.indexOf(search_input) != -1) {
        

        show = true;
      }
    }

    if (show) {
      $('tr.search-records').eq(index).show(100);
    } else {
      $('tr.search-records').eq(index).hide(100);
    }
  }
});
