<?php

/**
 * Cenote Theme Review Notice Class.
 *
 * @author  ThemeGrill
 * @package Cenote
 * @since   1.3.3
 */
// Exit if accessed directly.
defined('ABSPATH') || exit;

class Cenote_Upgrade_Notice extends Cenote_Notice {

	public function __construct() {
		if (! current_user_can('publish_posts')) {
			return;
		}

		$dismiss_url = wp_nonce_url(
			add_query_arg('cenote_notice_dismiss', 'upgrade', admin_url()),
			'cenote_upgrade_notice_dismiss_nonce',
			'_cenote_upgrade_notice_dismiss_nonce'
		);

		$temporary_dismiss_url = wp_nonce_url(
			add_query_arg('cenote_notice_dismiss_temporary', 'upgrade', admin_url()),
			'cenote_upgrade_notice_dismiss_temporary_nonce',
			'_cenote_upgrade_notice_dismiss_temporary_nonce'
		);

		parent::__construct('upgrade', 'info', $dismiss_url, $temporary_dismiss_url);

		$this->set_notice_time();

		$this->set_temporary_dismiss_notice_time();

		$this->set_dismiss_notice();
	}

	private function set_notice_time() {
		if (! get_option('cenote_upgrade_notice_start_time')) {
			update_option('cenote_upgrade_notice_start_time', time());
		}
	}

	private function set_temporary_dismiss_notice_time() {
		if (isset($_GET['cenote_notice_dismiss_temporary']) && 'upgrade' === $_GET['cenote_notice_dismiss_temporary']) {
			update_user_meta($this->current_user_id, 'cenote_upgrade_notice_dismiss_temporary_start_time', time());
		}
	}

	public function set_dismiss_notice() {

		/**
		 * Do not show notice if:
		 *
		 * 1. It has not been 5 days since the theme is activated.
		 * 2. If the user has ignored the message partially for 2 days.
		 * 3. Dismiss always if clicked on 'Dismiss' button.
		 */
		if (
			get_option('cenote_upgrade_notice_start_time') > strtotime('-5 day')
			|| get_user_meta(get_current_user_id(), 'cenote_upgrade_notice_dismiss', true)
			|| get_user_meta(get_current_user_id(), 'cenote_upgrade_notice_dismiss_temporary_start_time', true) > strtotime('-2 day')
		) {
			add_filter('cenote_upgrade_notice_dismiss', '__return_true');
		} else {
			add_filter('cenote_upgrade_notice_dismiss', '__return_false');
		}
	}

	public function notice_markup() {
?>
		<div class="notice notice-success cenote-notice">
			<a class="cenote-notice-dismiss notice-dismiss" href="<?php echo esc_url($this->dismiss_url); ?>"></a>

			<p class="notice-text">
				<?php
				$current_user = wp_get_current_user();

				printf(
					esc_html__(
						/* Translators: %1$s current user display name., %2$s this theme name., %3$s discount coupon code., %4$s discount percentage. */
						'Howdy, %1$s! You\'ve been using %2$s theme for a while now, and we hope you\'re happy with it. To access more premium features you can always upgrade to pro. All contents and settings will remain as it is after upgrading to pro, you basically start from where you left. Also, you can use the coupon code %3$s to get %4$s discount (limited time offer) while making the purchase. Enjoy! ',
						'cenote'
					),
					'<strong>' . esc_html($current_user->display_name) . '</strong>',
					'cenote',
					'<code class="coupon-code">TGFREEUSER</code>',
					'25%'
				);
				?>
			</p>

			<div class="links">
				<a href="<?php echo esc_url($this->pricing_url); ?>" class="button button-primary" target="_blank">
					<span class="dashicons dashicons-thumbs-up"></span>
					<span><?php esc_html_e('Upgrade to pro', 'cenote'); ?></span>
				</a>

				<a href="<?php echo esc_url($this->temporary_dismiss_url); ?>" class="button button-secondary">
					<span class="dashicons dashicons-calendar"></span>
					<span><?php esc_html_e('Maybe later', 'cenote'); ?></span>
				</a>

				<a href="https://themegrill.com/contact/?utm_source=cenote-dashboard-message&utm_medium=button-link&utm_campaign=pre-sales" class="button button-secondary" target="_blank">
					<span class="dashicons dashicons-info"></span>
					<span><?php esc_html_e('Got pre sales queries?', 'cenote'); ?></span>
				</a>
			</div>
		</div> <!-- /cenote-notice -->
<?php
	}
}

new Cenote_Upgrade_Notice();
