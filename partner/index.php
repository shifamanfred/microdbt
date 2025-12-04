<?php

  $title = "Welcome Home | Partner | Your loan gateway system";
  $page = 'index';

  // DEBUG: troubleshooting employee session
  // session values are not showing

  include 'includes/header.php';
  include 'includes/classes.php';

  ?>

<?php require "includes/sidebar.php"; ?>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-9 main-chart">

            <div class="row mt">

              <!-- SERVER STATUS PANELS -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="darkblue-panel pn">
                  <div class="darkblue-header">
                    <h5>My Budget</h5>
                  </div>
                  <h1 class="mt"><i class="fa fa-briefcase fa-2x"></i></h1>
                  <footer>
                    <div class="centered">

                      <?php
                      $balance = PartnerBudget::getBudgetCredited($connect, $part_id);
                      $balance -= PartnerBudget::getBudgetDebited($connect, $part_id);
                      $set = new CompanySettings($connect);
                      ?>
                      <p class="text text-default">Credit: <?php echo $set->getCurrency() .' '. PartnerBudget::getBudgetCredited($connect, $part_id); ?></p>
                      <p class="text text-default">Debit : <?php echo $set->getCurrency() .' '. PartnerBudget::getBudgetDebited($connect, $part_id); ?></p>
                      <h5>Balance: <?php echo $set->getCurrency() .' '. $balance; ?></h5>


                    </div>
                  </footer>
                </div>
                <!--  /darkblue panel -->
              </div>

              <!-- SERVER STATUS PANELS -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <?php
                  // get number of loans
                  $result = LoanAccount::getAllLoans($connect, $part_id);
                  $num_loans = $result->num_rows;
                  $result->free_result();

                  // total number of disbursed loans
                  $result = LoanAccount::getAllDisbursedLoans($connect, $part_id);
                  $num_disbursed_loans = $result->num_rows;
                  $result->free_result();

                  // total sum of disbursed loans
                  $total_amount = LoanAccount::getTotalDisbursedLoanAmount($connect, $part_id);

                  // calculate percentage of disbursed loans from the total loans
                  if ($num_loans != 0) {
                    $percent = intval($num_disbursed_loans / $num_loans * 100);
                  } else {
                    $percent = 0;
                  }

                  ?>
                  <div class="grey-header">
                    <h5>DISBURSED LOANS &nbsp;&nbsp; <span class="badge"><?php echo $num_disbursed_loans; ?></span></h5>
                  </div>
                  <canvas id="serverstatus01" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: <?php echo $percent; ?>,
                        color: "#FF6B6B"
                      },
                      {
                        value: <?php echo (100 - $percent); ?>,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus01").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Amount:<br>
                      <?php echo $set->getCurrency() .' '. $total_amount; ?></p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2><?php echo $percent .'%'; ?></h2>
                    </div>
                  </div>
                </div>
                <?php unset($num_disbursed_loans); ?>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->

              <!-- SERVER STATUS PANELS -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <?php

                  // total number of approved loans
                  $result = LoanAccount::getAllApprovedLoans($connect, $part_id);
                  $num_approved_loans = $result->num_rows;
                  $result->free_result();

                  // total sum of disbursed loans
                  $total_amount = LoanAccount::getTotalApprovedLoanAmount($connect, $part_id);

                  // calculate percentage of disbursed loans from the total loans
                  if ($num_loans != 0) {
                    $percent = intval($num_approved_loans / $num_loans * 100);
                  } else {
                    $percent = 0;
                  }

                  ?>
                  <div class="grey-header">
                    <h5>APPROVED LOANS &nbsp;&nbsp; <span class="badge"><?php echo $num_approved_loans; ?></span></h5>
                  </div>
                  <canvas id="serverstatus02" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: <?php echo $percent; ?>,
                        color: "#FF6B6B"
                      },
                      {
                        value: <?php echo (100 - $percent); ?>,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus02").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Amount:<br>
                      <?php echo $set->getCurrency() .' '. $total_amount; ?></p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2><?php echo $percent .'%'; ?></h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->
              <?php unset($num_approved_loans); ?>
            </div>
            <!-- /row -->

            <div class="row">
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <?php

                  // total number of approved loans
                  $result = LoanAccount::getAllPendingLoans($connect, $part_id);
                  $num_pending_loans = $result->num_rows;
                  $result->free_result();

                  // total sum of disbursed loans
                  $total_amount = LoanAccount::getTotalPendingLoanAmount($connect, $part_id);

                  // calculate percentage of disbursed loans from the total loans
                  if ($num_loans != 0) {
                    $percent = intval($num_pending_loans / $num_loans * 100);
                  } else {
                    $percent = 0;
                  }
                  ?>

                  <div class="grey-header">
                    <h5>PENDING APPLICATIONS  &nbsp;&nbsp; <span class="badge"><?php echo $num_pending_loans; ?></span></h5>
                  </div>
                  <canvas id="serverstatus03" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: <?php echo $percent; ?>,
                        color: "#FF6B6B"
                      },
                      {
                        value: <?php echo (100 - $percent); ?>,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus03").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Amount:<br>
                      <?php echo $set->getCurrency() .' '. $total_amount; ?></p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2><?php echo $percent .'%'; ?></h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
                <?php unset($num_pending_loans); ?>
              </div>
              <!-- /col-md-4-->

              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <div class="grey-header">
                    <h5>EXPECTED FUNDS</h5>
                  </div>
                  <canvas id="serverstatus04" height="120" width="120"></canvas>
                  <?php

                  // total sum of disbursed loans
                  $total_amount = LoanAccount::getTotalDisbursedLoanAmount($connect, $part_id);

                  $total_repayable = LoanAccount::getTotalRepayableLoanAmount($connect, $part_id);

                  if ($total_amount != 0) {
                    $percent = intval(($total_repayable - $total_amount) / $total_amount * 100);
                  } else {
                    $percent = 0;
                  }

                  ?>
                  <script>
                    var doughnutData = [{
                        value: <?php echo $percent; ?>,
                        color: "#FF6B6B"
                      },
                      {
                        value: <?php echo (100 - $percent); ?>,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus04").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Amount: <br>
                      <?php echo $set->getCurrency() .' '. $total_repayable; ?></p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2><?php echo $percent .'%'; ?></h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->

              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <div class="grey-header">
                    <h5>ONTIME BORROWERS</h5>
                  </div>
                  <canvas id="serverstatus05" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: 70,
                        color: "#FF6B6B"
                      },
                      {
                        value: 30,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus05").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Usage<br/>Increase:</p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2>21%</h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->
            </div>
            <!-- /row -->

            <div class="row">
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <div class="grey-header">
                    <h5>HIGHEST BORROWERS</h5>
                  </div>
                  <canvas id="serverstatus06" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: 70,
                        color: "#FF6B6B"
                      },
                      {
                        value: 30,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus06").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Usage<br/>Increase:</p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2>21%</h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->

              <!-- DIRECT MESSAGE PANEL -->
              <div class="col-md-8 mb">
                <div class="message-p pn">
                  <div class="message-header">
                    <h5>DIRECT MESSAGE</h5>
                  </div>
                  <div class="row">
                    <div class="col-md-3 centered hidden-sm hidden-xs">
                      <img src="img/ui-danro.jpg" class="img-circle" width="65">
                    </div>
                    <div class="col-md-9">
                      <p>
                        <name>Dan Rogers</name>
                        sent you a message.
                      </p>
                      <p class="small">3 hours ago</p>
                      <p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                      <form class="form-inline" role="form">
                        <div class="form-group">
                          <input type="text" class="form-control" id="exampleInputText" placeholder="Reply Dan">
                        </div>
                        <button type="submit" class="btn btn-default">Send</button>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /Message Panel-->
              </div>
              <!-- /col-md-8  -->
            </div>
            <!-- /row -->
            <div class="row">
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <div class="grey-header">
                    <h5>HABITUAL BORROWERS</h5>
                  </div>
                  <canvas id="serverstatus07" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: 70,
                        color: "#FF6B6B"
                      },
                      {
                        value: 30,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus07").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Usage<br/>Increase:</p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2>21%</h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->

              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <div class="grey-header">
                    <h5>OVERDUE BORROWERS</h5>
                  </div>
                  <canvas id="serverstatus08" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: 70,
                        color: "#FF6B6B"
                      },
                      {
                        value: 30,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus08").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Usage<br/>Increase:</p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2>21%</h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <div class="grey-header">
                    <h5>BLACKLISTED BORROWERS</h5>
                  </div>
                  <canvas id="serverstatus09" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: 70,
                        color: "#FF6B6B"
                      },
                      {
                        value: 30,
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus09").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Usage<br/>Increase:</p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2>21%</h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->
              <div class="col-md-4 col-sm-4 mb">
                <div class="green-panel pn">
                  <?php
                  // get total number of borrowers
                  $result = Borrower::getBorrowerRecords($connect);
                  $num_borrowers = $result->num_rows;
                  $result->free_result();

                  $result = Borrower::getActiveBorrowerRecords($connect, $part_id);
                  $num_active_borrowers = $result->num_rows;
                  $result->free_result();

                  $percent = intval($num_active_borrowers / $num_borrowers * 100);
                  ?>
                  <div class="green-header">
                    <h5>POTENTIAL CUSTOMERS &nbsp;&nbsp;<span class="badge bg-inverse"><?php echo $num_borrowers - $num_active_borrowers; ?></span></h5>
                  </div>
                  <canvas id="serverstatus10" height="120" width="120"></canvas>


                  <script>
                    var doughnutData = [{
                        value: <?php echo $percent; ?>,
                        color: "#2b2b2b"
                      },
                      {
                        value: <?php echo (100 - $percent); ?>,
                        color: "#fffffd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus10").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <h3><?php echo $percent; ?>% ACTIVE</h3>
                  </div>
                </div>
              </div>
              <!-- /col-md-4 -->
            </div>
            <!-- /row -->
          </div>
          <!-- /col-lg-9 END SECTION MIDDLE -->
          <!-- **********************************************************************************************************************************************************
              RIGHT SIDEBAR CONTENT
              *********************************************************************************************************************************************************** -->
          <div class="col-lg-3 ds">
            <!--COMPLETED ACTIONS DONUTS CHART-->
            <div class="donut-main">
              <h4>COMPLETED ACTIONS & PROGRESS</h4>
              <canvas id="newchart" height="130" width="130"></canvas>
              <script>
                var doughnutData = [{
                    value: 70,
                    color: "#4ECDC4"
                  },
                  {
                    value: 30,
                    color: "#fdfdfd"
                  }
                ];
                var myDoughnut = new Chart(document.getElementById("newchart").getContext("2d")).Doughnut(doughnutData);
              </script>
            </div>
            <!--NEW EARNING STATS -->
            <div class="panel terques-chart">
              <div class="panel-body">
                <div class="chart">
                  <div class="centered">
                    <span>TODAY EARNINGS</span>
                    <strong>$ 890,00 | 15%</strong>
                  </div>
                  <br>
                  <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,564,455]"></div>
                </div>
              </div>
            </div>
            <!--new earning end-->
            <!-- RECENT ACTIVITIES SECTION -->
            <h4 class="centered mt">RECENT ACTIVITY</h4>
            <!-- First Activity -->
            <div class="desc">
              <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
              </div>
              <div class="details">
                <p>
                  <muted>Just Now</muted>
                  <br/>
                  <a href="#">Paul Rudd</a> purchased an item.<br/>
                </p>
              </div>
            </div>
            <!-- Second Activity -->
            <div class="desc">
              <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
              </div>
              <div class="details">
                <p>
                  <muted>2 Minutes Ago</muted>
                  <br/>
                  <a href="#">James Brown</a> subscribed to your newsletter.<br/>
                </p>
              </div>
            </div>
            <!-- Third Activity -->
            <div class="desc">
              <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
              </div>
              <div class="details">
                <p>
                  <muted>3 Hours Ago</muted>
                  <br/>
                  <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
                </p>
              </div>
            </div>
            <!-- Fourth Activity -->
            <div class="desc">
              <div class="thumb">
                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
              </div>
              <div class="details">
                <p>
                  <muted>7 Hours Ago</muted>
                  <br/>
                  <a href="#">Brando Page</a> purchased a year subscription.<br/>
                </p>
              </div>
            </div>
            <!-- USERS ONLINE SECTION -->
            <h4 class="centered mt">TEAM MEMBERS ONLINE</h4>
            <!-- First Member -->
            <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="img/ui-divya.jpg" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a href="#">DIVYA MANIAN</a><br/>
                  <muted>Available</muted>
                </p>
              </div>
            </div>
            <!-- Second Member -->
            <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="img/ui-sherman.jpg" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a href="#">DJ SHERMAN</a><br/>
                  <muted>I am Busy</muted>
                </p>
              </div>
            </div>
            <!-- Third Member -->
            <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="img/ui-danro.jpg" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a href="#">DAN ROGERS</a><br/>
                  <muted>Available</muted>
                </p>
              </div>
            </div>
            <!-- Fourth Member -->
            <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="img/ui-zac.jpg" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a href="#">Zac Sniders</a><br/>
                  <muted>Available</muted>
                </p>
              </div>
            </div>
            <!-- CALENDAR-->
            <div id="calendar" class="mb">
              <div class="panel green-panel no-margin">
                <div class="panel-body">
                  <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                    <div class="arrow"></div>
                    <h3 class="popover-title" style="disadding: none;"></h3>
                    <div id="date-popover-content" class="popover-content"></div>
                  </div>
                  <div id="my-calendar"></div>
                </div>
              </div>
            </div>
            <!-- / calendar -->
          </div>
          <!-- /col-lg-3 -->
        </div>
        <!-- /row -->
      </section>
    </section>
    <!--main content end-->

    <?php require "includes/footer.php"; ?>
