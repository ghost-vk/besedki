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
	// General scripts
	wp_enqueue_script('store', get_stylesheet_directory_uri() . '/js/lib/store.js', array(), null, true);
	wp_enqueue_script('notification', get_stylesheet_directory_uri() . '/js/lib/Notification.js', array('jquery'), null, true);
	wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/519fd0f28a.js', array(), null, true);
	wp_enqueue_script('header', get_template_directory_uri() . '/js/header.js', array('jquery'), null, true);
	wp_enqueue_script('server-client', get_template_directory_uri() . '/js/lib/ServerClient.js', array('jquery'), null, true);
	wp_enqueue_script('libphonenumber', 'https://unpkg.com/libphonenumber-js@1.x/bundle/libphonenumber-min.js', array(), null, true);
	wp_enqueue_script('callback', get_template_directory_uri() . '/js/callback.js', array('jquery', 'libphonenumber'), null, true);
	wp_localize_script('callback', 'generalSettings', array(
		'path' => get_stylesheet_directory_uri(),
		'nonce' => wp_create_nonce('callback_nonce'),
		'url' => admin_url('admin-ajax.php'),
	));
	
	// Shop page - Reservation page
	if ( is_archive() ) {
		wp_enqueue_script('custom-select', get_template_directory_uri() . '/libraries/custom-select-box/select.min.js', array('jquery'), null, true);
		wp_enqueue_script('datetimepicker', get_template_directory_uri() . '/libraries/datetimepicker/build/jquery.datetimepicker.full.js', array('jquery'), null, true);
		
		wp_enqueue_script('popup-lib', get_template_directory_uri() . '/js/lib/Popup.js', array( // Main handler
			'jquery',
			'store',
			'slider-handler',
			'select-handler',
			'datetime-handler',
			'booking',
		), null, true);
		wp_enqueue_script('slider-handler', get_template_directory_uri() . '/js/lib/Slider.js', array('jquery', 'slick'), null, true);
		wp_enqueue_script('select-handler', get_template_directory_uri() . '/js/lib/SelectDuration.js', array('jquery', 'custom-select'), null, true);
		wp_enqueue_script('datetime-handler', get_template_directory_uri() . '/js/lib/DatetimeHandler.js', array('jquery', 'datetimepicker'), null, true);
		wp_enqueue_script('booking', get_template_directory_uri() . '/js/lib/Booking.js', array(), null, true);
		
		wp_enqueue_script('map', get_template_directory_uri() . '/js/reservation/map.js', array('jquery', 'custom-select', 'datetimepicker'), null, true);
		wp_localize_script('map', 'mapData', array(
			'nonce' => wp_create_nonce('map_nonce'),
			'url' => admin_url('admin-ajax.php'),
			'icon' => get_stylesheet_directory_uri() . '/img/icon/point-icon.png',
			'testImage' => get_stylesheet_directory_uri() . '/img/picture/cart_item.jpg',
		));
		
		wp_enqueue_script('slick', get_template_directory_uri() . '/libraries/slick/slick.min.js', array('jquery'), null, true);
		
		wp_enqueue_script('popup', get_template_directory_uri() . '/js/reservation/popup.js', array('jquery', 'custom-select', 'slick', 'server-client'), null, true);
		wp_localize_script('popup', 'popupData', array(
			'nonce' => wp_create_nonce('popup_nonce'),
			'url' => admin_url('admin-ajax.php'),
			'cartURL' => home_url('/cart'),
		));
//		wp_enqueue_script('datetime', get_template_directory_uri() . '/js/datetime.js', array('jquery', 'datetimepicker'), null, true);
//		wp_localize_script('datetime', 'bookingDatetime', array(
//			'nonce' => wp_create_nonce('booking_nonce'),
//			'url' => admin_url('admin-ajax.php'),
//			'cart_url' => home_url('/cart'),
//		));
//		wp_localize_script('map', 'mapData', array(
//			'bookingMapData' => get_stylesheet_directory_uri() . '/booking-map-data.json',
//		));
	}
	
	// Homepage
	if ( is_front_page() ) { // Homepage
		wp_enqueue_script('slick', get_template_directory_uri() . '/libraries/slick/slick.js', array('jquery'), null, true);
		wp_enqueue_script('viewport-checker', get_template_directory_uri() . '/libraries/viewportchecker/viewportChecker.js', array('jquery'), null, true);
		wp_enqueue_script('sticky-button', get_template_directory_uri() . '/js/sticky-button.js', array('jquery'), null, true);
		wp_enqueue_script('homepage', get_template_directory_uri() . '/js/homepage.js', array('jquery', 'slick', 'viewport-checker'), null, true);
	}
	
	// Reviews
	if ( is_page('reviews') ) {
		wp_enqueue_script('sticky-button', get_template_directory_uri() . '/js/sticky-button.js', array('jquery'), null, true);
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
		wp_enqueue_script('mask-input', get_template_directory_uri() . '/libraries/jquery.maskedinput/src/jquery.maskedinput.js', array('jquery'), null, true);
		wp_enqueue_script('checkout-validation', get_template_directory_uri() . '/js/checkout-validation.js', array('jquery', 'mask-input'), null, true);
	}
}