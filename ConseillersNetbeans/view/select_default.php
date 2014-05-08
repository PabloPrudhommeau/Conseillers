<select name="<?php echo $name; ?>" class="<?php echo $class; ?>">
	<?php
	foreach($option as $val) {
		?>
		<option><?php echo $val; ?></option>
		<?php
	}
	?>
</select>