<?php
 function has_post_thumbnail( $post = null ) { $thumbnail_id = get_post_thumbnail_id( $post ); $has_thumbnail = (bool) $thumbnail_id; return (bool) apply_filters( 'has_post_thumbnail', $has_thumbnail, $post, $thumbnail_id ); } function get_post_thumbnail_id( $post = null ) { $post = get_post( $post ); if ( ! $post ) { return false; } $thumbnail_id = (int) get_post_meta( $post->ID, '_thumbnail_id', true ); return (int) apply_filters( 'post_thumbnail_id', $thumbnail_id, $post ); } function the_post_thumbnail( $size = 'post-thumbnail', $attr = '' ) { echo get_the_post_thumbnail( null, $size, $attr ); } function update_post_thumbnail_cache( $wp_query = null ) { if ( ! $wp_query ) { $wp_query = $GLOBALS['wp_query']; } if ( $wp_query->thumbnails_cached ) { return; } $thumb_ids = array(); foreach ( $wp_query->posts as $post ) { $id = get_post_thumbnail_id( $post->ID ); if ( $id ) { $thumb_ids[] = $id; } } if ( ! empty( $thumb_ids ) ) { _prime_post_caches( $thumb_ids, false, true ); } $wp_query->thumbnails_cached = true; } function get_the_post_thumbnail( $post = null, $size = 'post-thumbnail', $attr = '' ) { $post = get_post( $post ); if ( ! $post ) { return ''; } $post_thumbnail_id = get_post_thumbnail_id( $post ); $size = apply_filters( 'post_thumbnail_size', $size, $post->ID ); if ( $post_thumbnail_id ) { do_action( 'begin_fetch_post_thumbnail_html', $post->ID, $post_thumbnail_id, $size ); if ( in_the_loop() ) { update_post_thumbnail_cache(); } $html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr ); do_action( 'end_fetch_post_thumbnail_html', $post->ID, $post_thumbnail_id, $size ); } else { $html = ''; } return apply_filters( 'post_thumbnail_html', $html, $post->ID, $post_thumbnail_id, $size, $attr ); } function get_the_post_thumbnail_url( $post = null, $size = 'post-thumbnail' ) { $post_thumbnail_id = get_post_thumbnail_id( $post ); if ( ! $post_thumbnail_id ) { return false; } $thumbnail_url = wp_get_attachment_image_url( $post_thumbnail_id, $size ); return apply_filters( 'post_thumbnail_url', $thumbnail_url, $post, $size ); } function the_post_thumbnail_url( $size = 'post-thumbnail' ) { $url = get_the_post_thumbnail_url( null, $size ); if ( $url ) { echo esc_url( $url ); } } function get_the_post_thumbnail_caption( $post = null ) { $post_thumbnail_id = get_post_thumbnail_id( $post ); if ( ! $post_thumbnail_id ) { return ''; } $caption = wp_get_attachment_caption( $post_thumbnail_id ); if ( ! $caption ) { $caption = ''; } return $caption; } function the_post_thumbnail_caption( $post = null ) { echo apply_filters( 'the_post_thumbnail_caption', get_the_post_thumbnail_caption( $post ) ); } 