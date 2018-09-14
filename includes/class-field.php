<?php

namespace CMB2_Field_Widget_Selector\Field;

use CMB2_Field_Widget_Selector\Sidebar as sidebar;

if ( ! class_exists( 'Field' ) ) {
  class Field {

   	const VERSION = CMB2_FIELD_WIDGET_SELECTOR_VERSION;

   	protected static $single_instance = null;

   	protected $field;

   	public static function get_instance() {

   		if ( null === self::$single_instance ) {
   			self::$single_instance = new self();
   		}

   		return self::$single_instance;
   	}

    public function __construct() {
      add_action( 'cmb2_render_widget_selector', [$this, 'render'], 10, 5);
      add_filter( 'cmb2_sanitize_widget_selector', [$this, 'sanitize'], 10, 5);

    }

    public function render( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
        
      // the properties of the fields.

      $field_escaped_value = wp_parse_args( $field_escaped_value, [
        'widgets' => '',
      ] );

      $widgets = self::get_widgets();
      $widget_options = [];
      foreach ( $widgets as $key => $value ) {
        foreach ( $value as $widget_id => $widget_title ) {
          $widget_options[$widget_id] = $widget_title . ' [' . $widget_id . ']';
        }
      }
      $options = '<option value="--">' . esc_html( 'Select a widget' ) . '</option>';
      foreach ( $widget_options as $key => $value ) {
        $options .= '<option value="' . $key . '" ' . selected( $field_escaped_value['widgets'], $key, false ) . '>' . $value . '</option>'; 
      }


      ?>
      <div style="overflow: hidden;"> <!-- test -->
        <p><label for="<?= $field_type_object->_id( '_widgets' ); ?>"><?= esc_html( 'Select Widgets'  ); ?></label></p>
        <?= $field_type_object->select( [
          'name' => $field_type_object->_name( '[widgets]' ),
          'id' => $field_type_object->_id( '_widgets' ),
          'desc' => esc_html( 'Add widget.', 'cmb2_field_wiget_selector' ),
          'options' => $options,
        ] ); ?>      	
      </div>
      <?php 

      echo $field_type_object->_desc( true );

    }

    /**
     * Sanitization function.
     */
    public function sanitize( $check, $meta_value, $object_id, $field_args, $sanitize_object ) {

      if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
        return $check;
      }
      foreach ( $meta_value as $key => $val ) {

        $meta_value[$key] = array_filter( array_map( 'sanitize_text_field', $val ) );

      }

      return array_filter( $meta_value );      
    }

    /**
     * Loads an array of widgets in our custom sidebar.
     * This means the widget configuration is set.
     * @return array().
     */
     public function get_widgets() {

      $sidebar_name = sidebar\Sidebar::get_sidebar_name();
      
      global $wp_registered_widgets;

      print '<pre>';
      //print_r($wp_registered_widgets);
      print '</pre>';

      $sidebars_widgets = get_option( 'sidebars_widgets' );

      $sidebar_widgets = [];
      if ( array_key_exists( $sidebar_name, $sidebars_widgets ) ) {

        foreach( $sidebars_widgets[$sidebar_name] as $key => $value ) {
          $widget_id = $value;
          $widget_parts = explode( '-', $widget_id );
          $widget_base_id = $widget_parts[0];
          $widget_number = $widget_parts[1];
          $options = get_option( 'widget_' . $widget_base_id );

          $widget_title = '';
          if ( is_array( $options[$widget_number] ) ) {

            if ( array_key_exists( 'title', $options[$widget_number] ) && !empty( $options[$widget_number]['title'] ) ) {
              $widget_title = $options[$widget_number]['title'];
            }
            else {
              foreach ( $wp_registered_widgets as $w => $rwidget ) {
                if ( $w == $widget_id ) {
                  $widget_title = $rwidget['name'];                
                }
                else {
                  if ($widget_title == '') {
                    $widget_title = $widget_id;                  
                  }
                }
              }
            }
          }
          $sidebar_widgets[] = [ $widget_id => $widget_title ];
        }

      }

      
      return $sidebar_widgets;

     }
  }
}

//Field::get_instance();