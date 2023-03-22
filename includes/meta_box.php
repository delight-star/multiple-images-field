<?php
namespace Multiple_Images_Field;
if ( ! defined( 'MULTIPLE_IMAGES_FIELD_ENABLED' ) ) {
	exit;
}
?>
<div id="multiple-images-field-wrap">
	<div id="multiple-images-field-add-button">
		<button type="button" class="button button-primary button-large">
			<?php esc_html_e( 'Add Image', 'multiple-images-field' ); ?>
		</button>
	</div>
	<div id="multiple-images-field-box">
		<?php foreach ( mif_get_attachment_ids() as $attachment_id ) : ?>
			<div class="multiple-images-field-item">
				<?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?>
				<input type="hidden" name="multiple-images-field[]" value="<?php echo esc_attr( $attachment_id ); ?>">
				<div class="multiple-images-field-delete-button">
					<button type="button" class="button button-small">
						<?php esc_html_e( 'Delete', 'multiple-images-field' ); ?>
					</button>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<p>
		<?php printf( __( 'A maximum of %d images can be registered.', 'multiple-images-field' ), Setting::get_maximum_number_of_image() ); ?>
		<?php esc_html_e( "It's possible to change order of images by drag & drop.", 'multiple-images-field' ); ?>
	</p>
</div>