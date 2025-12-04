<!--sidebar start-->
<aside>
  <div id="sidebar" class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="centered"><a href="profile.php"><img src="../admin/img/ui-sam.jpg" class="img-circle" width="80"></a></p>
      <h5 class="centered"><a href="profile.php"><?php echo $company; ?></a></h5>
      <li class="mt">
        <a class="<?php echo isset($page) && $page == 'index' ? 'active' : '' ?>" href="index.php">
          <i class="fa fa-dashboard"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="">
        <!-- Will fix the side tab linking later -->
        <a class="<?php echo isset($page) && $page == 'branches' ? 'active' : '' ?>" href="branches.php">
          <i class="fa fa-cubes"></i>
          <span>Branches</span>
        </a>
      </li>
      <li class="">
        <!-- Will fix the side tab linking later -->
        <a class="<?php echo isset($page) && $page == 'budget' ? 'active' : '' ?>" href="budget.php">
          <i class="fa fa-briefcase"></i>
          <span>Budget</span>
        </a>
      </li>
      <li class="">
        <a class="<?php echo isset($page) && $page == 'customer_management' ? 'active' : '' ?>" href="manage_clients.php">
          <i class="fa fa-desktop"></i>
          <span>Customers</span>
        </a>
      </li>
      <li class="">
        <a class="<?php echo isset($page) && $page == 'client_search' ? 'active' : '' ?>" href="client_search.php">
          <i class="fa fa-search"></i>
          <span>Customer Search</span>
        </a>
      </li>
      <li class="">
        <a class="<?php echo isset($page) && $page == 'loans' ? 'active' : '' ?>" href="manage_loans.php">
          <i class="fa fa-cogs"></i>
          <span>Loans</span>
        </a>
      </li>

      <li class="">
        <a class="<?php echo isset($page) && $page == 'repayments' ? 'active' : '' ?>" href="repayments.php">
          <i class="fa fa-credit-card"></i>
          <span>Repayments</span>
        </a>
      </li>
      <!-- <li class="">
        <a class="<?php echo isset($page) && $page == 'employees' ? 'active' : '' ?>" href="employee_users.php">
          <i class="fa fa-users"></i>
          <span>Employees</span>
        </a>
      </li> -->

      <li class="sub-menu">
        <a href="javascript:;">
          <i class="fa fa-th"></i>
          <span>Payroll</span>
        </a>
        <ul class="sub">
          <li><a href="basic_table.html">Basic Table</a></li>
          <li><a href="responsive_table.html">Responsive Table</a></li>
          <li><a href="advanced_table.html">Advanced Table</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="javascript:;">
          <i class=" fa fa-bar-chart-o"></i>
          <span>Reports</span>
        </a>
        <ul class="sub">
          <li><a href="morris.html">Morris</a></li>
          <li><a href="chartjs.html">Chartjs</a></li>
          <li><a href="flot_chart.html">Flot Charts</a></li>
          <li><a href="xchart.html">xChart</a></li>
        </ul>
      </li>
      <li>
        <a href="inbox.html">
          <i class="fa fa-envelope"></i>
          <span>Mail </span>
          <span class="label label-theme pull-right mail-info">2</span>
        </a>
      </li>

      <li class="sub-menu">
        <a href="javascript:;">
          <i class="fa fa-cogs"></i>
          <span>Settings</span>
        </a>
        <ul class="sub">
          <li><a href="profile.php">Partner Profile</a></li>
          <li><a href="#">Partner Quote</a></li>
          <li><a href="#">Partner Invoice</a></li>
          <li><a href="#">Partner Banking Details</a></li>
          <li><a href="#">Partner Interest Chargers</a></li>
        </ul>
      </li>
    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>
