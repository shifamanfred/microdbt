$('div.table-panel').hide();


// do the actual search
$('#search-btn').click(function () {

  // TODO: get the search value here
  var search_input_text = $('#search-input').val();

  if (!search_input_text || search_input_text == '') {
    $('div.table-panel').hide(300);
  } else {
    // load the results and pass in the data to search for
    $('#results-body').text('Loading...');
    
    $('#results-body').load('client_results.php', {
      searchText: search_input_text
    });

    $('div.table-panel').show(300);
  }



});
