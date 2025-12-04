<?php
  $title = "Create Invoice";
  $page = 'billing';
  $sub_page = 'invoice_detail';
  include 'pages/header.php';
?>

  <?php include "pages/sidebar.php"; ?>

			<section id="main-content">
				<section class="wrapper">
					<div class="col-lg-12 mt">
						<div class="row content-panel">
							<div class="col-lg-10 col-lg-offset-1">
								<div class="invoice-body">
									<div class="pull-left">
										<div class="container-fluid">
											<h1 class="page-header">Invoice <a href="invoice.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Create New Invoice</a></h1>
											<div class="container-fluid">
												<div class="col-xs-9 col-sm-10 col-md-10 col-lg-10 col-xs-offset-3 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 main">
													<div class="row">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:20px;">
															<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
															<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4997600402648823" data-ad-slot="1675608998"></ins>
															<script>
																(adsbygoogle = window.adsbygoogle || []).push({});
															</script>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
															Filter
														</a>
														<div class="clearfix"></div><br/>
														<div class="collapse" id="collapseExample">
															<div class="well" style="width:68.5%;">
																<form class="form-inline" id="searchForm">
																	<input id="invoiceNoSearch" type="text" class="form-control searchTxt" placeholder="Invoice No">
																	<input id="invoiceClientSearch" type="text" class="form-control searchTxt" placeholder="Client Name">
																	<input id="invoiceStartDateSearch" type="text" class="form-control searchTxt" placeholder="Start Date">
																	<input id="invoiceEndDateSearch" type="text" class="form-control searchTxt" placeholder="End Date">
																	<button id="invoiceSearchBtn" class="form-control searchTxt"> Search </button>
																</form>
															</div>
														</div>
														<div class="clearfix"></div>
														<table id="list2"></table>
														<div id="pager2" ></div>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
														<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
														<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4997600402648823" data-ad-slot="1675608998"></ins>
														<script>
															(adsbygoogle = window.adsbygoogle || []).push({});
														</script>
													</div>
												</div>
											</div>
										</div>
										<script>
											jQuery("#list2").jqGrid({
												url:'server.php',
												datatype: "json",
												colNames:['Invoice No','Customer Name', 'Crated Date', 'Invoice Total', 'Result'],
												colModel:[
												{name:'id',index:'id', align:"center"},
												{name:'client_name',index:'client_name', align:"center"},
												{name:'created',index:'created', align:"center"},
												{name:'invoice_total',index:'invoice_total', align:"center"},
												{name:'result',index:'result', align:"center", width:200}
												],
												rowNum:10,
												rowList:[10,20,30],
												pager: '#pager2',
												sortname: 'id',
												recordpos: 'left',
												viewrecords: true,
												sortorder: "DESC",
												height: '100%'
											});

											$(document).ready(function () {
												console.log("ready");
												$('.dropdown-toggle').dropdown();

												//datepicker

												$(function () {
												//$.fn.datepicker.defaults.format = "dd-mm-yyyy";
												$('#invoiceStartDateSearch').datepicker({
													startDate: '-3d',
													autoclose: true,
													clearBtn: true,
													todayHighlight: true
												});
											});
											});

											$(document).on('click','.print_class', function(){
												$.ajax({
													url: "print.php",
													data:{uuid:uuid},
													method:'post',
													success: function(result){
														$("#print_content").html(result);
														$('#myModal').modal('show');
													}
												});
											});
										</script>
										<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog" style="width:900px;height:auto" >
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Smart Invoice Print</h4>
													</div>
													<div class="modal-body" id="print_content">

													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="button" id="printBtn" onclick="printInvoice('print_content')"  class="btn btn-primary" data-loading-text="Printing...">Print</button>
													</div>
												</div>
											</div>
										</div>

										<!-- Modal -->
										<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="emailModalLabel">Send Invoice Email</h4>
													</div>
													<div class="modal-body" id="emailModalBody">
														<form id="emailForm" method="post" >
															<div class="form-group">
																<label for="exampleInputEmail1">Email Address: </label>
																<input type="email" class="form-control" name="invoiceEmail" id="invoiceEmail" placeholder="Enter email">
																<span class="help-block"></span>
															</div>
															<input type="hidden" class="form-control" name="invoiceUuid" id="invoiceUuid">
															<button data-loading-text="Email Sending..." id='email_btn' type="button" class="btn btn-success" autocomplete="off">Send Email!</button>
														</form>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="successEmail" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="emailModalLabel">Send Invoice Email</h4>
													</div>
													<div class="modal-body" id="emailModalBody">
														<h2 class="text-center">Email is Sent Successful.</h2>
														<p class="text-center success-icon"><i class="fa fa-thumbs-up"></i></p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
										<div style="display: none" id="emailFormContent">
											<form id="emailForm" method="post" >
												<div class="form-group">
													<label for="exampleInputEmail1">Email Address: </label>
													<input type="email" class="form-control" name="invoiceEmail" id="invoiceEmail" placeholder="Enter email">
													<span class="help-block"></span>
												</div>
												<input type="hidden" class="form-control" name="invoiceUuid" id="invoiceUuid">
												<button id='email_btn' type="button" class="btn btn-success">Send Email!</button>
											</form>
										</div>
										<script src="js/jquery.validate.min.js"></script>
										<script src="js/manageInvoice.js"></script>
										<script>

										</script>
										<div id="printerDiv" style="display: none"></div>
										<iframe id="PrintIframe" style="display: none"></iframe>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</section>

<?php include "pages/footer.php"; ?>
