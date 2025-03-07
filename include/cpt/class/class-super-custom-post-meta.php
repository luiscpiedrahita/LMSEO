<?php

$scpt_known_custom_fields = array();
/**
 * Easy as pie Custom post meta
 */
class Super_Custom_Post_Meta {
	var $type;
	/**
	 * Holds our meta boxes which get added later by WordPress
	 *
	 * @var array
	 */
	var $boxes;
	/**
	 * Have we set the action yet to add our custom meta boxes?
	 *
	 * @var bool
	 */
	var $registered_meta_boxes_action = false;
	/**
	 * Have we set the action yet to add our datepicker JS and CSS?
	 *
	 * @var bool
	 */
	var $registered_datepicker = false;
	/**
	 * Has the nonce field been printed yet?
	 *
	 * @var bool
	 */
	var $printed_nonce = false;
	/**
	 * The nonce key name to use to validate data source; this will pump in CPT slug via sprintf
	 *
	 * @var string
	 */
	var $nonce_key = 'scpt_%s_custom_meta_nonce';
	/**
	 * HTML tag with which to wrap individual field elements (and labels, where appropriate)
	 *
	 * @var string
	 */
	var $field_wrapper = 'div';
	/**
	 * Store field names to verify POST validity
	 *
	 * @var array
	 */
	var $field_names = array();
	var $columns;
	var $registered_custom_columns;
	/**
	 * Construct a new Super_Custom_Post_Meta object for the given post type
	 *
	 * @param string $post_type The post type these boxes will apply to
	 * @author Matthew Boynes
	 */
	function __construct($post_type) {
		$this->type = $post_type;
	}
	/**
	 * Add custom meta box
	 *
	 * @uses SCPT_Markup::labelify
	 * @uses register_meta_boxes_action
	 * @uses meta_html
	 * @param array $attr The meta box attributes. See {@link http://codex.wordpress.org/Function_Reference/add_meta_box}
	 * @return void
	 * @author Matthew Boynes
	 */
	public function add_meta_box($attr = array()) {
		global $scpt_known_custom_fields;

		if (empty($attr) || !isset($attr['fields']) || !isset($attr['id'])) return;

		if (!isset($attr['title']))


			$attr['title'] = SCPT_Markup::labelify($attr['id']);

		$attr = array_merge(array(


			'callback' => array(&$this, 'meta_html'),


			'page' => $this->type,


			'context' => 'advanced',


			'priority' => 'default'


		), $attr);

		# Fields can optionally be numerically indexed with the individual field arrays having the 'meta_key' array index set


		if (!$this->is_assoc($attr['fields'])) {


			$new_fields = array();


			foreach ($attr['fields'] as $field) {


				$new_fields[$field['meta_key']] = $field;
			}


			$attr['fields'] = $new_fields;
		}

		foreach ($attr['fields'] as $meta_key => $field) {


			$attr['fields'][$meta_key]['meta_key'] = $meta_key;

			$this->field_names[] = $meta_key;


			if (!isset($field['type']))


				$attr['fields'][$meta_key]['type'] = $field['type'] = 'text';

			if (isset($field['column']) && true == $field['column']) {


				$this->add_to_columns(


					(isset($field['label']) ? array($meta_key => $field['label']) : $meta_key)


				);
			}

			if ('date' == $field['type']) $this->register_datepicker();


			if ('wysiwyg' == $field['type']) $attr['fields'][$meta_key]['context'] = $attr['context'];


			if (isset($field['data']))


				$scpt_known_custom_fields[$this->type][$meta_key] = array('data' => $field['data']);


			elseif ('select' == $field['type'] && isset($field['multiple']))


				$scpt_known_custom_fields[$this->type][$meta_key] = 'multiple_select';


			else


				$scpt_known_custom_fields[$this->type][$meta_key] = $field['type'];
		}

		$this->boxes[] = $attr;

		$this->register_meta_boxes_action();
	}
	/**


	 * Add many custom meta boxes


	 *


	 * @uses add_meta_box


	 * @see add_meta_box


	 * @param array Arrays to be passed to add_meta_box; you can pass unlimited params to this method


	 * @return void


	 * @author Matthew Boynes


	 */


