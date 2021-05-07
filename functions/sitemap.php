<?php
/**
 * Unset providers (users)
 */
add_filter( 'wp_sitemaps_add_provider', 'kama_remove_sitemap_provider', 10, 2 );
function kama_remove_sitemap_provider( $provider, $name ){
	if( in_array( $name, ['users'] ) )
		return false;
	return $provider;
}

/**
 * Unset post types from sitemap
 */
add_filter( 'wp_sitemaps_post_types', 'remove_sitemaps_post_types' );
function remove_sitemaps_post_types( $post_types ){
	unset( $post_types['product'] );
	unset( $post_types['reviews'] );
	return $post_types;
}

/**
 * Unset taxonomies from sitemap
 */
add_filter( 'wp_sitemaps_taxonomies', 'remove_sitemaps_taxonomies' );
function remove_sitemaps_taxonomies( $taxonomies ){
	unset( $taxonomies['product_cat'] );
	return $taxonomies;
}

/**
 * Remove some urls from sitemap (privacy, cart, etc)
 */
add_filter( 'wp_sitemaps_posts_query_args', 'sitemaps_posts_query_args', 10, 2 );
function sitemaps_posts_query_args( $args, $post_type ){
	if ( 'post' !== $post_type ){
		return $args;
	}
	
	// учтем что этот параметр может быть уже установлен
	if( !isset( $args['post__not_in'] ) )
		$args['post__not_in'] = array();
	
	// Исключаем посты
	foreach( [ 7, 8, 176, 180, 182 ] as $post_id ){
		$args['post__not_in'][] = $post_id;
	}
	
	return $args;
}