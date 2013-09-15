<?php



add_action( 'init', 'rp_add_image_sizes' );

add_filter( 'template_include', 'rp_template_include', 15 );

add_filter( 'wp_title', 'rp_wp_title' );

add_filter( 'body_class', 'rp_body_class' );

add_action( 'pre_get_posts', 'rp_pre_get_posts' );

add_filter( 'posts_request', 'rp_posts_request', 10, 2 );









?>