<ul class="widget-global-feature">
    <li>
        <a href="#">Fonctionnalités</a>
        <ul class="widget-global-feature-list">
			<?php
			foreach ($links as $key => $val) {
				?>
				<li><a href="<?php echo __SITE_ROOT . $val; ?>"><?php echo $key; ?></a></li>
				<?php
			}
			?>
        </ul>
    </li>
</ul>