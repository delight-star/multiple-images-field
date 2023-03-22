<?php
namespace Multiple_Images_Field;
if ( ! defined( 'MULTIPLE_IMAGES_FIELD_ENABLED' ) ) {
	exit;
}
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Multiple Images Field Settings', 'multiple-images-field' ); ?></h1>
	<form action="options.php" method="post">
		<?php settings_fields( 'multiple-images-field' ); ?>
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Enabled post types', 'multiple-images-field' ); ?>
				</th>
				<td>
					<?php foreach ( get_post_types( [ 'show_ui' => true ], 'objects' ) as $post_type ) : ?>
						<div>
							<input type="checkbox"
								   name="multiple-images-field[<?php echo Setting::ENABLED_POST_TYPES; ?>][]"
								   value="<?php echo esc_attr( $post_type->name ); ?>"
								   id="enabled-post-type[<?php echo esc_attr( $post_type->name ); ?>]"
								<?php checked( in_array( $post_type->name, Setting::get_enabled_post_type(), true ) ); ?> />
							<label for="enabled-post-type[<?php echo esc_attr( $post_type->name ); ?>]">
								<?php echo esc_html( $post_type->label ); ?>
							</label>
						</div>
					<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr( Setting::MAXIMUM_NUMBER_OF_IMAGES ); ?>">
						<?php esc_html_e( 'Maximum image count', 'multiple-images-field' ); ?>
					</label>
				</th>
				<td>
					<input type="text"
						   size="5"
						   name="multiple-images-field[<?php echo Setting::MAXIMUM_NUMBER_OF_IMAGES; ?>]"
						   value="<?php echo esc_attr( Setting::get_maximum_number_of_image() ); ?>"
						   id="<?php echo esc_attr( Setting::MAXIMUM_NUMBER_OF_IMAGES ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Featured Image', 'multiple-images-field' ); ?>
				</th>
				<td>
					<input type="hidden"
						   name="multiple-images-field[<?php echo esc_attr( Setting::AUTOMATIC_THUMBNAIL_SETTING ); ?>]"
						   value="0" />
					<input type="checkbox"
						   name="multiple-images-field[<?php echo esc_attr( Setting::AUTOMATIC_THUMBNAIL_SETTING ); ?>]"
						   value="1"
						   id="<?php echo esc_attr( Setting::AUTOMATIC_THUMBNAIL_SETTING ); ?>"
						   <?php checked( Setting::get_automatic_thumbnail_setting() ); ?> />
					<label for="<?php echo esc_attr( Setting::AUTOMATIC_THUMBNAIL_SETTING ); ?>">
						<?php esc_html_e( 'Register the first image as a featured image.', 'multiple-images-field' ); ?>
					</label>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>