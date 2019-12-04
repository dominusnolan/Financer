<?php

/* @var $container \Dice\Dice */

$container->addRule( '\Financer\Blog\Plugin', [
	'shared' => true,
] );
$container->addRule( '\ComposePress\Settings\Managers\Page', [
	'instanceOf' => '\Financer\Blog\Managers\Page',
] );