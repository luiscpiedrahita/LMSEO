<?php

/**
 * Nested section.
 *
 * @package     Kirki
 * @subpackage  Custom Sections Module
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Nested panel.
 */
class Kirki_Panels_Nested_Panel extends WP_Customize_Panel {

	/**
	 * The parent panel.
	 *
	 * @access public
	 * @since 3.0.0
	 * @var string
	 */
	public $panel;

	/**
	 * Type of this panel.
	 *
	 * @access public
	 * @since 3.0.0
	 * @var string
	 */
	public $type = 'kirki-nested';

	/**
	 * Gather the parameters passed to client JavaScript via JSON.
	 *
	 * @access public
	 * @since 3.0.0
	 * @return array The array to be exported to the client as JSON.
	 */
	public function json() {
		$array = wp_array_slice_assoc(
			(array) $this,
			array(
				'id',
				'description',
				'priority',
				'type',
				'panel',
			)
		);

		$array['title']          = html_entity_decode($this->title, ENT_QUOTES, get_bloginfo('charset'));
		$array['content']        = $this->get_content();
		$array['active']         = $this->active();
		$array['instanceNumber'] = $this->instance_number;

		return $array;
	}
}
