<?php

namespace Financer\Blog\Managers;

class Page extends \ComposePress\Settings\Managers\Page {
	const MODULE_NAMESPACE = '\Financer\Blog\UI\Pages';
	protected $modules = [ 'BlogPage' ];
}