	public function add_meta_boxes() {


		$boxes = func_get_args();


		foreach ($boxes as $box) $this->add_meta_box($box);
	}
	/**


	 * Hook our meta boxes into WordPress


	 *


	 * @uses register_meta_boxes


	 * @see register_meta_boxes


	 * @return void


	 * @author Matthew Boynes


	 */


	public function register_meta_boxes_action() {


		if (!$this->registered_meta_boxes_action) {


			add_action('add_meta_boxes', array(&$this, 'register_meta_boxes'));


			add_action('save_post', array($this, 'save_meta'));


			$this->registered_meta_boxes_action = true;
		}
	}
	/**


	 * Add meta boxes to WordPress


	 *


	 * @see registered_meta_boxes_action


	 * @return void


	 * @author Matthew Boynes


	 */


	public function register_meta_boxes() {


		foreach ($this->boxes as $box) {


			add_meta_box(


				$box['id'],


				$box['title'],


				$box['callback'],


				$box['page'],


				$box['context'],


				$box['priority'],


				$box['fields']


			);
		}
	}
	/**


	 * Outputs the HTML for the meta boxes to be used in the WP admin


	 *


	 * @param object $post the 'post' object


	 * @param array $fields array of arguments passed to this function


	 * @return void


	 * @author Matthew Boynes


	 */


	public function meta_html($post, $fields) {


		$fields = $fields['args'];


		// Use nonce for verification


		if (! $this->printed_nonce) {


			wp_nonce_field(plugin_basename(__FILE__), sprintf($this->nonce_key, $this->type));


			$this->printed_nonce = true;
		}

		$post_meta = get_post_custom($post->ID);


		foreach ($fields as $field) {


			// array( 'meta_key' => 'event_date', 'name' => 'Event Date', 'type' => 'text' ),


			// array( 'meta_key' => 'active', 'name' => 'Active', 'type' => 'checkbox' )


			$this->add_field($field, $post_meta);
		}
	}
	/**


	 * Add a field to a meta box. Sorts out what kind of field it is, and calls the appropriate method to output it


	 *


	 * @uses parse_attributes


	 * @uses get_external_data


	 * @uses SCPT_Markup::labelify


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @return string HTML code with a wrapped element, whatever it may be


	 * @author Matthew Boynes


	 */


	public function add_field($field, $post_meta) {


		if (!isset($field['label'])) $field['label'] = SCPT_Markup::labelify($field['meta_key']);

		if (isset($field['data'])) $field['options'] = $this->get_external_data($field['data']);

		$html_attributes = apply_filters('scpt_plugin_meta_field_addt_html_attributes', $this->parse_attributes($field));


		$field_callback = apply_filters('scpt_plugin_meta_field_callback', array(&$this, "add_{$field['type']}_field"), $field);

		echo '<', $this->field_wrapper, ' class="', $field['meta_key'], '-wrap scpt-field-wrap">', "\n";


		if ((is_array($field_callback) && method_exists($field_callback[0], $field_callback[1])) || (!is_array($field_callback) && function_exists($field_callback)))


			call_user_func($field_callback, $field, $post_meta, $html_attributes);


		else


			call_user_func(array(&$this, "add_text_field"), $field, $post_meta, $html_attributes);


		echo '</', $this->field_wrapper, '>';
	}

	/*


	 * =========================


	 * =      Meta Fields      =


	 * =========================


	 */

	/**


	 * Add a text field to a meta box


	 *


	 * @uses SCPT_Markup::tag


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @param array $html_attributes HTML attributes to be passed to element


	 * @return string HTML for an <input type="text" /> element


	 * @author Matthew Boynes


	 */


	public function add_text_field($field, $post_meta, $html_attributes) {


		if (false !== $field['label'])


			echo SCPT_Markup::tag('label', array(


				'for' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-label scpt-meta-text label-' . $field['meta_key']


			), $field['label']);


		echo SCPT_Markup::tag('input', array_merge(array(


			'type' => $field['type'],


			'value' => (isset($post_meta[$field['meta_key']]) ? $post_meta[$field['meta_key']][0] : ''),


			'name' => $field['meta_key'],


			'class' => 'scpt-field',


			'id' => 'scpt_meta_' . $field['meta_key']


		), $html_attributes));

		//added by joe to add field description


		if (!empty($field['data-zp_desc']))


			echo SCPT_Markup::tag('span', array(


				'id' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-description scpt-meta-text label-'
			), $field['data-zp_desc']);
	}
	/**


	 * Add a textarea field to a meta box


	 *


	 * @uses SCPT_Markup::tag


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @param array $html_attributes HTML attributes to be passed to element


	 * @return string HTML for a <textarea></textarea> element


	 * @author Matthew Boynes


	 */


