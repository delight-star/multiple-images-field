<?php

namespace Multiple_Images_Field;

class Setting {
	const ENABLED_POST_TYPES          = 'enabled_post_types';
	const MAXIMUM_NUMBER_OF_IMAGES    = 'maximum_number_of_images';
	const AUTOMATIC_THUMBNAIL_SETTING = 'automatic_thumbnail_setting';

	public static function get_enabled_post_type(): array {
		$option = self::get_option( self::ENABLED_POST_TYPES );
		if ( ! is_array( $option ) ) {
			return []; // default
		}

		return $option;
	}

	public static function get_maximum_number_of_image(): int {
		$option = self::get_option( self::MAXIMUM_NUMBER_OF_IMAGES );
		if ( ! is_numeric( $option ) ) {
			return 5; // default
		}

		return max( (int) $option, 1 );
	}

	public static function get_automatic_thumbnail_setting(): bool {
		$option = self::get_option( self::AUTOMATIC_THUMBNAIL_SETTING );
		if ( is_null( $option ) ) {
			return false; // default
		}
		return (bool) $option;
	}

	private static function get_option( string $name ) {
		$options = get_option( 'multiple-images-field', [] );

		return $options[ $name ] ?? null;
	}
}