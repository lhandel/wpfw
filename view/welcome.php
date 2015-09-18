<div class="wrap">
	<ul class="wpsubmenu">
		<li><a href="admin.php?page=testCtrl&page2=listPage">Lista</a></li>
		<li><a href="#">Export</a></li>
	</ul>
	<h2>Välkommen <?php echo $name; ?></h2>
	(<?php echo $from_cache; ?>)<br/>
	<?php echo $string; ?>
	<table class=" widefat striped ">
<thead>
    <tr>
        <th>RegId</th>
        <th>Name</th>       
        <th>Email</th>
    </tr>
</thead>
<tfoot>
    <tr>
    <th>RegId</th>
    <th>Name</th>
    <th>Email</th>
    </tr>
</tfoot>
<tbody>
   <tr class="odd">
     <td>1</td>
     <td>Lidwg</td>
     <td>min epost</td>
   </tr>
   <tr>
     <td>2</td>
     <td>Petter</td>
     <td>min epost</td>
   </tr>
</tbody>
</table>
<div class='tablenav-pages'>
    <a href="#">1 </a>
   <a href="#">2</a>
    	<li><a href="#">3 </a></li>
    	<li><a href="#">4 </a></li>
    </ul>
</div>
</div>