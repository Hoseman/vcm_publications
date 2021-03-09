<?php

namespace DgoraWcas\Integrations\Themes\Avada;

use DgoraWcas\Helpers;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Avada {

	private $themeSlug = 'avada';

	private $themeName = 'Avada';

	public function __construct() {
		$this->maybeOverwriteSearch();

		add_filter( 'dgwt/wcas/settings', array( $this, 'registerSettings' ) );


	}


	/**
	 * Add settings
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function registerSettings( $settings ) {
		$key = 'dgwt_wcas_basic';

		$settings[ $key ][10] = array(
			'name'  => $this->themeSlug . '_main_head',
			'label' => sprintf( __( 'Replace %s search bar', 'ajax-search-for-woocommerce' ), $this->themeName ),
			'type'  => 'head',
			'class' => 'dgwt-wcas-sgs-header'
		);

		$settings[ $key ][52] = array(
			'name'  => $this->themeSlug . '_settings_head',
			'label' => sprintf( __( '%s Theme', 'ajax-search-for-woocommerce' ), $this->themeName ),
			'type'  => 'desc',
			'desc'  => Helpers::embeddingInThemeHtml(),
			'class' => 'dgwt-wcas-sgs-themes-label',
		);

		$img = DGWT_WCAS()->themeCompatibility->getThemeImageSrc();
		if ( ! empty( $img ) ) {
			$settings[ $key ][52]['label'] = '<img src="' . $img . '">';
		}

		$settings[ $key ][55] = array(
			'name'    => $this->themeSlug . '_replace_search',
			'label'   => __( 'Replace', 'ajax-search-for-woocommerce' ),
			'desc'    => sprintf( __( 'Replace all %s search bars with the Ajax Search for WooCommerce.', 'ajax-search-for-woocommerce' ), $this->themeName ),
			'type'    => 'checkbox',
			'default' => 'off',
		);

		$settings[ $key ][90] = array(
			'name'  => $this->themeSlug . '_othersways__head',
			'label' => __( 'Alternative ways to embed a search bar', 'ajax-search-for-woocommerce' ),
			'type'  => 'head',
			'class' => 'dgwt-wcas-sgs-header'
		);

		return $settings;
	}

	/**
	 * Check if can replace the native Woodmart search form
	 * by the Ajax Search for WooCommerce form.
	 *
	 * @return bool
	 */
	private function canReplaceSearch() {
		$canIntegrate = false;

		if ( DGWT_WCAS()->settings->getOption( $this->themeSlug . '_replace_search', 'off' ) === 'on' ) {
			$canIntegrate = true;
		}

		return $canIntegrate;
	}

	/**
	 * Overwrite search
	 *
	 * @return void
	 */
	private function maybeOverwriteSearch() {
		if ( $this->canReplaceSearch() ) {

			$this->applyCSS();
			$this->applyJS();


			add_filter( 'get_search_form', function ( $form ) {
				return do_shortcode( '[wcas-search-form]' );
			}, 100 );

			add_action( 'init', function () {
				remove_filter( 'wp_nav_menu_items', 'avada_add_search_to_main_nav', 20, 2 );
				add_filter( 'wp_nav_menu_items', array( $this, 'addSearchToMainNav' ), 20, 2 );
			} );

			// Fusion search
			add_filter( 'search_form_after_fields', function ( $args ) {

				add_action( 'wp_footer', function () {
					echo '<div class="dgwt-wcas-avada-fus-search-replace-wrapper">';
					echo do_shortcode( '[wcas-search-form]' );
					echo '</div>';
				} );


				$args['after_fields'] = '<div class="dgwt-wcas-avada-fus-search-replace"></div>';

				return $args;
			} );

		}
	}

	/**
	 * Add search to the main navigation.
	 *
	 * @param string $items HTML for the main menu items.
	 * @param array $args Arguments for the WP menu.
	 *
	 * @return string
	 */
	public function addSearchToMainNav( $items, $args ) {
		// Disable woo cart on ubermenu navigations.
		$ubermenu = ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) );

		if ( 'v6' !== Avada()->settings->get( 'header_layout' ) && false === $ubermenu ) {
			if ( 'main_navigation' === $args->theme_location || 'sticky_navigation' === $args->theme_location ) {
				if ( Avada()->settings->get( 'main_nav_search_icon' ) ) {


					$items .= '<li class="fusion-custom-menu-item fusion-main-menu-search">';
					$items .= do_shortcode( '[wcas-search-form layout="icon"]' );
					$items .= '</li>';
				}
			}
		}

		return $items;
	}

	/**
	 * Apply custom CSS
	 *
	 * @return void
	 */
	private function applyCSS() {

		add_action( 'wp_head', function () {
			?>
			<style>
				.fusion-secondary-menu-search {
					width: 500px;
				}

				.fusion-flyout-search .dgwt-wcas-search-wrapp {
					margin-top: 21px;
				}

				.dgwt-wcas-details-wrapp .quantity {
					width: auto;
				}

				.fusion-main-menu-search .dgwt-wcas-search-icon svg {
					display: none;
				}

				.fusion-main-menu-search .dgwt-wcas-search-icon {
					font-family: icomoon;
				}

				.fusion-main-menu-search .dgwt-wcas-search-icon:after {
					content: '\f002';
					font-size: 15px;
					line-height: 40px;
				}

				.fusion-header-v4 .fusion-main-menu {
					overflow: visible;
				}

				.fusion-search-form {
					display: none;
				}

				html:not(.dgwt-wcas-overlay-mobile-on) .fusion-header-v4 .fusion-main-menu .dgwt-wcas-search-wrapp.dgwt-wcas-layout-icon .dgwt-wcas-search-form {
					top: 100%;
				}

				.fusion-header-v4 .fusion-main-menu .dgwt-wcas-layout-icon-open .dgwt-wcas-search-icon-arrow {
					top: calc(100% + -4px);
				}

				@media (max-width: 1100px) {
					.fusion-flyout-search .dgwt-wcas-search-wrapp {
						margin-top: 73px;
						max-width: 100%;
						padding: 0 30px 0 30px;
					}

				}

				@media (max-width: 800px) {
					.fusion-logo .dgwt-wcas-search-wrapp {
						display: none;
					}
				}
			</style>
			<?php
		} );

	}

	/**
	 * Apply custom JS
	 *
	 * @return void
	 */
	private function applyJS() {

		add_action( 'wp_footer', function () {

			?>
			<script>
				(function ($) {

					function dgwtWcasAvadaGetActiveInstance() {
						var $el = $('.dgwt-wcas-search-wrapp.dgwt-wcas-active'),
							instance;
						if ($el.length > 0) {
							$el.each(function () {
								var $input = $(this).find('.dgwt-wcas-search-input');
								if (typeof $input.data('autocomplete') == 'object') {
									instance = $input.data('autocomplete');
									return false;
								}
							});
						}

						return instance;
					}

					$(document).ready(function () {

						// Header 6
						if ($('.fusion-header-v6').length) {

							$('.fusion-header-v6 .fusion-icon-search').on('click', function () {
								var $input = $('.fusion-flyout-search .dgwt-wcas-search-input');
								if ($input.length > 0) {
									$input.focus();
								}
							});

							$('.fusion-header-v6 .fusion-icon-search').on('click', function () {
								var $input = $('.fusion-flyout-search .dgwt-wcas-search-input');
								if ($input.length > 0) {
									$input.focus();
								}
							});


							$('.fusion-icon-search').on('click', function () {

								if ($('.fusion-header-v6').hasClass('fusion-flyout-search-active')) {

									var instance = dgwtWcasAvadaGetActiveInstance();

									if (typeof instance == 'object') {
										instance.suggestions = [];
										instance.hide();
										instance.el.val('');
									}
								}
							});
						}

						// Fusion search
						var $fusionSearchForm = $('.fusion-search-form');
						if ($fusionSearchForm.length) {
							$(this).remove();
						}

						var $placeholders = $('.dgwt-wcas-avada-fus-search-replace')
						var $barsToReplace = $('.dgwt-wcas-avada-fus-search-replace-wrapper .dgwt-wcas-search-wrapp')
						if ($placeholders.length && $barsToReplace.length) {
							$placeholders.each(function (i) {
								var $parentForm = $(this).closest('form');
								$parentForm.after($(this));
								$parentForm.remove();
							});

							$placeholders.each(function (i) {
								$(this).append($($barsToReplace[i]));
							});
						}

						$(document).on('click', '.fusion-icon-search', function () {


							var $handler = $('.fusion-mobile-menu-search .js-dgwt-wcas-enable-mobile-form');
							var $handler2 = $('.fusion-flyout-search .js-dgwt-wcas-enable-mobile-form');

							if ($handler.length) {

								setTimeout(function () {
									$('.fusion-mobile-menu-search').hide();
								}, 100);

								$handler[0].click();
							}

							if ($handler2.length) {
								$handler2[0].click();
							}

						});

						$(document).on('click', '.js-dgwt-wcas-om-return', function () {
							var $activeFlyout = $('.fusion-flyout-active');
							if ($activeFlyout) {
								$activeFlyout.removeClass('fusion-flyout-search-active');
								$activeFlyout.removeClass('fusion-flyout-active');
							}

						});


					});


				}(jQuery));
			</script>
			<?php
		}, 1000 );

	}

}
