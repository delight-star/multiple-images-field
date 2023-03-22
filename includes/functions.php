<?php
if ( ! defined( 'MULTIPLE_IMAGES_FIELD_ENABLED' ) ) {
    exit;
}

if ( ! function_exists( 'array_key_first' ) ) {
	function array_key_first( array $arr ) {
		foreach ( $arr as $key => $unused ) {
			return $key;
		}

		return null;
	}
}

if ( ! function_exists( 'mif_get_attachment_ids' ) ) {
	function mif_get_attachment_ids(): array {
		global $post;
		$attachment_ids = get_post_meta( $post->ID, 'multiple-images-field', true );
		if ( ! is_array( $attachment_ids ) ) {
			$attachment_ids = [];
		}
        $escaped_attachment_ids = array_map( 'absint', array_values( $attachment_ids ) );
        $max_length = \Multiple_Images_Field\Setting::get_maximum_number_of_image();

		return array_slice( $escaped_attachment_ids, 0, $max_length );
	}
}

if ( ! function_exists( 'mif_get_first_attachment_id' ) ) {
	function mif_get_first_attachment_id() {
		$attachment_ids = mif_get_attachment_ids();
		$first_key      = array_key_first( $attachment_ids );
		if ( is_null( $first_key ) ) {
			return null;
		}

		return $attachment_ids[ $first_key ];
	}
}

if ( ! function_exists( 'mif_has_image' ) ) {
	function mif_has_image(): bool {
		$attachment_id = mif_get_first_attachment_id();

		return ! is_null( $attachment_id );
	}
}