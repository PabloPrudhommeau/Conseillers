<?php

/* * * include the controller class ** */
include __SITE_PATH . '/application/core/' . 'BaseController.class.php';
/* * * include the component class ** */
include __SITE_PATH . '/application/core/' . 'BaseComponent.class.php';
/* * * include the registry class ** */
include __SITE_PATH . '/application/core/' . 'Registry.class.php';
/* * * include the router class ** */
include __SITE_PATH . '/application/core/' . 'Router.class.php';
/* * * include the assets class ** */
include __SITE_PATH . '/application/core/' . 'Template.class.php';

/* * * Chargement des modèles ** */
$model_class = array_diff(scandir('model/'), array('.', '..'));
foreach ($model_class as $val) {
	include(__SITE_PATH.'/model/'.$val);
}

$registry = new Registry();
?>