	public function add_textarea_field($field, $post_meta, $html_attributes) {


		if (false !== $field['label'])


			echo SCPT_Markup::tag('label', array(


				'for' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-label scpt-meta-textarea label-' . $field['meta_key']


			), $field['label']);


		echo SCPT_Markup::tag(


			'textarea',


			array_merge(array(


				'name' => $field['meta_key'],


				'class' => 'scpt-field',


				'id' => 'scpt_meta_' . $field['meta_key']


			), $html_attributes),


			(isset($post_meta[$field['meta_key']]) ? $post_meta[$field['meta_key']][0] : '')


		);

		//added by joe to add field description


		if (!empty($field['data-zp_desc']))


			echo SCPT_Markup::tag('span', array(


				'id' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-description scpt-meta-text label-'
			), $field['data-zp_desc']);
	}
	/**


	 * Add a wysiwyg field to a meta box


	 *


	 * @uses SCPT_Markup::tag


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @param array $html_attributes HTML attributes to be passed to element


	 * @return string HTML for a <textarea></textarea> element


	 * @author Matthew Boynes


	 */


	public function add_wysiwyg_field($field, $post_meta, $html_attributes) {


		// $this->editors[] = 'scpt_meta_' . $field['meta_key'];


		// return $this->add_textarea_field( $field, $post_meta, $html_attributes, true );


		$editor_settings = apply_filters('scpt_plugin_custom_meta_wysiwyg_settings', array(


			'teeny' => ('side' == $field['context']),


			'textarea_rows' => ('side' == $field['context'] ? '15' : '10')


		), $field);


		if ('side' == $field['context'])


			add_filter('teeny_mce_before_init', array(&$this, 'teeny_mce_before_init'), 10, 2);

		if (false !== $field['label'])


			echo SCPT_Markup::tag('label', array(


				'for' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-label scpt-meta-wysiwyg label-' . $field['meta_key']


			), $field['label']);


		wp_editor(


			(isset($post_meta[$field['meta_key']]) ? $post_meta[$field['meta_key']][0] : ''),


			$field['meta_key'],


			$editor_settings


		);
	}
	/**


	 * Filter function for editors in sidebars. This prunes down the toolbars so it fits nicely. See teeny_mce_before_init WP filter


	 *


	 * @param array $mceInit Array of TinyMCE Editor settings, which we manipulate


	 * @param string $editor_id


	 * @return void


	 * @author Matthew Boynes


	 */


	public function teeny_mce_before_init($mceInit, $editor_id) {


		$mceInit['theme_advanced_buttons1'] = 'bold,italic,separator,link,unlink,separator,bullist,numlist,separator,wp_adv,fullscreen';


		$mceInit['theme_advanced_buttons2'] = 'formatselect,justifyleft,justifycenter,justifyright,undo,redo';


		return $mceInit;
	}

	/**


	 * Add a checkbox field to a meta box whose values is either 1 or 0


	 *


	 * @uses SCPT_Markup::tag


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @param array $html_attributes HTML attributes to be passed to element


	 * @return string HTML for an <input type="checkbox" /> element


	 * @author Matthew Boynes


	 */


