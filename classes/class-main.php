<?php

namespace Multiple_Images_Field;

class Main {
	public static function initialize() {
		include_once( MULTIPLE_IMAGES_FIELD_PATH . 'classes/class-setting.php' );
		include_once( MULTIPLE_IMAGES_FIELD_PATH . 'includes/functions.php' );

		if ( is_admin() ) {
			add_action( 'admin_init', [ __CLASS__, 'admin_init' ] );
			add_action( 'admin_menu', [ __CLASS__, 'admin_menu' ] );
			add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_enqueue_scripts' ] );
			add_action( 'add_meta_boxes', [ __CLASS__, 'add_meta_boxes' ] );
			add_action( 'save_post', [ __CLASS__, 'save_post' ], 10, 2 );
		}
	}

	public static function admin_init() {
		register_setting( 'multiple-images-field', 'multiple-images-field' );
	}

	public static function admin_menu() {
		add_options_page(
			'Multiple Images Field',
			'Multiple Images Field',
			'manage_options',
			'multiple-images-field',
			function () {
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
				}
				require( MULTIPLE_IMAGES_FIELD_PATH . 'includes/admin-option-page.php' );
			}
		);
	}

	public static function admin_enqueue_scripts( $hook_suffix ) {
		global $post_type;
		if ( in_array( $hook_suffix, [ 'post.php', 'post-new.php' ] )
		     && in_array( $post_type, Setting::get_enabled_post_type(), true ) ) {
			wp_enqueue_style(
				'multiple-images-field-meta-box-style',
				MULTIPLE_IMAGES_FIELD_URL . 'css/meta-box.css',
				[],
				MULTIPLE_IMAGES_FIELD_VERSION
			);

			wp_enqueue_script(
				'multiple-images-field-meta-box-script',
				MULTIPLE_IMAGES_FIELD_URL . 'js/meta-box.js',
				[ 'wp-i18n', 'jquery', 'jquery-ui-sortable' ],
				MULTIPLE_IMAGES_FIELD_VERSION,
				true
			);
			wp_set_script_translations( 'multiple-images-field-meta-box-script', 'multiple-images-field' );

			$support_thumbnail = post_type_supports( $post_type, 'thumbnail' );
			$json = wp_json_encode( [
				'maximum_number_of_image' => Setting::get_maximum_number_of_image(),
				'set_thumbnail' => $support_thumbnail && Setting::get_automatic_thumbnail_setting(),
			] );
			wp_add_inline_script(
				'multiple-images-field-meta-box-script',
				"var multiple_images_field = {$json};",
				'before'
			);
		}
	}

	public static function add_meta_boxes( $post_type ) {
		if ( in_array( $post_type, Setting::get_enabled_post_type(), true ) ) {
			add_meta_box(
				'multiple-images-field',
				'Multiple Images Field',
				function () {
					require( MULTIPLE_IMAGES_FIELD_PATH . 'includes/meta_box.php' );
				},
				$post_type,
				'normal'
			);
		}
	}

	public static function save_post( $post_id, $post ) {
		if ( in_array( $post->post_type, Setting::get_enabled_post_type(), true ) ) {
			if ( isset( $_POST['multiple-images-field'] ) && is_array( $_POST['multiple-images-field'] ) ) {
                $sanitized = array_map( 'absint', array_values( $_POST['multiple-images-field'] ) );
				update_post_meta( $post_id, 'multiple-images-field', $sanitized );
			} else {
				delete_post_meta( $post_id, 'multiple-images-field' );
			}
		}
	}
}