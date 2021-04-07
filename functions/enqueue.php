<?php
// Get minify jQuery from Google CDN
add_action( 'wp_enqueue_scripts', 'add_jquery', 99 );
function add_jquery() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}

// Styles
add_action('wp_enqueue_scripts', 'add_styles');
function add_styles() {
	wp_enqueue_style( 'main', get_template_directory_uri() . '/style/main.css' );
	wp_enqueue_style( 'datetimepicker', get_template_directory_uri() . '/libraries/datetimepicker/jquery.datetimepicker.css' );
	
	if ( is_front_page() ) { // Homepage
		wp_enqueue_style( 'slick', get_template_directory_uri() . '/libraries/slick/slick.css' );
		wp_enqueue_style( 'homepage', get_template_directory_uri() . '/style/homepage.css' );
		wp_enqueue_style( 'animate', get_template_directory_uri() . '/node_modules/animate.css/animate.min.css' );
	}
	
	if ( is_page('reviews') ) { // Reviews
		wp_enqueue_style( 'reviews', get_template_directory_uri() . '/style/reviews.css' );
	}
	
	if ( is_page(
		[
			'privacy', // Политика конфиденциальности
			'user-agreement', // Пользовательское соглашение
			'rent-agreement', // Оферта
		]
	) ) {
		wp_enqueue_style( 'page-document', get_template_directory_uri() . '/style/page-document.css' );
	}
	
	if ( is_page(
		[
			'cart',
			'checkout',
		]
	) ) {
		wp_enqueue_style( 'page-document', get_template_directory_uri() . '/style/cart.css' );
	}
	
	if ( is_archive() ) {
		wp_enqueue_style( 'page-document', get_template_directory_uri() . '/style/reservation.css' );
	}
}

// Scripts
add_action ('wp_enqueue_scripts', 'add_scripts');
function add_scripts () {
	wp_enqueue_script('header', get_template_directory_uri() . '/js/header.js', array('jquery'), null, true);
	wp_enqueue_script('libphonenumber', 'https://unpkg.com/libphonenumber-js@1.x/bundle/libphonenumber-min.js', array(), null, true);
	wp_enqueue_script('callback', get_template_directory_uri() . '/js/callback.js', array('jquery', 'libphonenumber'), null, true);
	wp_localize_script('callback', 'generalSettings', array(
		'path' => get_stylesheet_directory_uri(),
		'nonce' => wp_create_nonce('callback_nonce'),
		'url' => admin_url('admin-ajax.php'),
	));
	
	if ( is_archive() ) {
		wp_enqueue_script('datetimepicker', get_template_directory_uri() . '/libraries/datetimepicker/build/jquery.datetimepicker.full.js', array('jquery'), null, true);
		wp_enqueue_script('datetime', get_template_directory_uri() . '/js/datetime.js', array('jquery', 'datetimepicker'), null, true);
		wp_enqueue_script('yandex-map-api', 'https://api-maps.yandex.ru/2.1/?lang=ru-RU&amp;apikey=417f5206-2e2a-4260-a439-90080e8435ff', array(), null, true);
		wp_enqueue_script('map', get_template_directory_uri() . '/js/yandex-map.js', array('jquery', 'datetimepicker', 'yandex-map-api'), null, true);
		wp_localize_script('datetime', 'bookingDatetime', array(
			'nonce' => wp_create_nonce('booking_nonce'),
			'url' => admin_url('admin-ajax.php'),
			'cart_url' => home_url('/cart'),
		));
		wp_localize_script('map', 'mapData', array(
			'bookingMapData' => get_stylesheet_directory_uri() . '/booking-map-data.json',
		));
	}
	
	if ( is_front_page() ) { // Homepage
		wp_enqueue_script('slick', get_template_directory_uri() . '/libraries/slick/slick.js?123', array('jquery'), null, true);
		wp_enqueue_script('viewport-checker', get_template_directory_uri() . '/libraries/viewportchecker/viewportChecker.js', array('jquery'), null, true);
		wp_enqueue_script('sticky-button', get_template_directory_uri() . '/js/sticky-button.js', array('jquery'), null, true);
		wp_enqueue_script('homepage', get_template_directory_uri() . '/js/homepage.js', array('jquery', 'slick', 'viewport-checker'), null, true);
	}
	
	if ( is_page('reviews') ) { // Reviews
		wp_enqueue_script('sticky-button', get_template_directory_uri() . '/js/sticky-button.js', array('jquery'), null, true);
	}
	
	if ( is_page(
		array (
			'cart',
			'checkout',
		)
	) ) {
		wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/519fd0f28a.js', [], null, true);
	}
	
	if ( is_page('checkout') ) {
		wp_dequeue_script( 'wc-checkout' );
		wp_enqueue_script('mask-input', get_template_directory_uri() . '/libraries/jquery.maskedinput/src/jquery.maskedinput.js', array('jquery'), null, true);
		wp_enqueue_script('checkout-validation', get_template_directory_uri() . '/js/checkout-validation.js', array('jquery', 'mask-input'), null, true);
	}
}