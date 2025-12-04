<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "branches";
$sub_page = "add_branch";
include 'includes/header.php';

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
									<form class="form-horizontal style-form" action="proc_form.php?ops=add+branch&part_id=<?php echo $part_id; ?>" method="post">
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Name</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="Branch Name" name="branch_name">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Location</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="Location" name="location">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Town</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="Town" name="town">
											</div>
										</div>
										<div class="form-group text-center">
											<button class="btn btn-success" type="submit">Add Branch</button>
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
