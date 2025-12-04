<!--footer start-->
<footer class="site-footer">
  <div class="text-center">
    <p>
      &copy; Copyrights <strong>MONEYFlux</strong>. All Rights Reserved
    </p>
    <div class="credits">
      <!--
      You are NOT allowed to delete the credit link to TemplateMag with free version.
      You can delete the credit link only if you bought the pro version.
      Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/dashio-bootstrap-admin-template/
      Licensing information: https://templatemag.com/license/
    -->
    Created for MONETFlux by <a href="https://gestured.com.na/">GESTURED</a>
  </div>
  <a href="index.html#" class="go-top">
    <i class="fa fa-angle-up"></i>
  </a>
</div>
</footer>
<!--footer end-->
</section>
<!-- js placed at the end of the document so the pages load faster -->
<script src="../admin/lib/jquery/jquery.min.js"></script>

<script src="../admin/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../admin/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="../admin/lib/jquery.scrollTo.min.js"></script>
<script src="../admin/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../admin/lib/jquery.sparkline.js"></script>
<!--common script for all pages-->
<script src="../admin/lib/common-scripts.js"></script>
<script type="../admin/text/javascript" src="lib/gritter/js/jquery.gritter.js"></script>
<script type="../admin/text/javascript" src="lib/gritter-conf.js"></script>
<!--script for this page-->
<script src="../admin/lib/sparkline-chart.js"></script>
<script src="../admin/lib/zabuto_calendar.js"></script>

<?php if (isset($enable_datepicker) && $enable_datepicker) { ?>
  <script src="../admin/lib/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="../admin/lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script type="text/javascript" src="../admin/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="../admin/lib/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="../admin/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="../admin/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="../admin/lib/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="../admin/lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  <script src="../admin/lib/advanced-form-components.js"></script>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
  var unique_id = $.gritter.add({
    // (string | mandatory) the heading of the notification
    title: 'Welcome to Dashio!',
    // (string | mandatory) the text inside the notification
    text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo.',
    // (string | optional) the image to display on the left
    image: 'img/ui-sam.jpg',
    // (bool | optional) if you want it to fade out on its own or just sit there
    sticky: false,
    // (int | optional) the time you want it to be alive for before fading out
    time: 8000,
    // (string | optional) the class name you want to apply to that specific message
    class_name: 'my-sticky-class'
  });

  return false;
});
</script>
<script type="application/javascript">
$(document).ready(function() {
  $("#date-popover").popover({
    html: true,
    trigger: "manual"
  });
  $("#date-popover").hide();
  $("#date-popover").click(function(e) {
    $(this).hide();
  });

  $("#my-calendar").zabuto_calendar({
    action: function() {
      return myDateFunction(this.id, false);
    },
    action_nav: function() {
      return myNavFunction(this.id);
    },
    ajax: {
      url: "show_data.php?action=1",
      modal: true
    },
    legend: [{
      type: "text",
      label: "Special event",
      badge: "00"
    },
    {
      type: "block",
      label: "Regular event",
    }
  ]
});
});

function myNavFunction(id) {
  $("#date-popover").hide();
  var nav = $("#" + id).data("navigation");
  var to = $("#" + id).data("to");
  console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
}
</script>

<?php

// load filtering scripts where necessary
if (isset($filter) && $filter) { ?>
	<script src="js/table_filter.js"></script>
<?php }

// load scripts according to the page loaded

if (isset($page)) {

  if ($page == 'change_password') { ?>
    <script src="js/change_password.js"></script>
  <?php }

  if ($page == 'client_profile') { ?>
    <script>
      $('#cancel_btn').click(function () {
        $('div.panel-heading ul li').attr('class', '');
        $('div.panel-heading ul li').attr('aria-expanded', 'false');
        $('div.panel-heading ul li').eq(0).attr('class', 'active');
        $('div.panel-heading ul li').eq(0).attr('aria-expanded', 'true');
      });
    </script>
  <?php }

  if ($page == 'view_budget') {?>
    <script src="js/budget.js"></script>
  <?php }

  if ($page == 'add_client') {

		$borrower_results = Borrower::getBorrowerRecords($connect);

		// pull all borrower records from db if available
		if ($borrower_results) {
?>
<script>
			var borrowers = [
			<?php
			// load all borrower data from php to javascript

			$count = 1;
			$result_rows = $borrower_results->num_rows;

				while ($rec = $borrower_results->fetch_assoc()) {?>
					<?php echo '{';?>
					id_num : <?php echo $rec['id_number']; ?>
          , name : "<?php echo $rec['last_name']; ?>"
          , edit : <?php echo $rec['partner_id'] == $part_id ? 'true' : 'false'; ?>
					<?php echo '}';
					if ($count < $result_rows) {
						echo ',';
					}
				}
			$borrower_results->free_result();
			?>
			];
</script>

      <script src="js/add_client.js"></script>
  <?php }

	}

  if ($page == 'confirm_client_details') {?>
    <script src="js/confirm_client_details.js"></script>
  <?php }


  if ($page == 'add_loan') {?>
    <script>
    function calculateEMI() {
      var loan_amount = document.myform.loan_amount.value;
      if (!loan_amount)
      loan_amount = '0';

      var loan_percent = document.myform.loan_percent.value;
      if (!loan_percent)
      loan_percent = '0';

      var installments = document.myform.installments.value;
      if (!installments)
      installments = '0';

      // var debit_order_fee = document.myform.debit_order_fee.value;

      var namfisa_fee = document.myform.namfisa_fee.value;
      if (!namfisa_fee)
      namfisa_fee = '0';


      var loan_amount = parseFloat(loan_amount);
      var loan_percent = parseFloat(loan_percent);
      var installments = parseFloat(installments);
      // var debit_order_fee = parseFloat(debit_order_fee);
      var namfisa_fee = parseFloat(namfisa_fee);


      var total = loan_amount + (loan_amount*(loan_percent/100)) + namfisa_fee;

      document.myform.total_amount.value = parseFloat(total).toFixed(2);
      var emi = parseFloat((total/installments)).toFixed(2);
      document.myform.borrower_emi.value = emi;
    }

    var loan_alias = '<?php echo $loan_alias; ?>';
    var loan_alias2 = '<?php echo $loan_alias2 ?>';
    </script>

    <script src="js/add_loan.js"></script>
  <?php } ?>

  <?php if ($page == 'branch_users') {?>
    <script type="application/javascript">
      var action_string = 'proc_form.php?ops=assign+user&part_id=<?php echo $part_id; ?>';
      // change the forms' attributes in the form on change branch button click
      $('button.change-branch').click(function () {
        $('form.branch-form').attr('action', action_string + '&emp_id=' + $(this).val());
      });
    </script>

    <script type="text/javascript" src="js/branch_users.js"></script>
  <?php } ?>

	<?php if ($page == 'financial_details') {?>
	<script src="js/financial_details.js"></script>
	<?php } ?>

  <?php if ($page == 'disburse_loan') {?>
	<script src="js/disburse_loan.js"></script>
	<?php } ?>

  <?php if ($page == 'employee_roles') {?>
	<script src="js/employee_roles.js"></script>
	<?php } ?>

  <?php if ($page == 'manage_clients') { ?>
  <script src="js/manage_clients.js"></script>
  <?php } ?>

  <?php if ($page == 'search_client_page') { ?>
  <script src="js/client_search.js"></script>
  <?php } ?>

  <?php if ($page == 'view_loans') { ?>
  <script src="js/manage_loans.js"></script>
  <?php } ?>

<?php } ?>

</body>

</html>
