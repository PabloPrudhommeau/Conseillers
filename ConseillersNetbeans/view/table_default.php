<table>
	<?php
	foreach($table_header as $val) {
		?>
		<tr>
		<?php
		for($i = 0; $i < count($val); $i += 2) {
			?>
			<th colspan="<?php echo $val[$i+1]; ?>"><?php echo $val[$i] ?></th>
			<?php			
		}
		?>
		</tr>
		<?php
	}
	?>
	<?php
	foreach($table_data as $data_row) {
		?>
		<tr class="table-row">
		<?php
		foreach($data_row as $data_cell) {
			if(is_array($data_cell)) {
				foreach ($data_cell as $value) {
					?>
					<td><?php echo $value; ?> </td>
					<?php
				}
			} else {
				?>
				<td> <?php echo $data_cell; ?> </td>
				<?php
			}
		}
		?>
		</tr>
		<?php
	}

	?>
</table>