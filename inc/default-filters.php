<?php



add_action( 'init', 'rp_add_image_sizes' );

add_filter( 'template_include', 'rp_template_include', 15 );

add_filter( 'preprocess_comment', 'rp_preprocess_comment' );

add_filter( 'get_avatar_comment_types', 'rp_avatar_comment_types' );








?>