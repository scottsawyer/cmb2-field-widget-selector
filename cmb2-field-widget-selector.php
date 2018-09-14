<?php
  /**
   * @package CMB2\Field_Widget_Selector
   * @author scottsawyer
   * @copyright Copyright (c) scottsawyer
   *
   * Plugin Name: CMB2 Field Type: Widget Selector
   * Plugin URI: https://github.com/scottsawyer/cmb2-field-link
   * Github Plugin URI: https://github.com/scottsawyer/cmb2-field-link
   * Description: CMB2 field type to create a link.
   * Version: 1.0
   * Author: scottsawyer
   * Author URI: https://www.scottsawyerconsulting.com
   * License: GPLv2+
   */

namespace CMB2_Field_Widget_Selector;

if ( !defined( 'ABSPATH' ) ) exit; 

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if ( !defined( 'CMB2_FIELD_WIDGET_SELECTOR_VERSION' ) ) define( 'CMB2_FIELD_WIDGET_SELECTOR_VERSION', '1.0.0' );

if ( !defined( 'PLUGIN_URL' ) ) define( 'PLUGIN_URL', __FILE__ );

function cmb2_field_widget_selector_activate() {
//  require_once plugin_dir_path( __FILE__ ) . 'includes/class-sidebar.php';
//  $sidebar = new \CMB2_Field_Widget_Selector\Sidebar();
}

function cmb2_field_widget_selector_deactivate() {
//   require_once plugin_dir_path( __FILE__ ) . 'includes/class-sidebar.php';
//   Sidebar::unregister_sidebar();
}

register_activation_hook( PLUGIN_URL, __NAMESPACE__ . '\cmb2_field_widget_selector_activate' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\cmb2_field_widget_selector_deactivate' );

require plugin_dir_path( __FILE__ ) . 'includes/class-cmb2-field-widget-selector.php';

function run_cmb2_field_widget_selector() {
   
   $plugin = new \CMB2_Field_Widget_Selector\CMB2_Field_Widget_Selector();
   $plugin->run();
}

run_cmb2_field_widget_selector();
