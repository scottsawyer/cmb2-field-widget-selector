<?php
 /**
  * Create a sidebar.
  */
namespace CMB2_Field_Widget_Selector\Sidebar;

if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Sidebar' ) ) {
  class Sidebar {

  	/**
  	 * Option name.
  	 */
  	protected $option_name;

    /**
     * Initialize the plugin
     */
    public function __construct() {  	
      $this->option_name = self::get_option_name();
      self::init();
    }

    public static function hooks() {
      
    }

    /**
     * Activate.
     */
    public function init() {
      if ( !self::get_sidebar_name() ) {
        self::create_sidebar_name();
      }
      self::register_sidebar();
    }

    /**
     * Get all registered sidebar names.
     */
  	public static function get_sidebar_names() {
  		global $wp_registered_sidebars;
      $names = [];
      foreach ( $wp_registered_sidebars as $sidebar => $properties ) {
      	$names[] = $properties['name'];
      }
      return $names;
  	}

  	/**
  	 * Create sidebar name.
  	 */
    public static function create_sidebar_name() {

    	do {
	    	$unique_id = uniqid( 'cmb2_' );
    		
    	} while ( self::check_unique( $unique_id ) == false );

    	$stored = self::store_sidebar_name( $unique_id );


    	return $unique_id;
    }

    /**
     * Check uniqueness.
     */
    public static function check_unique( $new_name ) {
      $existing_names = self::get_sidebar_names();
      if ( in_array( $new_name, $existing_names ) ) {
      	return false;
      }
      return true;
    }

    /**
     * Store name.
     */
    public static function store_sidebar_name( $name ) {
    	return update_option( self::get_option_name(), $name );
    }

    /**
     * Get sidebar name.
     */
    public static function get_sidebar_name() {
    	return get_option( self::get_option_name() );
    }

    /**
     * Delete sidebar name.
     */
    public static function delete_sidebar_name() {
      print $this->option_name;
      if ( get_option( $this->option_name ) ) {
      	return delete_option( $this->option_name );
      }
      return;
    }

    /**
     * Register sidebar.
     */
    public function register_sidebar() {
      
      $sidebar_id = self::get_sidebar_name();

      $args = [
        'name' => __( 'Builder Sidebar', 'cmb2_field_wiget_selector' ),
        'id' => $sidebar_id,
        'description' => __( 'Sidebar for widgets field.', 'cmb2_field_wiget_selector' ),
      ];

      register_sidebar( $args );
    }

    /**
     * Unregister sidebar.
     */
    public function unregister_sidebar() {
      $sidebar_id = self::get_sidebar_name();

      unregister_sidebar( $sidebar_id );
    }

    /**
     * Get Option Name.
     */
    public static function get_option_name() {
      return "cmb2_field_widget_selector_sidebar";
    }

  }
}