	public function add_boolean_field($field, $post_meta, $html_attributes) {


		$args = array_merge(array(


			'type' => 'checkbox',


			'value' => '1',


			'name' => $field['meta_key'],


			'class' => 'scpt-field',


			'id' => 'scpt_meta_' . $field['meta_key']


		), $html_attributes);


		if (isset($post_meta[$field['meta_key']]) && '1' == $post_meta[$field['meta_key']][0])


			$args['checked'] = 'checked';


		echo


		SCPT_Markup::tag('input', array('type' => 'hidden', 'name' => $field['meta_key'], 'value' => '0')),


		SCPT_Markup::tag('label', array(


			'for' => $args['id'],


			'class' => 'scpt-meta-label choice scpt-meta-checkbox label-' . $field['meta_key']


		), SCPT_Markup::tag('input', $args) . ' ' . $field['label']);

		//added by joe to add field description


		if (!empty($field['data-zp_desc']))


			echo SCPT_Markup::tag('span', array(


				'id' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-description scpt-meta-text label-'
			), $field['data-zp_desc']);
	}
	/**


	 * Add multiple checkbox fields to a meta box, all with the same name


	 *


	 * @uses SCPT_Markup::tag


	 * @uses add_boolean_field


	 * @uses prune_options


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @param array $html_attributes HTML attributes to be passed to element


	 * @return string HTML for an <input type="checkbox" /> element


	 * @author Matthew Boynes


	 */


	public function add_checkbox_field($field, $post_meta, $html_attributes) {


		# First see if this field has options. If not, we can do a boolean checkbox instead


		if (! isset($field['options']))


			return $this->add_boolean_field($field, $post_meta, $html_attributes);

		$args = array_merge(array(


			'type' => 'checkbox',


			'name' => $field['meta_key'] . '[]',


			'class' => 'scpt-field choice',


			'id' => 'scpt_meta_' . $field['meta_key']


		), $html_attributes);

		if (false !== $field['label'])


			echo SCPT_Markup::tag('label', array(


				'class' => 'scpt-meta-label scpt-meta-checkbox label-' . $field['meta_key']


			), $field['label']);


		echo '<span class="scpt-option">' . implode("</span>\n<span class=\"scpt-option\">", $this->prune_options($field['options'], $field['meta_key'], $post_meta, $args, 'input')) . '</span>';
		//added by joe to add field description


		if (!empty($field['data-zp_desc']))


			echo SCPT_Markup::tag('span', array(


				'id' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-description scpt-meta-text label-'
			), $field['data-zp_desc']);
	}
	/**


	 * Add multiple radio fields to a meta box, all with the same name


	 *


	 * @uses SCPT_Markup::tag


	 * @uses add_boolean_field


	 * @uses prune_options


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @param array $html_attributes HTML attributes to be passed to element


	 * @return string HTML for an <input type="radio" /> element


	 * @author Matthew Boynes


	 */


	public function add_radio_field($field, $post_meta, $html_attributes) {


		# First see if this field has multiple options. If not, you're an idiot and we should do a checkbox instead


		if (! isset($field['options']) || 1 == count($field['options']))


			return $this->add_checkbox_field($field, $post_meta, $html_attributes);

		$args = array_merge(array(


			'type' => 'radio',


			'name' => $field['meta_key'],


			'class' => 'scpt-field choice',


			'id' => 'scpt_meta_' . $field['meta_key']


		), $html_attributes);

		if (false !== $field['label'])


			echo SCPT_Markup::tag('label', array(


				'class' => 'scpt-meta-label scpt-meta-radio label-' . $field['meta_key']


			), $field['label']);


		echo '<span class="scpt-option">' . implode("</span>\n<span class=\"scpt-option\">", $this->prune_options($field['options'], $field['meta_key'], $post_meta, $args, 'input')) . '</span>';
		//added by joe to add field description


		if (!empty($field['data-zp_desc']))


			echo SCPT_Markup::tag('span', array(


				'id' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-description scpt-meta-text label-'
			), $field['data-zp_desc']);
	}
	/**


	 * Add select field to a meta box


	 *


	 * @uses SCPT_Markup::tag


	 * @uses add_boolean_field


	 * @uses prune_options


	 * @param array $field The field information


	 * @param array $post_meta The post meta from the database


	 * @param array $html_attributes HTML attributes to be passed to element


	 * @return string HTML for an <input type="select" /> element


	 * @author Matthew Boynes


	 */


