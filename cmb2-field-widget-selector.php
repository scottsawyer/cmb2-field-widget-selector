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

namespace cmb2_field_widget_selector;

if ( !defined( 'ABSPATH' ) ) exit; 

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CMB2_FIELD_WIDGET_SELECTOR_VERSION', '1.0.0' );
define( 'TEXTDOMAIN', 'cmb2_field_wiget_selector' );

function cmb2_field_widget_select_install() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/sidebar.php';
  CMB2_Sidebar::create_sidebar_name();   
}

function cmb2_field_widget_select_uninstall() {
   require_once plugin_dir_path( __FILE__ ) . 'includes/sidebar.php';
   CMB2_Sidebar::delete_sidebar_name();
}

register_activation_hook( __FILE__, 'cmb2_field_widget_select_install' );
register_deactivation_hook( __FILE__, 'cmb2_field_widget_select_uninstall' );

require plbuin_dir_path( __FILE__ ) . 'includes/class-field.php';

function run_cmb2_field_widget_select() {
   $plugin = new CMB2_Field_Widget_Select();
   $plugin->run();
}

run_cmb2_field_widget_select();
