<table class="table-manage-data">
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
	<tr class="table-row" id="table-hidden-row">
		<?php
		foreach($table_hidden_data as $data_row) {
			?>
			<td>
				<?php
				if(is_array($data_row)) {
					?>
					<select>
					<?php
					foreach ($data_row as $value) {
						?>
							<option><?php echo $value->libelle; ?></option>
						<?php
					}
					?>
					</select>
					<?php
				} else {
					?>
					<input class="table-manage-data" size="auto" type="text" name="<?php echo $data_row; ?>" />
					<?php
				}
				?>
			</td>
			<?php
		}
		?>
	</tr>

	<?php
	foreach ($table_data as $key => $data_row) {
		?>
		<tr class="table-row" id="enseignant_<?php echo $key; ?>">
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