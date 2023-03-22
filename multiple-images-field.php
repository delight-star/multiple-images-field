<?php

/*
Plugin Name: Multiple Images Field
Description: Add a field for setting multiple images to posts screen.
Version:     1.0.0
Author:      Delight Star Inc.
Author URI:  https://delight-star.co.jp/
License:     GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'MULTIPLE_IMAGES_FIELD_ENABLED' ) ) {
	exit( __( 'Multiple Images Field is already activated.', 'multiple-images-field' ) );
}

$plugin_meta = get_file_data( __FILE__, [ 'version' => 'Version' ], 'plugin' );

define( 'MULTIPLE_IMAGES_FIELD_ENABLED', true );
define( 'MULTIPLE_IMAGES_FIELD_VERSION', $plugin_meta['version'] );
define( 'MULTIPLE_IMAGES_FIELD_PATH', plugin_dir_path( __FILE__ ) );
define( 'MULTIPLE_IMAGES_FIELD_URL', plugin_dir_url( __FILE__ ) );

include_once( MULTIPLE_IMAGES_FIELD_PATH . 'classes/class-main.php' );
Multiple_Images_Field\Main::initialize();