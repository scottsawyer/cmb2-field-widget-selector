<?php

namespace cmb2_field_widget_selector\field;

use cmb2_field_widget_selector\sidebar as sidebar;

if ( ! class_exists( 'CMB2_Field_Widget_Selector_Field' ) ) {
   class CMB2_Field_Widget_Selector_Field {

   	const VERSION = CMB2_FIELD_WIDGET_SELECTOR_VERSION;

   	protected static $single_instance = null;

   	protected $field;

   	public static function get_instance() {

   		if ( null === self::$single_instance ) {
   			self::$single_instance = new self();
   		}

   		return self::$single_instance;
   	}

    protected function __construct() {
    	add_action( 'cmb2_render_widget_selector', [$this, 'render'], 10, 5);
    	//add_filter();

    }
   	//add_action( 'wp_footer', [$this, 'get_widgets'] );

    public function render( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
    
      // the properties of the fields.

      $field_escaped_value = wp_parse_args( $field_escaped_value, [
        'widgets' => '',
      ] );

      ?>
      <div style="overflow: hidden;">
        <p><label for="<?= $field_type_object->_id( '_widgets' ); ?>"><?= esc_html( 'Widgets'  ); ?></label></p>
        <?= $field_type_object->input( [
          'type' => 'text',
          'name' => $field_type_object->_name( '[widgets]' ),
          'id' => $field_type_object->_id( '_widgets' ),
          'value' => $field_escaped_value['widgets'],
          'desc' => 'The link text.',
        ] ); ?>      	
      </div>
      <?php


   }


  /**
   * Loads an array of widgets in our custom sidebar.
   * This means the widget configuration is set.
   * @return array().
   */
   public function get_widgets() {

   	$sidebar = sidebar::get_sidebar_name();

   	if ( empty ( $GLOBALS['wp_widget_factory'] ) ) return;
   	$widgets = $GLOBALS['wp_widget_factory']->widgets;


   }
}

CMB2_Field_Widget_Selector_Field::get_instance();