<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "branches";
$sub_page = "edit_branch";

if (isset($_GET['branch_id'])) {
  $branch_id = intval($_GET['branch_id']);
} else {
  header('Location: branches.php?edit=null');
  exit;
}

include 'includes/header.php';
include 'includes/classes.php';

$branch_obj = new Branch($connect, $branch_id);

?>

<?php require "includes/sidebar.php"; ?>
<!--sidebar end-->
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<section id="main-content">
	<section class="wrapper">
		<div class="col-lg-12 mt">
			<div class="row content-panel">
				<div class="col-lg-10 col-lg-offset-1">
					<?php include "includes/top_panel.php"; ?>
					<div class="invoice-body">
						<div class="container-fluid">
							<h1 class="page-header">Add a Branch: <a href="add-client.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Branches</a></h1>
							<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 main">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
									<form class="form-horizontal style-form" action="proc_form.php?ops=edit+branch&part_id=<?php echo $part_id; ?>&branch_id=<?php echo $branch_obj->id; ?>" method="post">
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Name</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="Branch Name" name="branch_name" value="<?php echo $branch_obj->name; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Location</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="Location" name="location" value="<?php echo $branch_obj->loc; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Town</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="Town" name="town" value="<?php echo $branch_obj->town; ?>">
											</div>
										</div>
										<div class="form-group text-center">
											<button class="btn btn-success" type="submit">Save Branch</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>

<?php require "includes/footer.php"; ?>
