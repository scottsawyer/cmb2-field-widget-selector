<?php
namespace CMB2_Field_Widget_Selector;

use CMB2_Field_Widget_Selector\Sidebar as sidebar;

class CMB2_Field_Widget_Selector_Public {
	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
    add_shortcode( 'widget_selector', [$this, 'widget_selector'] );
	}

	public static function widget_selector( $atts ) {
    extract( shortcode_atts ( [
    	'widget' => '1'
    	], $atts)
    );

    $widget_instance = $this->get_widget_instance( $widget );

    $callback = $widget_instance['callback'];

    $sidebar = $this->get_the_sidebar();

    $params = array_merge ( 
    	[ 
    	array_merge ( 
    		$sidebar, 
    		['widget_id' => $widget_instance['id'], 'widget_name' => $widget_instance['name']] 
    	)
    	], $widget_instance['params']
    );
    if ( $widget_instance != false ) {
    	$class_name = $this->get_widget_class( $widget_instance );
      ob_start();

      
      if ( is_callable($callback) ) {
	      call_user_func_array($callback, $params);
	    }
      $output = ob_get_contents();
      ob_end_clean();
      return $output;
    }
	}

	public static function get_widget_instance( $widget_id ) {
		global $wp_registered_widgets;
		if ( is_array( $wp_registered_widgets ) 
			&& array_key_exists( $widget_id, $wp_registered_widgets )
			 ) {
			return $wp_registered_widgets[$widget_id];
		}
		return false;
	}

	public static function get_widget_class( $widget_instance ) {
		return get_class( $widget_instance['callback'][0] );
	}

	public function get_the_sidebar( ) {
		global $wp_registered_sidebars;
		$sidebar_name = sidebar\Sidebar::get_sidebar_name();
		if ( is_array( $wp_registered_sidebars ) && array_key_exists( $sidebar_name, $wp_registered_sidebars ) ) {
			return $wp_registered_sidebars[$sidebar_name];
		}
		return false;
	}
}