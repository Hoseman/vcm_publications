<?php


namespace DgoraWcas\Admin;


use DgoraWcas\Admin\Promo\FeedbackNotice;
use DgoraWcas\Helpers;

class RegenerateImages {

	const ALREADY_REGENERATED_OPT_KEY = 'dgwt_wcas_images_regenerated';
	const REGENERATE_ACTION = 'dgwt_wcas_regenerate_images';
	const DISMISS_AJAX_ACTION = 'dgwt_wcas_dismiss_notice_regenerate_images';

	public function __construct() {
	}

	public function init() {

		$displayImages = DGWT_WCAS()->settings->getOption( 'show_product_image' ) === 'on';

		$regenerated = get_option( self::ALREADY_REGENERATED_OPT_KEY );

		add_action( 'wp_ajax_' . self::DISMISS_AJAX_ACTION, array( $this, 'dismissNotice' ) );
		add_action( 'wp_ajax_' . self::REGENERATE_ACTION, array( $this, 'regenerateImages' ) );

		add_filter( 'woocommerce_regenerate_images_intermediate_image_sizes', array( $this, 'getImageSizes' ), 10, 1 );

		if (
			Helpers::isSettingsPage()
			&& empty( $regenerated )
			&& $displayImages
			&& $this->isTimeToDisplay()
		) {


			add_action( 'admin_notices', array( $this, 'adminNotice' ) );

			add_action( 'admin_footer', array( $this, 'printJS' ) );

		}

	}

	/**
	 * Regenerate images
	 *
	 * @return void
	 */
	public function regenerateImages() {
		if ( class_exists( 'WC_Regenerate_Images' ) ) {

			if ( method_exists( 'Jetpack', 'is_module_active' ) && \Jetpack::is_module_active( 'photon' ) ) {
				return;
			}

			if ( apply_filters( 'woocommerce_background_image_regeneration', true ) ) {
				\WC_Regenerate_Images::queue_image_regeneration();
			}
		}

		update_option( self::ALREADY_REGENERATED_OPT_KEY, true );

		wp_send_json_success();
	}

	/**
	 * Images sizes to regenerate
	 *
	 * @param array $sizes
	 *
	 * @return array
	 */
	public function getImageSizes( $sizes ) {

		array_push( $sizes, 'dgwt-wcas-product-suggestion' );

		return $sizes;

	}

	/**
	 * Notice: Maybe regenerate images
	 * @return void
	 */

	public function adminNotice() {
		?>
		<div class="notice notice-info dgwt-wcas-notice is-dismissible js-dgwt-wcas-notice-regenerate-images">
			<p>
				<?php
				$button     = '<a href="#" class="button button-small js-dgwt-wcas-start-regenerate-images">' . __( 'Regenerate WooCommerce images' ) . '</a>';
				$pluginLink = '<a target="_blank" href="https://wordpress.org/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a>';
				printf( __( '<b>AJAX Search for WooCommerce</b>: It is recommended to generate a special small image size for existing products to ensure a better user experience. This is a one-time action. <br /><br />You can do it by clicking %s or use external plugin e.g. %s.',
					'ajax-search-for-woocommerce' ), $button, $pluginLink );
				?>
			</p>
		</div>
		<?php
	}


	/**
	 * Hide admin notice
	 *
	 * @return null
	 */
	public function dismissNotice() {

		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		update_option( self::ALREADY_REGENERATED_OPT_KEY, true );

		wp_send_json_success();
	}

	/**
	 * Check is is time to display
	 *
	 * @return boolean
	 */
	public function isTimeToDisplay() {

		$isTime = false;

		$date   = get_option( FeedbackNotice::ACTIVATION_DATE_OPT );
		$offset = strtotime( '-2 days' );

		if ( ! empty( $date ) && $offset >= $date ) {
			$isTime = true;
		}


		return $isTime;
	}

	/**
	 * Print JS for close admin notice
	 *
	 * @return void
	 */
	public function printJS() {
		?>
		<script>
			(function ($) {

				$(document).on('click', '.js-dgwt-wcas-notice-regenerate-images .notice-dismiss', function () {

					$.ajax({
						url: ajaxurl,
						data: {
							action: '<?php echo self::DISMISS_AJAX_ACTION; ?>',
						}
					});

				});

				$(document).on('click', '.js-dgwt-wcas-start-regenerate-images', function () {

					$('.js-dgwt-wcas-notice-regenerate-images p').html('<b>AJAX Search for WooCommerce</b>: (...)');

					$.ajax({
						url: ajaxurl,
						data: {
							action: '<?php echo self::REGENERATE_ACTION; ?>',
						}
					}).done(function (data) {

						setTimeout(function () {
							$('.js-dgwt-wcas-notice-regenerate-images p').html('<b>AJAX Search for WooCommerce</b>: <?php _e( 'Regeneration of images started. The process will continue in the background.' ); ?>');
						}, 700);

					});
					;

				});

			}(jQuery));
		</script>

		<?php
	}


}
