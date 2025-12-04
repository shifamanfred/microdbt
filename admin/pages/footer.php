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
<script src="lib/jquery/jquery.min.js"></script>

<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="lib/jquery.scrollTo.min.js"></script>
<script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="lib/jquery.sparkline.js"></script>
<!--common script for all pages-->
<script src="lib/common-scripts.js"></script>
<script type="text/javascript" src="lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="lib/gritter-conf.js"></script>
<!--script for this page-->
<script src="lib/sparkline-chart.js"></script>
<script src="lib/zabuto_calendar.js"></script>
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
if (isset($page)) {

  // link javascript file for add partner page
  if ($page == 'add_partner') {?>
    <script src="js/add_partner.js"></script>
    <?php
  }

  if ($page == 'add_user') {?>
    <script src="js/add_user.js"></script>
    <?php
  }

  // link javascript file for create invoice or proforma invoice page
  // and load partner data from php to javascript
  if ($page == 'create_invoice' || $page == 'proforma') { ?>
    <script>

    var partners = [
    <?php

      if (isset($partners)) {
        for ($i = 0; $i < count($partners); $i++) {?>
          <?php echo '{';?>
            id : <?php echo $partners[$i]->id; ?>
          , name : "<?php echo $partners[$i]->trade_name; ?>"
          , address : "<?php echo $partners[$i]->postal; ?>"
          <?php echo '}';
          if ($i != count($partners) - 1) {
            echo ',';
          }
          ?>
        <?php }
      }
    ?>
    ];

    var products = [
    <?php
    // load product data from php to javascript

      for ($i = 0; $i < count($products); $i++) {?>
        <?php echo '{';?>
          code : "<?php echo $products[$i]->code; ?>"
        , name : "<?php echo $products[$i]->pro_name; ?>"
        , desc : "<?php echo $products[$i]->pro_desc; ?>"
        , quantity : <?php echo ($products[$i]->quantity == NULL) ? 0 : $products[$i]->quantity; ?>
        , fee : <?php echo $products[$i]->mrp; ?>
        <?php echo '}';
        if ($i != count($products) - 1) {
          echo ',';
        }
        ?>
      <?php }
    ?>
    ];

    </script>

    <script src="js/create_invoice.js"></script>
    <?php
  }

  if ($page == 'settings') {?>
    <script src="js/settings.js"></script>
  <?php }
}
?>
</body>

</html>
