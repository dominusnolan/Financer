<?php

namespace Financer\Blog;

use ComposePress\Core\Abstracts\Plugin as PluginBase;
use ComposePress\Settings;

/**
 * Class Plugin
 *
 * @package Financer\Blog
 */
class Plugin extends PluginBase {
	/**
	 *
	 */
	const VERSION = '0.1.0';

	/**
	 *
	 */
	const PLUGIN_SLUG = 'financer-blog';
	/**
	 * @var BlogComponent
	 */
	private $fs_component;
	/**
	 * @var Example
	 */
	private $fs_manager;
	/**
	 * @var \ComposePress\Settings
	 */
	private $settings;
	/**
	 * @var \Financer\Blog\UI
	 */
	private $admin_ui;

	/**
	 * Plugin constructor.
	 *
	 * @param BlogComponent         $fs_component
	 * @param Example                  $fs_manager
	 * @param \ComposePress\Settings   $settings
	 * @param \Financer\Blog\UI $admin_ui
	 */
	public function __construct( BlogComponent $fs_component, Example $fs_manager, Settings $settings, UI $admin_ui ) {
		$this->fs_component = $fs_component;
		$this->fs_manager   = $fs_manager;
		$this->settings          = $settings;
		$this->admin_ui          = $admin_ui;
		parent::__construct();
	}

	/**
	 * @return void
	 */
	public function activate() {
		// TODO: Implement activate() method.
	}

	/**
	 * @return void
	 */
	public function deactivate() {
		// TODO: Implement deactivate() method.
	}

	/**
	 * @return void
	 */
	public function uninstall() {
		// TODO: Implement uninstall() method.
	}

	/**
	 * @return BlogComponent
	 */
	public function get_example_component() {
		return $this->fs_component;
	}

	/**
	 * @return \ComposePress\Settings
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * @return \Financer\Blog\UI
	 */
	public function get_admin_ui() {
		return $this->admin_ui;
	}

	/**
	 * @return \Financer\Blog\Managers\Example
	 */
	public function get_example_manager() {
		return $this->fs_manager;
	}
}