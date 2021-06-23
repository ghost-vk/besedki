<?php
/**
 * Function disables woocommerce styles
 */
function dequeue_woo_style() {
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wc-block-vendors-style');
	wp_dequeue_style('wc-block-style');
	wp_dequeue_style('woocommerce-layout');
	wp_dequeue_style('woocommerce-smallscreen');
	wp_dequeue_style('woocommerce-general');
}

/**
 * Function disables default woocommerce scripts
 */
function dequeue_woo_scripts() {
	wp_dequeue_script( 'selectWoo' );
	wp_deregister_script( 'selectWoo' );
	wp_dequeue_script( 'wc-add-payment-method' );
	wp_dequeue_script( 'wc-lost-password' );
	wp_dequeue_script( 'wc_price_slider' );
	wp_dequeue_script( 'wc-single-product' );
	wp_dequeue_script( 'wc-add-to-cart' );
	wp_dequeue_script( 'wc-cart-fragments' );
	wp_dequeue_script( 'wc-credit-card-form' );
	wp_dequeue_script( 'wc-checkout' );
	wp_dequeue_script( 'wc-add-to-cart-variation' );
	wp_dequeue_script( 'wc-single-product' );
	wp_dequeue_script( 'wc-cart' );
	wp_dequeue_script( 'wc-chosen' );
	wp_dequeue_script( 'woocommerce' );
	wp_dequeue_script( 'prettyPhoto' );
	wp_dequeue_script( 'prettyPhoto-init' );
	wp_dequeue_script( 'jquery-blockui' );
	wp_dequeue_script( 'jquery-placeholder' );
	wp_dequeue_script( 'jquery-payment' );
	wp_dequeue_script( 'fancybox' );
	wp_dequeue_script( 'jqueryui' );
}

/**
 * Enqueue styles
 */
add_action('wp_enqueue_scripts', 'add_styles');
function add_styles() {
	wp_enqueue_style( 'main', get_template_directory_uri() . '/dist/general.css?v=1.2.2' );
	
	if ( is_front_page() ) { // Homepage
		wp_enqueue_style( 'homepage', get_template_directory_uri() . '/dist/homepage.css?v=1.2.2' );
	} else if ( is_page('reviews') ) { // Reviews
		wp_enqueue_style( 'reviews', get_template_directory_uri() . '/dist/reviews.css?v=1.2.2' );
	} else if ( is_page(array('privacy', 'user-agreement', 'rent-agreement')) ) { // Documents
		wp_enqueue_style( 'page-document', get_template_directory_uri() . '/style/page-document.css?v=1.2.2' );
	} else if ( is_page(array('cart', 'checkout')) ) { // Woocommerce cart and checkout
		wp_enqueue_style( 'cart', get_template_directory_uri() . '/dist/checkout.css?v=1.2.2' );
	} else if ( is_shop() ) { // Booking page
		wp_enqueue_style( 'reservation-map', get_template_directory_uri() . '/dist/reservation.css?v=1.2.2' );
	}
	
	if ( ! is_page(array('checkout', 'cart')) ) {
		dequeue_woo_style();
	}
}

/**
 * Enqueue scripts
 */
add_action ('wp_enqueue_scripts', 'add_scripts');
function add_scripts () {
	$directory = get_stylesheet_directory_uri();
	global $home_page_id;
	dequeue_woo_scripts();
	
	/**
	 * Ref script
	 */
	wp_enqueue_script('ref', $directory . '/js/ref.js', array(), null, true);
	
	// Localize callback
	wp_localize_script('ref', 'callbackText', array( 'text' => get_field('notification_callback_success', $home_page_id) ));
	
	// Localize store with primary settings
	wp_localize_script('ref', 'mainSettings', array(
		'nonce' => wp_create_nonce('store_nonce'),
		'url' => admin_url('admin-ajax.php'),
		'privacyUrl' => home_url('/privacy'),
		'reservationPageUrl' => home_url('/reservation'),
	));
	
	if ( ! is_admin() ) { // Front end
		wp_deregister_script( 'jquery' ); // Remove default jquery
	}
	
	if ( is_front_page() ) { // Homepage
		wp_enqueue_script('homepage', $directory . '/dist/homepage.bundle.js?v=1.2.2', array('ref'), null, true);
	} else if ( is_shop() ) { // Booking page
		// Localize store to works with map
		wp_localize_script('ref', 'mapState', array(
			'icon' => $directory . '/img/icon/point-icon.png',
			'defaultPoints' => get_default_points_data(),
			'cartURL' => home_url('/cart'),
		));
		wp_enqueue_script('reservation', $directory . '/dist/reservation.bundle.js?v=1.2.2', array(), null, true);
	} else if ( is_page('reviews') ) { // Reviews
		wp_enqueue_script('reviews', $directory . '/dist/reviews.bundle.js?v=1.2.2', array('ref'), null, true);
	} else if ( is_page('checkout') ) { // Checkout
		wp_enqueue_script('checkout', $directory . '/dist/checkout.bundle.js?v=1.2.2', array(), null, true);
	} else {
		wp_enqueue_script('general', $directory . '/dist/general.bundle.js?v=1.2.2', array(), null, true);
	}
}

/**
 * Remove wp-embed script from footer
 */
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );