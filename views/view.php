<style>
.overlay{
	width: 100%;
	height: 100%;
	left: 0;
	right: 0;
	position: fixed;
	top: 0;
	left: 0;
	z-index: 2469;
	background-color: rgba(0,0,0,.5);
	display: none;
}
.overlay .box{
	width: 350px;
	min-height: 100px;
	background-color: #fff;
	border-radius: 4px;
	margin-left: auto;
	margin-right: auto;
	margin-top: 7%;
	border: 5px solid #4c4c4c;
}
</style>

<div class="overlay">
	<div class="box">
		<h3 style="font-weight: 300; text-align:center;">Skapa aktivitet</h3>
		<form action="" method="post">
		<div style="width: 270px; margin-left:auto; margin-right:auto;">
			<p>
			Namn <input type="text" name="title">
			</p>
			<p>
			Typ <select name="type">
				<option value="countdown">Nedräkning</option>
				<option value="request">Förfrågan</option>
			</select>
			</p>
			<input type="submit" name="createForm" class="button-primary" value="Spara" style="margin-bottom:15px; margin-left:auto; margin-right:auto;">
		</div>
		</form>
	</div>
</div>

<div class="wrap">
	
	
	<h2>Bokningar <a href="#" onclick="jQuery('.overlay').fadeIn();" class="add-new-h2 thickbox">Skapa ny aktivitet</a></h2>
	<br/>
	
	<table class="wp-list-table widefat fixed posts" cellspacing="0">
		<thead>
		<tr>
			<th scope="col" class="manage-column">
				Namn
			</th>
			<th scope="col" class="manage-column">
				Typ
			</th>
			<th scope="col" class="manage-column">
				Boka-knapp
			</th>
		</tr>
		</thead>
	
		<tfoot>
		<tr>
			<th scope="col" class="manage-column">
				Namn
			</th>
			<th scope="col" class="manage-column">
				Typ
			</th>
			<th scope="col" class="manage-column">
				Boka-knapp
			</th>
		</tr>
		</tfoot>
	
		<tbody id="the-list" data-wp-lists="list:post">

			<tr <?php $i=1; if($i % 2 == 0) echo 'class="alternate"'; ?>>
				<td class="title column-title">
					<strong>
						<a class="row-title" href="#">
							Test1
						</a>
					</strong>
					<div class="row-actions">
						<span class="edit">
						<a href="#">
						Redigera</a> | </span>
						<span class="delete">
						<a href="admin.php?page=AB_bookings&delete=">Ta bort</a>
						</span>
					</div>
				</td>
				<td>
					
				</td>
				<td>
					<span style="font-weight:bold;line-height:35px;">Stor: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" id=#]'>
					<span style="font-weight:bold; line-height:35px;">Liten: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" size="small" id=#]'>
				</td>
			</tr><?php $i++; ?>
			<tr <?php if($i % 2 == 0) echo 'class="alternate"'; ?>>
				<td class="title column-title">
					<strong>
						<a class="row-title" href="#">
							Test1
						</a>
					</strong>
					<div class="row-actions">
						<span class="edit">
						<a href="#">
						Redigera</a> | </span>
						<span class="delete">
						<a href="admin.php?page=AB_bookings&delete=">Ta bort</a>
						</span>
					</div>
				</td>
				<td>
					
				</td>
				<td>
					<span style="font-weight:bold;line-height:35px;">Stor: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" id=#]'>
					<span style="font-weight:bold; line-height:35px;">Liten: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" size="small" id=#]'>
				</td>
			</tr><?php $i++; ?>
			<tr <?php if($i % 2 == 0) echo 'class="alternate"'; ?>>
				<td class="title column-title">
					<strong>
						<a class="row-title" href="#">
							Test1
						</a>
					</strong>
					<div class="row-actions">
						<span class="edit">
						<a href="#">
						Redigera</a> | </span>
						<span class="delete">
						<a href="admin.php?page=AB_bookings&delete=">Ta bort</a>
						</span>
					</div>
				</td>
				<td>
					
				</td>
				<td>
					<span style="font-weight:bold;line-height:35px;">Stor: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" id=#]'>
					<span style="font-weight:bold; line-height:35px;">Liten: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" size="small" id=#]'>
				</td>
			</tr><?php $i++; ?>
			<tr <?php if($i % 2 == 0) echo 'class="alternate"'; ?>>
				<td class="title column-title">
					<strong>
						<a class="row-title" href="#">
							Test1
						</a>
					</strong>
					<div class="row-actions">
						<span class="edit">
						<a href="#">
						Redigera</a> | </span>
						<span class="delete">
						<a href="admin.php?page=AB_bookings&delete=">Ta bort</a>
						</span>
					</div>
				</td>
				<td>
					
				</td>
				<td>
					<span style="font-weight:bold;line-height:35px;">Stor: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" id=#]'>
					<span style="font-weight:bold; line-height:35px;">Liten: </span><input type="text" readonly="readonly" size="7" value='[book_button text="Boka nu" size="small" id=#]'>
				</td>
			</tr><?php $i++; ?>
	
			
		</tbody>
	</table>

</div>