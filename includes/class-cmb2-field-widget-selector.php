<?php

namespace CMB2_Field_Widget_Selector;

class CMB2_Field_Widget_Selector {
	
	protected $loader;

	protected $plugin_name;

	protected $version;

	protected $sidebar;

	protected $field;

	public function __construct() {

		if ( defined( 'CMB2_FIELD_WIDGET_SELECTOR_VERSION' ) ) {
			$this->version = CMB2_FIELD_WIDGET_SELECTOR_VERSION;
		}
		else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'cmb2-field-widget-selector';
    $this->load_dependencies();
		//$this->define_hooks();

		$this->sidebar = new Sidebar\Sidebar();

		if ( ( $this->field instanceof Field\Field ) != TRUE ) {
			$this->field = $this->create_field();
		}


	}

	private function load_dependencies() {

		/**
		 * Require loader.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-loader.php';

    /** 
     * Require sidebar.
     */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sidebar.php';

		/**
		 * Require field.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-field.php';

		$this->loader = new loader\Loader();
	}

	private function create_field() {
		if ( ( $this->field instanceof Field\Field ) != TRUE ) {
			return new Field\Field();
		}
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new CMB2_Field_Widget_Selector_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
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