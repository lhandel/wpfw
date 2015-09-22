<form action="<?php echo get_permalink(); ?>" method="post">

	<input type="text" name="firstname" value="<?php echo $name; ?>">
	<input type="submit">
	
</form>
<br/>
<table width="100%">
	<?php foreach($orders as $order): ?>
	<tr>
		<td><?php echo $order; ?></td>
	</tr>
	<?php endforeach; ?>
</table>