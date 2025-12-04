<?php
$title = "Employee Roles";
$page = "employees";
$sub_page = 'employee_roles';

include 'includes/header.php';
include "includes/sidebar.php";
include "includes/classes.php";
include "includes/functions.php";

// consider query for roles
$query = 'SELECT * FROM employee_roles ';
$query .= 'GROUP BY role_name';

?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper site-min-height">
    <div class="col-lg-12 mt">
      <div class="row content-panel mb">
        <?php include "includes/top_panel.php"; ?>
      </div>

      <div class="row content-panel">
        <table class="table table-striped table-advance table-hover">
          <thead>
            <tr>
              <th>Permission Module</th>
              <th></th>
              <th>Level 1</th>
              <th>Level 2</th>
              <th>Level 3</th>
              <th>Level 4</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $connect->query($query);
            if (!$result) {?>
              <td class="text text-danger" colspan="4"><?php echo 'DATA RETRIEVAL FAILED! Please contact the webmaster - '. $connect->error . '<br>'. $query ?></td>
            <?php
          } else {
            while ($rec = $result->fetch_assoc()) {
              $role_obj = new EmployeeRole($connect, $rec['id']);
            ?>
            <tr class="<?php echo $role_obj->id; ?>">
              <?php
              // string manipulation from the database data
              $module_name = str_replace("_", " ", $role_obj->name);
              $module_name = str_replace("create", "add", $module_name);
              $module_name = str_replace("default", "access", $module_name);
              $module_name = str_replace("update", "modify", $module_name);
              $module_name = str_replace("delete", "remove", $module_name);

              $module_name = ucwords($module_name);
              ?>
              <td><?php echo $module_name; ?></td>

              <td><button type="button" class="btn btn-warning btn-xs clear-select" title="Clear Selection: Remove all level access" name="<?php echo $role_obj->name; ?>"> <i class="fa fa-eraser"></i> </button></td>

              <?php
              $num_roles = $role_obj->roleLevels($connect);
              for ($ind = 1; $ind <= $num_roles; ) {
                $inner_obj = EmployeeRole::getRoleByLevel($connect, $role_obj->name, $ind);
              ?>
              <td class="<?php echo $role ?>">
                <div class="text-center">
                  <input type="<?php echo $num_roles == 1 ? 'checkbox': 'radio' ?>" style="width: 10px" class="checkbox" title="<?php echo $inner_obj->desc; ?>" name="<?php echo $inner_obj->name; ?>" value="<?php echo $ind++; ?>">
                </div>
              </td>
              <?php
              }

              while ($ind++ <= 4) {?>
              <td></td>
              <?php

              }
              ?>

            </tr>
            <?php }
            }
            ?>
          </tbody>
        </table>

        <div class="text-center">
          <button class="btn btn-theme" style="width: 150px;">Save Settings</button>
        </div>
      </div>
    </div>
  </section>
</section>

<?php $page = $sub_page; ?>

<?php include "includes/footer.php"; ?>
