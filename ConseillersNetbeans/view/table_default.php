<table class="table-component table-default">
	<caption><?php echo $caption; ?></caption>
	<tr>
		<?php
		foreach ($table_header as $val) {
			?>
			<th><?php echo $val; ?></th>
			<?php
		}
		?>
	</tr>
	<?php
	foreach ($table_data as $key => $data_row) {
		?>
		<tr class="table-row" id="etudiant_<?php echo $key; ?>">
			<?php
			foreach ($data_row as $data_cell) {
				if (is_array($data_cell)) {
					?>
					<td>
						<table>
							<tr>
								<?php
								foreach ($data_cell as $value) {
									?>
									<td><?php echo $value; ?> </td>
									<?php
								}
								?>
							</tr>
						</table>
					</td>
					<?php
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