	public function add_select_field($field, $post_meta, $html_attributes) {


		$options = implode("\n", $this->prune_options($field['options'], $field['meta_key'], $post_meta));


		if (!isset($html_attributes['multiple']) && !(isset($field['prompt']) && false === $field['prompt']))


			$options = '<option value="">' . (isset($field['prompt']) ? $field['prompt'] : 'Choose one') . '</option>' . $options;

		if (false !== $field['label'])


			echo SCPT_Markup::tag('label', array(


				'class' => 'scpt-meta-label scpt-meta-select label-' . $field['meta_key']


			), $field['label']);


		echo SCPT_Markup::tag('select', array_merge(array(


			'name' => $field['meta_key'] . (isset($html_attributes['multiple']) ? '[]' : ''),


			'class' => 'scpt-field',


			'id' => 'scpt_meta_' . $field['meta_key']


		), $html_attributes), $options);

		//added by joe to add field description


		if (!empty($field['data-zp_desc']))


			echo SCPT_Markup::tag('span', array(


				'id' => 'scpt_meta_' . $field['meta_key'],


				'class' => 'scpt-meta-description scpt-meta-text label-'
			), $field['data-zp_desc']);
	}
	/**


	 * Connect to another post type for one-to-one, one-to-many, or many-to-many relationships


	 *


	 * @todo Add in a QuickPress-like box to enter new objects


	 * @param string $post_type The post type that we want to connect to


	 * @return array An associative array of post_id => post_title


	 * @author Matthew Boynes


	 */


	public function get_external_data($post_type) {


		$posts_array = get_posts(


			apply_filters('scpt_plugin_meta_data_connect_' . $post_type, array(


				'numberposts' => -1,


				'orderby' => 'menu_order title',


				'order' => 'ASC',


				'post_type' => $post_type


			))


		);

		// The Loop, hah


		$ret = apply_filters('scpt_plugin_meta_data_loop', array(), $posts_array);


		if (empty($ret) && !empty($posts_array)) {


			foreach ($posts_array as $post) {


				$ret[$post->ID] = get_the_title($post->ID);
			}
		}


		return $ret;
	}
	/**


	 * Prepare options for select elements, or prepare many checkbox or radio buttons


	 *


	 * @uses SCPT_Markup::tag


	 * @param array $options The options as either an array of values or associative array of values => labels


	 * @param string $meta_key The meta_key for this element


	 * @param array $post_meta The stored post meta


	 * @param array $default_args Optional. The default arguments to attach to this HTML element


	 * @param string $tag Optional. The HTML tag we're creating


	 * @return array of HTML elements


	 * @author Matthew Boynes


	 */


	public function prune_options($options, $meta_key, $post_meta, $default_args = array(), $tag = 'option') {


		$has_values = $this->is_assoc($options) || !isset($options[0]);

		# Allow developers to hook into this before the HTML is generated to override it


		$html = apply_filters('scpt_plugin_custom_meta_pre_' . $meta_key . '_options', array());


		if (!empty($html)) return $html;

		foreach ($options as $key => $option) {


			$this_args = $default_args;


			$this_args['value'] = $has_values ? $key : $option;


			if (isset($this_args['id']))


				$this_args['id'] .= "_$key";

			if ('input' == $tag) {


				if (isset($post_meta[$meta_key]) && in_array($this_args['value'], $post_meta[$meta_key]))


					$this_args['checked'] = 'checked';


				$html[] = SCPT_Markup::tag('label', array(


					'for' => $this_args['id'],


					'class' => 'scpt-meta-label choice scpt-meta-' . $this_args['type'] . ' label-' . $meta_key


				), SCPT_Markup::tag('input', $this_args) . ' ' . $option);
			} else {


				if (isset($post_meta[$meta_key]) && in_array($this_args['value'], $post_meta[$meta_key]))


					$this_args['selected'] = 'selected';


				$html[] = SCPT_Markup::tag('option', $this_args, $option);
			}
		}


		return apply_filters('scpt_plugin_custom_meta_' . $meta_key . '_options', $html);
	}
	/**


	 * Figure out which included field attributes are indended to be HTML attributes


	 *


	 * @param array $args The field arguments containing both the settings and the HTML attributes


	 * @return array The array of will-be HTML attributes


	 * @author Matthew Boynes


	 */


	public function parse_attributes($args) {


		return array_diff_key($args, array(


			'type' => true,


			'meta_key' => true,


			'label' => true,


			'options' => true,


			'data' => true,


			'prompt' => true,


			'column' => true,


			'data-zp_desc' => true


		));
	}
	/**


	 * Save values for custom meta boxes


	 *


	 * @param int $post_id


	 * @return void


	 * @author Matthew Boynes


	 */


