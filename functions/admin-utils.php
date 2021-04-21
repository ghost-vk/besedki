<?php

/**
 * Removes comments from WP
 */
add_action('admin_init', function () {
	// Redirect any user trying to access comments page
	global $pagenow;
	
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
	
	// Remove comments metabox from dashboard
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	
	// Disable support for comments and trackbacks in post types
	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
		remove_post_type_support($post_type, 'comments');
		remove_post_type_support($post_type, 'trackbacks');
		}
	}
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page and posts page
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
	remove_menu_page('edit.php');
});

// Remove comments tab from top admin bar
add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );
function my_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}

// Remove comments links from admin bar
add_action('init', function () {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
});

/**
 * Removes marketing tab
 */
function filter_woocommerce_admin_get_feature_config( $feature_config ) {
	$feature_config['marketing'] = false;
	return $feature_config;
}
add_filter( 'woocommerce_admin_get_feature_config', 'filter_woocommerce_admin_get_feature_config', 10, 1 );


// http://www.php.net/manual/en/function.array-search.php#91365
function recursive_array_search_php_91365( $needle, $haystack ) {
	foreach( $haystack as $key => $value ) {
		$current_key = $key;
		if ( $needle === $value
			OR (
				is_array( $value )
				&& recursive_array_search_php_91365( $needle, $value ) !== false
			)
		) {
			return $current_key;
		}
	}
	return false;
}

/**
 * Renames WooCommerce tabs
 */
add_action( 'admin_menu', 'rename_woocoomerce_wpse_100758', 999 );
function rename_woocoomerce_wpse_100758() {
	global $menu;
	
	$woo = recursive_array_search_php_91365( 'WooCommerce', $menu );
	$products_tab_name = recursive_array_search_php_91365( 'Товары', $menu );
	if( !$woo ) {
		return;
	}
	
	$menu[$woo][0] = 'Аренда';
	$menu[$products_tab_name][0] = 'Беседки';
	
}

/**
 * Removes metabox fields from WooCommerce admin product cards panel
 */
add_action('add_meta_boxes', 'remove_product_metabox', 999);
function remove_product_metabox() {
	remove_meta_box( 'postexcerpt', 'product', 'normal'); // Short description
	remove_meta_box( 'tagsdiv-product_tag', 'product', 'side' ); // Product tags
	remove_meta_box( 'woocommerce-product-images',  'product', 'side'); // Products gallery
	remove_meta_box('product_catdiv', 'product', 'normal'); // Products category - `besedki` is default
}

/**
 * Removes unused product data tabs
 */
add_filter('woocommerce_product_data_tabs', 'remove_tab', 10, 1);
function remove_tab ($tabs) {
	unset($tabs['inventory']); // it is to remove inventory tab
	unset($tabs['linked_product']); // it is to remove linked_product tab
	unset($tabs['shipping']); // it is to remove shipping tab
	
	return($tabs);
}



/*
 * Функция создает дубликат поста в виде черновика и редиректит на его страницу редактирования
 */
function true_duplicate_post_as_draft () {
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'true_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('Нечего дублировать!');
	}
	
	/*
	 * получаем ID оригинального поста
	 */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	/*
	 * а затем и все его данные
	 */
	$post = get_post( $post_id );
	
	/*
	 * если вы не хотите, чтобы текущий автор был автором нового поста
	 * тогда замените следующие две строчки на: $new_post_author = $post->post_author;
	 * при замене этих строк автор будет копироваться из оригинального поста
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
	
	/*
	 * если пост существует, создаем его дубликат
	 */
	if (isset( $post ) && $post != null) {
		
		/*
		 * массив данных нового поста
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft', // черновик, если хотите сразу публиковать - замените на publish
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
		
		/*
		 * создаем пост при помощи функции wp_insert_post()
		 */
		$new_post_id = wp_insert_post( $args );
		
		/*
		 * присваиваем новому посту все элементы таксономий (рубрики, метки и т.д.) старого
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // возвращает массив названий таксономий, используемых для указанного типа поста, например array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
		
		/*
		 * дублируем все произвольные поля
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
		
		
		/*
		 * и наконец, перенаправляем пользователя на страницу редактирования нового поста
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Ошибка создания поста, не могу найти оригинальный пост с ID=: ' . $post_id);
	}
}
add_action( 'admin_action_true_duplicate_post_as_draft', 'true_duplicate_post_as_draft' );

/**
 * Добавляем ссылку дублирования поста для post_row_actions
 */
function true_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="admin.php?action=true_duplicate_post_as_draft&post=' . $post->ID . '" title="Дублировать этот пост" rel="permalink">Дублировать</a>';
	}
	return $actions;
}

add_filter( 'post_row_actions', 'true_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'true_duplicate_post_link', 10, 2 );
add_filter( 'reviews_row_actions', 'true_duplicate_post_link', 10, 2 );

/**
 * Support WooCommerce for custom theme
 */
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );