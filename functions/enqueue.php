<?php
/**
 * Get minify jQuery from Google CDN
 */
add_action( 'wp_enqueue_scripts', 'add_jquery', 99 );
function add_jquery() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}

/**
 * Enqueue styles
 */
add_action('wp_enqueue_scripts', 'add_styles');
function add_styles() {
	// General styles
	wp_enqueue_style( 'main', get_template_directory_uri() . '/style/main.css' );
	wp_enqueue_style( 'datetimepicker', get_template_directory_uri() . '/libraries/datetimepicker/jquery.datetimepicker.css' );
	
	// Homepage
	if ( is_front_page() ) { // Homepage
		wp_enqueue_style( 'slick', get_template_directory_uri() . '/libraries/slick/slick.css' );
		wp_enqueue_style( 'homepage', get_template_directory_uri() . '/style/homepage.css' );
		wp_enqueue_style( 'animate', get_template_directory_uri() . '/node_modules/animate.css/animate.min.css' );
	}
	
	// Reviews
	if ( is_page('reviews') ) { // Reviews
		wp_enqueue_style( 'reviews', get_template_directory_uri() . '/style/reviews.css' );
	}
	
	// Document pages (privacy, agreements)
	if ( is_page(
		[
			'privacy', // Политика конфиденциальности
			'user-agreement', // Пользовательское соглашение
			'rent-agreement', // Оферта
		]
	) ) {
		wp_enqueue_style( 'page-document', get_template_directory_uri() . '/style/page-document.css' );
	}
	
	// Cart + checkout
	if ( is_page(
		array(
			'cart',
			'checkout',
		)
	) ) {
		wp_enqueue_style( 'page-document', get_template_directory_uri() . '/style/cart.css' );
	}
	
	// Shop page - Reservation page
	if ( is_archive() ) {
		wp_enqueue_style( 'custom-select-style', get_template_directory_uri() . '/libraries/custom-select-box/select.css' );
		wp_enqueue_style( 'reservation', get_template_directory_uri() . '/style/reservation-page/booking.css' );
	}
}

/**
 * Enqueue scripts
 */
add_action ('wp_enqueue_scripts', 'add_scripts');
function add_scripts () {
	$directory = get_stylesheet_directory_uri();
	
	// General scripts
	wp_enqueue_script('utils-besedka', $directory . '/js/lib/utils.js', array(), null, true);
	wp_enqueue_script('store', $directory . '/js/lib/store.js', array('utils-besedka'), null, true);
	wp_enqueue_script('notification', $directory . '/js/lib/Notification.js', array('jquery'), null, true);
	wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/519fd0f28a.js', array(), null, true);
	// Show that site is not full complete
	wp_enqueue_script('uncompleted-message', $directory . '/js/show-uncomlete.js', array('notification'), null, true);
	wp_enqueue_script('header', $directory . '/js/header.js', array('jquery'), null, true);
	wp_enqueue_script('server-client', $directory . '/js/lib/ServerClient.js', array('jquery'), null, true);
	wp_enqueue_script('libphonenumber', 'https://unpkg.com/libphonenumber-js@1.x/bundle/libphonenumber-min.js', array(), null, true);
	wp_enqueue_script('callback', $directory . '/js/callback.js', array('jquery', 'libphonenumber', 'notification'), null, true);
	wp_localize_script('callback', 'generalSettings', array(
		'path' => $directory,
		'nonce' => wp_create_nonce('callback_nonce'),
		'url' => admin_url('admin-ajax.php'),
	));
	wp_localize_script('store', 'mainSettings', array(
		'nonce' => wp_create_nonce('store_nonce'),
		'url' => admin_url('admin-ajax.php'),
	));
	
	// Shop page - Reservation page
	if ( is_archive() ) {
		wp_enqueue_script('loader', $directory . '/js/lib/Loader.js', array('jquery'), null, true);
		
		// Vendor
		wp_enqueue_script('custom-select', $directory . '/libraries/custom-select-box/select.min.js', array('jquery'), null, true);
		wp_enqueue_script('datetimepicker', $directory . '/libraries/datetimepicker/build/jquery.datetimepicker.full.js', array('jquery'), null, true);
		wp_enqueue_script('slick', $directory . '/libraries/slick/slick.min.js', array('jquery'), null, true);
		
		// BOOKING POPUP
		
		// Main handler
		wp_enqueue_script('popup-lib', $directory . '/js/lib/popup/Popup.js', array(
			'jquery',
			'store',
			'slider-handler',
			'select-handler',
			'datetime-handler',
			'booking',
			'loader'
		), null, true);
		wp_enqueue_script('slider-handler', $directory . '/js/lib/popup/Slider.js', array('jquery', 'slick'), null, true);
		wp_enqueue_script('select-handler', $directory . '/js/lib/popup/SelectDuration.js', array('jquery', 'custom-select'), null, true);
		wp_enqueue_script('datetime-handler', $directory . '/js/lib/popup/DatetimeHandler.js', array('jquery', 'datetimepicker'), null, true);
		wp_enqueue_script('booking', $directory . '/js/lib/popup/Booking.js', array(), null, true);
		
		
		// MAP
		
		// Main handler
		wp_enqueue_script('map-handler', $directory . '/js/lib/map/MapHandler.js', array(
			'jquery',
			'map-popup',
			'map-filter',
			'loader'
		), null, true);
		wp_enqueue_script('map-popup', $directory . '/js/lib/map/MapPopup.js', array('jquery'), null, true);
		wp_enqueue_script('map-filter', $directory . '/js/lib/map/MapFilter.js', array('jquery'), null, true);
		
		wp_localize_script('store', 'mapState', array(
			'icon' => $directory . '/img/icon/point-icon.png',
			'defaultPoints' => get_default_points_data(),
			'cartURL' => home_url('/cart'),
		));
		
		wp_enqueue_script('reservation', $directory . '/js/reservation.js', array('map-handler', 'popup-lib'), null, true);
		
	}
	
	// Homepage
	if ( is_front_page() ) { // Homepage
		wp_enqueue_script('slick', $directory . '/libraries/slick/slick.js', array('jquery'), null, true);
		wp_enqueue_script('viewport-checker', $directory . '/libraries/viewportchecker/viewportChecker.js', array('jquery'), null, true);
		wp_enqueue_script('sticky-button', $directory . '/js/sticky-button.js', array('jquery'), null, true);
		wp_enqueue_script('homepage', $directory . '/js/homepage.js', array('jquery', 'slick', 'viewport-checker'), null, true);
	}
	
	// Reviews
	if ( is_page('reviews') ) {
		wp_enqueue_script('sticky-button', $directory . '/js/sticky-button.js', array('jquery'), null, true);
	}
	
	// Cart + checkout
	if ( is_page(
		array (
			'cart',
			'checkout',
		)
	) ) {
		wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/519fd0f28a.js', array(), null, true);
	}
	
	// Checkout
	if ( is_page('checkout') ) {
		wp_dequeue_script( 'wc-checkout' );
		wp_enqueue_script('mask-input', $directory . '/libraries/jquery.maskedinput/src/jquery.maskedinput.js', array('jquery'), null, true);
		wp_enqueue_script('checkout-validation', $directory . '/js/checkout-validation.js', array('jquery', 'mask-input'), null, true);
	}
}