<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?php echo $title;?></title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo __SITE_ROOT.'/assets/img/favicon.ico'; ?>" /> 
		<link rel="shortcut icon" type="image/png" href="<?php echo __SITE_ROOT.'/assets/img/favicon.ico'; ?>" /> 
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<link rel="stylesheet" href="<?php echo __SITE_ROOT.'/assets/css/reset.css'; ?>" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo __SITE_ROOT.'/assets/css/style.css'; ?>" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo __SITE_ROOT.'/assets/css/widgets.css'; ?>" type="text/css" media="screen">
		
		<script type="text/javascript" src="<?php echo __SITE_ROOT.'/assets/js/jquery-1.10.2.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo __SITE_ROOT.'/assets/js/jquery-ui-1.10.4.custom.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo __SITE_ROOT.'/assets/js/jquery.easing.1.3.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo __SITE_ROOT.'/assets/js/navigation.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo __SITE_ROOT.'/assets/js/widgets.js'; ?>"></script>

	</head>
	<body id="page1">
		<!--==============================header=================================-->
		<header>
			<div class="menu-row">
				<div class="main zerogrid">
					<nav class="wrapper">
					<?php echo $widget_global_feature;?>
						<ul class="menu">
							<li><a class="active" href="<?php echo __SITE_ROOT.'/';?>">Accueil</a></li>
							<li><a href="<?php echo __SITE_ROOT.'/blog/authentification/';?>">Identification</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</header>

		<!--==============================content================================-->
		<section id="content">
			<div class="main zerogrid">
                <div class="wrapper">
					<h1><?php echo $page_first_title;?></h1>
					<h3><?php echo $page_second_title;?></h3>
					<hr/>
					<?php echo $content;?>
                </div>
			</div>
		</section>

		<!--==============================footer=================================-->
		<footer>
			<div class="main zerogrid">
				<div class="aligncenter">
					<p class="p0"></p>
				</div>
			</div>
		</footer>
	</body>
</html>
