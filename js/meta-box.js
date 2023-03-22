jQuery( function( $ ) {
    const { __ } = wp.i18n;
    const setting = multiple_images_field;
    const delete_button_class = '.multiple-images-field-delete-button button';
    const item_class = '.multiple-images-field-item';
    const add_button_id = '#multiple-images-field-add-button button';
    const box_id = '#multiple-images-field-box';
    var wp_media;

    $( document ).ready( function() {
        toggle_disabled_state_for_add_button();
    });

    $( add_button_id ).click( function( event ) {
        event.preventDefault();

        if ( wp_media ) {
            wp_media.open();
            return;
        }

        wp_media = wp.media( {
            title: 'Multiple Images Field',
            multiple: true,
            library: {
                type: 'image',
            },
        });
        wp_media.on( 'select', function() {
            const images = wp_media.state().get( 'selection' ).toJSON();
            const html = images.map( image => {
                const thumbnail = image.sizes.thumbnail;
                return [
                    '<div class="multiple-images-field-item">',
                    '<img src="' + thumbnail.url + '" width="' + thumbnail.width + '" height="' + thumbnail.height + '">',
                    '<input type="hidden" name="multiple-images-field[]" value="' + image.id + '">',
                    '<div class="multiple-images-field-delete-button">',
                    '<button type="button" class="button button-small">' + __( 'Delete', 'multiple-images-field' ) + '</button>',
                    '</div>',
                    '</div>'
                ].join('');
            }).slice( 0, get_remaining_number() ).join('');
            $( box_id ).append( html );
            toggle_disabled_state_for_add_button();
            set_featured_image();
            wp_media.state().get( 'selection' ).reset();
        });
        wp_media.open();
    });

    $(box_id).sortable({
        items: item_class,
        containment: box_id,
        handle: 'img',
        opacity: 0.5,
        tolerance: 'pointer',
        cursor: 'move',
        revert: 100,
        placeholder: 'multiple-images-field-item-placeholder',
        forcePlaceholderSize: true,
        update: function() {
            set_featured_image();
        }
    });

    $( box_id ).on( 'click', delete_button_class, function ( event ) {
        event.preventDefault();
        $( this ).closest( item_class ).fadeOut( 'fast', function() {
            $( this ).remove();
            toggle_disabled_state_for_add_button();
            set_featured_image();
        });
    });

    function get_remaining_number() {
        const max = setting.maximum_number_of_image;
        const sum = $( item_class ).length;
        return Math.max( max - sum, 0 );
    }

    function toggle_disabled_state_for_add_button() {
        const disabled = get_remaining_number() <= 0;
        $( add_button_id ).prop( 'disabled', disabled );
    }

    function set_featured_image() {
        if ( setting.set_thumbnail ) {
            const first_image_id = $( item_class ).first().find( 'input[name="multiple-images-field[]"]' ).val();
            // Classic Editor
            if ( wp.media.featuredImage ) {
                wp.media.featuredImage.set( first_image_id ?? -1 );
            }
            // Gutenberg
            if ( wp.data && document.body.classList.contains( 'block-editor-page' ) ) {
                wp.data.dispatch( 'core/editor' ).editPost( { featured_media: first_image_id ?? 0 } );
            }
        }
    }
});