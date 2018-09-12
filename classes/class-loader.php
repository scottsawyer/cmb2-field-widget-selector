<?php

namespace cmb2_field_widget_selector\loader;

/**
 * Register actions and filters.
 */

class CMB2_Field_Widget_Selector_Loader {

  protected $actions;
  protected $filters;

  public function __construct() {
  	$this->actions = array();
		$this->filters = array();	
  }

  public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
  	$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
  }

  public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
  	$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
  }

  private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {
		$hooks[] = [
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		];  	
  	return $hooks;
  }

  public function run() {
  	foreach ( $this->filters as $hook ) {
  		add_filter( $hook['hook'], [$hook['component'], $hook['callback']], $hook['priority'], $hook['accepted_args'] );
  	}

  	foreach ($this->filters as $hook ) {
  	  add_action( $hook['hook'], [$hook['component'], $hook['callback']], $hook['priority'], $hook['accepted_args'] );
  	}
  }

}