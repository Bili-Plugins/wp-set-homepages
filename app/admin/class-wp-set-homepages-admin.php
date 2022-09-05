<?php
/**
 * Class for repost methods.
 *
 * @package Wp_Set_Homepages
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class is exist, then don't execute this.
if ( ! class_exists( 'BPWP_Set_Homepages_Admin' ) ) {

	/**
	 * Class for Activity Re-post.
	 */
	class BPWP_Set_Homepages_Admin {

		/**
		 * Constructor for class.
		 */
		public function __construct() {

			add_action( 'admin_init', array( $this, 'bpwpsh_register_sub_menu' ) );

			add_filter( 'allowed_options', array( $this, 'bpwpsh_allowed_options' ) );

		}

		public function bpwpsh_register_sub_menu() {

			$show_on_front = get_option( 'show_on_front' );
			$page_on_front = get_option( 'page_on_front' );

			if ( ( ! empty( $show_on_front ) && 'page' !== $show_on_front ) ||
				 ( empty( $page_on_front ) || '0' === $page_on_front ) ) {
				return;
			}

			add_settings_field(
				'front-static-pages-logged-in',
				esc_html__( 'Homepage for logged-in Users', 'wp-set-homepages' ),
				array( $this, 'bpbpwpsh_setting_callback_function' ),
				'reading',
				'default',
				array( 'label_for' => 'front-static-pages-logged-in' )
			);
		}

		public function bpbpwpsh_setting_callback_function() {

			echo wp_dropdown_pages(
				array(
					'name'              => 'page_on_front_logged_in',
					'echo'              => 0,
					'show_option_none'  => __( '&mdash; Select &mdash;', 'wp-set-homepages' ),
					'option_none_value' => '0',
					'selected'          => get_option( 'page_on_front_logged_in' ),
				)
			);

			echo wp_sprintf(
				/* translators: %s: Setting description. */
				'<p class="description">%s</p>',
				esc_html__( 'Description Goes here.', 'wp-set-homepages' )
			);
		}

		public function bpwpsh_allowed_options( $allowed_options ) {

			if ( isset( $allowed_options['reading'] ) ) {
				$allowed_options['reading'][] = 'page_on_front_logged_in';
			}

			return $allowed_options;
		}
	}
}

new BPWP_Set_Homepages_Admin();
