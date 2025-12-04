<!--header end-->

<!-- sidebar beginning -->
<aside>
  <div id="sidebar" class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="profile centered"><a class="profile" href="profile.php"><img src="img/ui-sam.jpg" class="img-circle" width="80"></a></p>
      <h5 class="centered"><a class="profile" href="profile.php"><?php echo $first_name . ' ' . $last_name?></a></h5>
      <li class="mt">
        <a class="<?php echo isset($page) && $page == 'index' ? 'active' : '' ?>" href="index.php">
          <i class="fa fa-dashboard"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="sub-menu">
        <a class="<?php echo isset($page) && $page == 'partner' ? 'active' : '' ?>" href="javascript:;">
          <i class="fa fa-desktop"></i>
          <span>Partners</span>
        </a>
        <ul class="sub">
          <li class="<?php echo isset($sub_page) && $sub_page == 'view_partners' ? 'active' : '' ?>"><a href="view_partners.php">View Partners</a></li>
          <li class="<?php echo isset($sub_page) && $sub_page == 'view_employees' ? 'active' : '' ?>"><a href="view_employees.php">View Partner Employees</a></li>
          <li class="<?php echo isset($sub_page) && $sub_page == 'add_partner' ? 'active' : '' ?>"><a href="add_partner.php">Add a Partner</a></li>
          <li class="<?php echo isset($sub_page) && $sub_page == 'add_user' ? 'active' : '' ?>"><a href="add_user.php">Add Partner Employee</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a class="<?php echo isset($page) && $page == 'billing' ? 'active' : '' ?>" href="javascript:;">
          <i class="fa fa-list-alt"></i>
          <span>Billing of Partners</span>
        </a>
        <ul class="sub">
          <!-- <li class="<?php echo isset($sub_page) && $sub_page == 'quote' ? 'active' : '' ?>"><a href="quote.php">Quotes</a></li> -->
          <li class="<?php echo isset($sub_page) && $sub_page == 'invoice' ? 'active' : '' ?>"><a href="invoice.php">Invoices</a></li>
          <li class="<?php echo isset($sub_page) && $sub_page == 'create_invoice' ? 'active' : '' ?>"><a href="create_invoice.php">Create Invoice</a></li>
          <li class="<?php echo isset($sub_page) && $sub_page == 'arrears' ? 'active' : '' ?>"><a href="arrears.php">Arrears</a></li>
          <li class="<?php echo isset($sub_page) && $sub_page == 'reports' ? 'active' : '' ?>"><a href="reports.php">Reports</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a class="<?php echo isset($page) && $page == 'products' ? 'active' : '' ?>" href="javascript:;">
          <i class="fa fa-desktop"></i>
          <span>Products</span>
        </a>
        <ul class="sub">
          <li class="<?php echo isset($sub_page) && $sub_page == 'add_product' ? 'active' : '' ?>"><a href="add_product.php">Add Product</a></li>
          <li class="<?php echo isset($sub_page) && $sub_page == 'manage_products' ? 'active' : '' ?>"><a href="manage_product.php">Manage Products</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a class="" href="javascript:;">
          <i class="fa fa-book"></i>
          <span>User Management</span>
        </a>
        <ul class="sub">
          <li><a href="blank.html">Add Admin User</a></li>
          <li><a href="login.html">View Admin Users</a></li>
          <li><a href="login.html">Suspend Admin User</a></li>
          <li><a href="lock_screen.html">Add Partner User</a></li>
          <li><a href="profile.html">View Partner Users</a></li>
          <li><a href="invoice.html">User Roles</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a class="" href="javascript:;">
          <i class="fa fa-tasks"></i>
          <span>Customer Management</span>
        </a>
        <ul class="sub">
          <li><a href="form_component.html">Overdue Customers</a></li>
          <li><a href="advanced_form_components.html">Slow Payers</a></li>
          <li><a href="form_validation.html">Habitual Borrowers</a></li>
          <li><a href="contactform.html">Blacklist</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a class="" href="javascript:;">
          <i class="fa fa-th"></i>
          <span>Payrol</span>
        </a>
        <ul class="sub">
          <li><a href="basic_table.html">Basic Table</a></li>
          <li><a href="responsive_table.html">Responsive Table</a></li>
          <li><a href="advanced_table.html">Advanced Table</a></li>
        </ul>
      </li>
      <li>
        <a class="" href="inbox.html">
          <i class="fa fa-envelope"></i>
          <span>Internal Mail </span>
          <span class="label label-theme pull-right mail-info">2</span>
        </a>
      </li>
      <li class="">
        <a class="<?php echo isset($page) && $page == 'settings' ? 'active' : '' ?>" href="settings.php">
          <i class="fa fa-cog"></i>
          <span>Settings</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="javascript:;">
          <i class=" fa fa-bar-chart-o"></i>
          <span>Charts</span>
        </a>
        <ul class="sub">
          <li><a href="morris.html">Morris</a></li>
          <li><a href="chartjs.html">Chartjs</a></li>
          <li><a href="flot_chart.html">Flot Charts</a></li>
          <li><a href="xchart.html">xChart</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="javascript:;">
          <i class="fa fa-comments-o"></i>
          <span>Chat Room</span>
        </a>
        <ul class="sub">
          <li><a href="lobby.html">Lobby</a></li>
          <li><a href="chat_room.html"> Chat Room</a></li>
        </ul>
      </li>
      <li>
        <a href="google_maps.html">
          <i class="fa fa-map-marker"></i>
          <span>Google Maps </span>
        </a>
      </li>
    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>
