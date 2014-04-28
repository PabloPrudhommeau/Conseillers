<table>
	<th>
		<?php
		foreach($header as $key => $val) {
			?>
			<td><?php echo $val['label'] ?></td>
			<?php
		}
		?>
	</th>
	<?php
	foreach($data as $data_row) {
		?>
		<tr class="table-row">
		<?php
		foreach($data_row as $data_cell) {
			?>
			<td> <?php echo $data_cell; ?> </td>
			<?php
		}
		?>
		</tr>
		<?php
	}

	?>
</table>