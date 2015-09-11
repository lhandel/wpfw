<div class="wrap">
	<ul class="wpsubmenu">
		<li><a href="admin.php?page=testCtrl&page2=listPage">Lista</a></li>
		<li><a href="#">Export</a></li>
	</ul>
	<h2>Välkommen <?php echo $name; ?></h2>
	(<?php echo $from_cache; ?>)<br/>
	<?php echo $string; ?>
	<?php $this->load->view('content'); ?>
</div>