	public function save_meta($post_id) {


		# verify if this is an auto save routine.


		# If it is our form has not been submitted, so we dont want to do anything


		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)


			return;

		# verify this came from the our screen and with proper authorization,


		# because save_post can be triggered at other times


		if (!isset($_POST[sprintf($this->nonce_key, $this->type)]) || !wp_verify_nonce($_POST[sprintf($this->nonce_key, $this->type)], plugin_basename(__FILE__)))


			return;

		# Check permissions


		if ('page' == $_POST['post_type'])


			if (!current_user_can('edit_page', $post_id))


				return;


			else


			if (!current_user_can('edit_post', $post_id))


				return;

		# OK, we're authenticated: we need to find and save the data

		foreach ($this->field_names as $field) {


			if (is_array($_POST[$field])) {


				delete_post_meta($post_id, $field);


				foreach ($_POST[$field] as $meta_value)


					add_post_meta($post_id, $field, apply_filters("scpt_plugin_{$this->type}_meta_save_{$field}", $meta_value));
			} else


				update_post_meta($post_id, $field, apply_filters("scpt_plugin_{$this->type}_meta_save_{$field}", $_POST[$field]));
		}
	}
	/**


	 * Register our datepicker CSS & JS


	 *


	 * @return void


	 * @author Matthew Boynes


	 */


	public function register_datepicker() {


		if (!$this->registered_datepicker) {


			add_action('admin_print_styles-post-new.php', array(&$this, 'add_datepicker_css'));


			add_action('admin_print_styles-post.php', array(&$this, 'add_datepicker_css'));


			add_action('admin_print_scripts-post-new.php', array(&$this, 'add_datepicker_js'));


			add_action('admin_print_scripts-post.php', array(&$this, 'add_datepicker_js'));


			$this->registered_datepicker = true;
		}
	}
	/**


	 * Add the datepicker CSS to the doc head


	 *


	 * @return void


	 * @author Matthew Boynes


	 */


	public function add_datepicker_css() {


		wp_enqueue_style('smoothness', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/themes/smoothness/jquery-ui.css');
	}
	/**


	 * Add the datepicker JS to the doc head


	 *


	 * @return void


	 * @author Matthew Boynes


	 */


	public function add_datepicker_js() {


		wp_enqueue_script('jquery-ui-datepicker');


		wp_enqueue_script('supercpt.js');
	}
	/**


	 * A handy dandy helper function for determining if an array is associative or not


	 *


	 * @param array $arr


	 * @return bool


	 * @author Matthew Boynes


	 */


	public function is_assoc($arr) {


		return (is_array($arr) && count(array_filter(array_keys($arr), 'is_string')) == count($arr));
	}


	protected function register_custom_columns($columns = array()) {


		if (!$this->registered_custom_columns) {


			add_action('manage_' . $this->type . '_posts_custom_column', array(&$this, 'custom_column'));


			add_filter('manage_edit-' . $this->type . '_columns', array(&$this, 'edit_columns'));


			$this->registered_custom_columns = true;
		}
	}

	public function add_to_columns($column) {


		if (is_array($column)) {


			$this->columns = $this->columns + $column;
		} else {


			$this->columns[$column] = SCPT_Markup::labelify($column);
		}


		$this->register_custom_columns();
	}

	public function custom_column($column) {


		if (isset($this->columns[$column])) {


			add_filter('scpt_plugin_formatted_meta', array($this, 'format_meta_for_list'), 10, 2);


			the_scpt_formatted_meta($column);
		}

		/* If listing a taxonomy...


		$terms = get_the_term_list( $post->ID , 'location' , '' , ', ' , '' );


		if ( is_string( $terms ) )


			echo $terms;


		*/
	}

	public function format_meta_for_list($data, $key) {


		$field_info = get_known_field_info($key);


		if (is_array($field_info)) {


			# This is a cpt relationship


		} else {


			switch ($field_info) {


				case 'date':


					return $data ? date('Y-m-d', $data) : '';


				case 'boolean':


					return true === $data ? '&#10004;' : '';
			}
		}


		return $data;
	}

	public function edit_columns($columns) {


		return array(


			"cb" => '<input type="checkbox" />',


			"title" => 'Title'


		) + $this->columns;
	}
}
