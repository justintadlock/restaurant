<?php
/**
 * @package Restaurant
 * @subpackage Admin
 */

/* Adds the content permissions meta box to the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'restaurant_item_price_create_meta_box' );

/* Saves the content permissions metabox data to a custom field. */
add_action( 'save_post', 'restaurant_item_price_save_meta', 10, 2 );

/**
 * @since 0.1.0
 */
function restaurant_item_price_create_meta_box() {

	add_meta_box( 'menu-item-price', __( 'Price', 'members' ), 'restaurant_item_price_meta_box', 'restaurant_item', 'side', 'default' );
}

/**
 * @since 0.1.0
 */
function restaurant_item_price_meta_box( $object, $box ) { ?>

	<input type="hidden" name="menu_item_price_meta_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

	<p>
		<?php _e( '$', 'restaurant' ); ?> <input type="text" name="menu-item-price" value="<?php echo esc_attr( get_post_meta( $object->ID, '_restaurant_item_price', true ) ); ?>" />
	</p>
<?php
}

/**
 * @since 0.1.0
 */
function restaurant_item_price_save_meta( $post_id, $post ) {

	/* Verify the nonce. */
	if ( !isset( $_POST['menu_item_price_meta_nonce'] ) || !wp_verify_nonce( $_POST['menu_item_price_meta_nonce'], plugin_basename( __FILE__ ) ) )
		return;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) return;
	if ( defined( 'DOING_CRON' ) && DOING_CRON ) return;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Don't save if the post is only a revision. */
	if ( 'revision' == $post->post_type )
		return;

	$meta = array(
		'_restaurant_item_price' => esc_html( $_POST['menu-item-price'] )
	);

	foreach ( $meta as $meta_key => $new_meta_value ) {

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );
	}

}

?>