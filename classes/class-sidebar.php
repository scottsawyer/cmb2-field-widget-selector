<?php
 /**
  * Create a sidebar.
  */
namespace cmb2_field_widget_selector\sidebar;

if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'CMB2_Sidebar' ) ) {
  class CMB2_Sidebar {

  	/**
  	 * Option name.
  	 */
  	const $option_name = "cmb2_field_widget_selector_sidebar";

    /**
     * Initialize the plugin
     */
    public function __construct() {  	

    }

    public static function hooks() {
      
    }

    /**
     * Activate.
     */
    

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
	    	$unique_id = uniqueid( 'cmb2_' );
    		
    	} while ( check_unique( $unique_id ) == false );

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
    	return update_option( self::option_name, $name );
    }

    /**
     * Get sidebar name.
     */
    public static function get_sidebar_name() {
    	return get_option( self::option_name );
    }

    /**
     * Delete sidebar name.
     */
    public static function delete_sidebar_name() {
    	return delete_option( self::option_name );
    }

    /**
     * Register sidebar.
     */
    public function register_sidebar() {
      
      $sidebar_id = self::get_sidebar_name();

      $args = [
        'name' => __( 'Builder Sidebar', TEXT_DOMAIN ),
        'id' => $sidebar_id,
        'description' => __( 'Sidebar for widgets field.', TEXT_DOMAIN );
      ];

      register_sidebar( $args );
    }

  }
}