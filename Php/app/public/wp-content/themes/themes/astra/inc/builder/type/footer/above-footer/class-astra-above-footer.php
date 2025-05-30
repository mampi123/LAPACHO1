<?php
/**
 * Above Footer component.
 *
 * @package     Astra Builder
 * @link        https://www.brainstormforce.com
 * @since       Astra 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'ASTRA_BUILDER_FOOTER_ABOVE_FOOTER_DIR', ASTRA_THEME_DIR . 'inc/builder/type/footer/above-footer' );
define( 'ASTRA_BUILDER_FOOTER_ABOVE_FOOTER_URI', ASTRA_THEME_URI . 'inc/builder/type/footer/above-footer' );

if ( ! class_exists( 'Astra_Above_Footer' ) ) {

	/**
	 * Above Footer Initial Setup
	 *
	 * @since 3.0.0
	 */
	class Astra_Above_Footer {
		/**
		 * Constructor function that initializes required actions and hooks
		 */
		public function __construct() {

			// @codingStandardsIgnoreStart WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			require_once ASTRA_BUILDER_FOOTER_ABOVE_FOOTER_DIR . '/class-astra-above-footer-component-loader.php';

			// Include front end files.
			if ( ! is_admin() || Astra_Builder_Customizer::astra_collect_customizer_builder_data() ) {
				require_once ASTRA_BUILDER_FOOTER_ABOVE_FOOTER_DIR . '/dynamic-css/dynamic.css.php';
			}
			// @codingStandardsIgnoreEnd WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		}
	}

	/**
	 *  Kicking this off by creating an object.
	 */
	new Astra_Above_Footer();

}
