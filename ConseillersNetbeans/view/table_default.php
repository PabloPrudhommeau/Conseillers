<table>
	<tr>
		<?php
		foreach($table_header as $val) {
			?>
			<td><?php echo $val ?></td>
			<?php
		}
		?>
	</tr>
	<?php
	foreach($table_data as $data_row) {
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