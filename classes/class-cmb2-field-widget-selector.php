<?php

namespace cmb2_field_widget_selector;

class CMB2_Field_Widget_Selector {
	
	protected $loader;

	protected $plugin_name;

	protected $version;

	protected $text_domain;

	public function __construct() {
		if ( defined( 'CMB2_FIELD_WIDGET_SELECTOR_VERSION' ) ) {
			$this->version = CMB2_FIELD_WIDGET_SELECTOR_VERSION;
		}
		else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'cmb2-field-widget-selector';
    $this->load_dependencies();
		$this->define_hooks();

	}

	private function load_dependencies() {

		/**
		 * Require loader.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-loader.php';

		/**
		 * Require field.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-field.php';
  
    /** 
     * Require sidebar.
     */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sidebar.php';

		$this->loader = new CMB2_Field_Widget_Loader();
	}

	/**
	 * Load Dependencies.
	 */
	private function load_dependencies() {

		/**
		 * Class dependencies.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cmb2-field-widget-selector.php';

		/**
		 * Class field.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-field.php';

		/**
		 * Class sidebar.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sidebar.php';

		$this->loader = new CMB2_Field_Widget_Selector_Loader();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}