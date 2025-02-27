<?php
/*----------------------------------------
*
* 	CTA after CW 	
*
-----------------------------------------*/

/*
 Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'cta_widgets');

/*
 * Register widget.
 */
function cta_widgets() {
	register_widget('cta_widget');
}

/*
 * Widget class.
 */
class cta_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	//Deprecated: Methods with the same name as their class will not be constructors in a future version of PHP; cta_widget has a deprecated constructor in /Users/luis/Google Drive/.websites/httpdocs/lmseo/public/07-20-2021/wp-content/themes/helios/include/widgets/widget-cta-after-content.php on line 23
	//function cta_widget() {
	function __construct() {
		//function cta_widget() {

		/* Widget settings. */
		$widget_ops = array('classname' => 'cta_widget', 'description' => __('A widget that displays call to action.', 'novo'));

		/* Create the widget. */

		//Deprecated: The called constructor method for WP_Widget in cta_widget is deprecated since version 4.3.0! Use __construct() instead. in /Users/luis/Google Drive/.websites/httpdocs/lmseo/public/07-20-2021/wp-includes/functions.php on line 5176
		//$this->WP_Widget( 'cta_widget', __('CTA', 'novo'), $widget_ops );
		parent::__construct('cta_widget', __('CTA', 'novo'), $widget_ops);
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */

	function widget($args, $instance) {
		extract($args);

		/* Our variables from the widget settings. */
		/*$title = apply_filters('widget_title', $instance['title'] );
		$telephone = $instance['telephone'];*/

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		/*if ( $title )
			echo $before_title . $title . $after_title;*/

		/* Display CTA after content */
		$cta = $instance['cta'];
		if ($cta == 'cta') {
?>
			<div class="cta-widget">
				<h2 class="">More information</h2>
				<div class="cta-header-divider">
					<hr class="small">
				</div>
				<ul>
					<li>We only carry windows manufactured in the U.S.A.</li>
					<li>Free in-home consultation.</li>
					<li>Total renovation specialists.</li>
				</ul>
				<div class="buttons-wrapper">
					<div class="medium-6 columns">
						<a class=" cta_button button rounded medium-btn orange" href="/contact/">Get a Quote Now!</a>
					</div>
					<div class="medium-6 columns">
						<a class=" cta_button button rounded medium-btn orange" href="tel:6262325218">Call Now! (626)-232-5218</a>
					</div>
				</div>
			</div>

		<?php
		}
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['cta'] = $new_instance['cta'];

		/* No need to strip tags for.. */

		return $instance;
	}
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */

	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array(
			'cta' => ''
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('cta'); ?>" name="<?php echo $this->get_field_name('cta'); ?>" value="cta" class="widefat" <?php if ($instance['cta'] == 'cta'): ?> checked<?php endif; ?>><label for="<?php echo $this->get_field_id('cta'); ?>"><?php _e('Display CTA:', 'novo') ?> </label>
		</p>
<?php
	}
}
?>