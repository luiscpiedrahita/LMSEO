<?php

/**
 * Cenote Welcome Notice Class.
 *
 * @author  ThemeGrill
 * @package Cenote
 * @since   1.3.3
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

class Cenote_Welcome_Notice {

	public function __construct() {
		add_action('wp_loaded', array($this, 'welcome_notice'), 20);
		add_action('wp_loaded', array($this, 'hide_notices'), 15);
		add_action('wp_ajax_import_button', array($this, 'welcome_notice_import_handler'));
	}

	public function welcome_notice() {
		if (! get_option('cenote_admin_notice_welcome')) {
			add_action('admin_notices', array($this, 'welcome_notice_markup')); // Show notice.
		}
	}

	/**
	 * echo `Get started` CTA.
	 *
	 * @return string
	 *
	 */
	public function import_button_html() {
		$html = '<a class="btn-get-started button button-primary button-hero" href="#" data-name="' . esc_attr('themegrill-demo-importer') . '" data-slug="' . esc_attr('themegrill-demo-importer') . '" aria-label="' . esc_attr__('Get started with Cenote', 'cenote') . '">' . esc_html__('Get started with Cenote', 'cenote') . '</a>';

		return $html;
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice_markup() {
		$dismiss_url = wp_nonce_url(
			remove_query_arg(array('activated'), add_query_arg('cenote-hide-notice', 'welcome')),
			'cenote_hide_notices_nonce',
			'_cenote_notice_nonce'
		);
?>
		<div id="message" class="notice notice-success cenote-notice">
			<a class="cenote-message-close notice-dismiss" href="<?php echo esc_url($dismiss_url); ?>"></a>

			<div class="cenote-message__content">
				<div class="cenote-message__image">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/screenshot.jpg'); ?>" class="cenote-screenshot" alt="<?php esc_attr_e('Cenote', 'cenote'); ?>" />
					<?php
					// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped, Squiz.PHP.EmbeddedPhp.SpacingBeforeClose
					?>
				</div>

				<div class="cenote-message__text">
					<h2 class="cenote-message__heading">
						<?php
						printf(
							/* translators: 1: welcome page link starting html tag, 2: welcome page link ending html tag. */
							esc_html__('Welcome! Thank you for choosing cenote! To fully take advantage of the best our theme can offer please make sure you visit our %1$swelcome page%2$s.', 'cenote'),
							'<a href="' . esc_url(admin_url('themes.php?page=cenote-welcome')) . '">',
							'</a>'
						);
						?>
					</h2>

					<div class="cenote-message__cta">
						<?php echo $this->import_button_html(); ?>
						<span class="plugin-install-notice"><?php esc_html_e('Clicking the button will install and activate the ThemeGrill demo importer plugin.', 'cenote'); ?></span>
					</div>
				</div>
			</div>
		</div> <!-- /.cenote-message__content -->
<?php
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public function hide_notices() {
		if (isset($_GET['cenote-hide-notice']) && isset($_GET['_cenote_notice_nonce'])) { // WPCS: input var ok.
			if (! wp_verify_nonce(wp_unslash($_GET['_cenote_notice_nonce']), 'cenote_hide_notices_nonce')) { // phpcs:ignore WordPress.VIP.ValidatedSanitizedInput.InputNotSanitized
				wp_die(__('Action failed. Please refresh the page and retry.', 'cenote')); // WPCS: xss ok.
			}

			if (! current_user_can('manage_options')) {
				wp_die(__('Cheatin&#8217; huh?', 'cenote')); // WPCS: xss ok.
			}

			$hide_notice = sanitize_text_field(wp_unslash($_GET['cenote-hide-notice']));

			// Hide.
			if ('welcome' === $_GET['cenote-hide-notice']) {
				update_option('cenote_admin_notice_' . $hide_notice, 1);
			} else { // Show.
				delete_option('cenote_admin_notice_' . $hide_notice);
			}
		}
	}

	/**
	 * Handle the AJAX process while import or get started button clicked.
	 */
	public function welcome_notice_import_handler() {
		check_ajax_referer('cenote_demo_import_nonce', 'security');

		$state = '';

		if (class_exists('themegrill_demo_importer')) {
			$state = 'activated';
		} elseif (file_exists(WP_PLUGIN_DIR . '/themegrill-demo-importer/themegrill-demo-importer.php')) {
			$state = 'installed';
		}

		if ('activated' === $state) {
			$response['redirect'] = admin_url('/themes.php?page=demo-importer&browse=all&cenote-hide-notice=welcome');
		} elseif ('installed' === $state) {
			$response['redirect'] = admin_url('/themes.php?page=demo-importer&browse=all&cenote-hide-notice=welcome');
			if (current_user_can('activate_plugin')) {
				$result = activate_plugin('themegrill-demo-importer/themegrill-demo-importer.php');

				if (is_wp_error($result)) {
					$response['errorCode']    = $result->get_error_code();
					$response['errorMessage'] = $result->get_error_message();
				}
			}
		} else {
			wp_enqueue_style('plugin-install');
			wp_enqueue_script('plugin-install');

			$response['redirect'] = admin_url('/themes.php?page=demo-importer&browse=all&cenote-hide-notice=welcome');

			/**
			 * Install Plugin.
			 */
			include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			$api = plugins_api(
				'plugin_information',
				array(
					'slug'   => sanitize_key(wp_unslash('themegrill-demo-importer')),
					'fields' => array(
						'sections' => false,
					),
				)
			);

			$skin     = new WP_Ajax_Upgrader_Skin();
			$upgrader = new Plugin_Upgrader($skin);
			$result   = $upgrader->install($api->download_link);

			if ($result) {
				$response['installed'] = 'succeed';
			} else {
				$response['installed'] = 'failed';
			}

			// Activate plugin.
			if (current_user_can('activate_plugin')) {
				$result = activate_plugin('themegrill-demo-importer/themegrill-demo-importer.php');

				if (is_wp_error($result)) {
					$response['errorCode']    = $result->get_error_code();
					$response['errorMessage'] = $result->get_error_message();
				}
			}
		}

		wp_send_json($response);

		exit();
	}
}

new Cenote_Welcome_Notice();
