<?php
if (isset($_GET['msg'])) {
  if (strpos(strtolower($_GET['msg']), 'success') !== false && strpos(strtolower($_GET['msg']), 'file error') === false) {
?>
<div class="alert alert-success alert-dismissible mt" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $_GET['msg']; ?>
</div>
<?php } else if (strpos(strtolower($_GET['msg']), 'file error') !== false) {?>
<div class="alert alert-warning alert-dismissible mt" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $_GET['msg']; ?>
</div>
<?php } else {?>
<div class="alert alert-danger alert-dismissible mt" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $_GET['msg']; ?>
</div>
<?php } ?>
<?php } ?>
