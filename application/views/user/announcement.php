<?php 
	$announcement = getAnnouncement(getSessionUser());
	if(!empty($announcement)):
?>
<section class="alert-wrapper">
<div class="alert alert-dismissable alert-pmj">
  <button aria-hidden="true" class="close" data-dismiss="alert" type="button">&#215;</button>
  <h3 class="pink text-center"><?php echo $announcement[0]->title;?></h3>
  <p class="text-center"><?php echo $announcement[0]->content?></p>
</div>
</section>
<?php endif; ?>