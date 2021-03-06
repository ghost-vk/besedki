<?php
// Get template for pages/posts
add_filter( 'template_include', 'include_my_template' );
function include_my_template( $template ) {
	if ( is_front_page() ) { // Homepage
		return __DIR__ . '/../pages/homepage.php';
	}
	
	if ( is_page('reservation') ) {
		return __DIR__ . '/../pages/reservation.php';
	}
	
	if ( is_page('reviews') ) { // Reviews
		return __DIR__ . '/../pages/reviews.php';
	}
	
	// Cart
	if ( is_page('cart') ) {
		return __DIR__ . '/../pages/cart.php';
	}
	if ( is_cart() ) {
		return __DIR__ . '/../pages/cart.php';
	}
	
	if ( is_page('checkout') ) {
		return __DIR__ . '/../pages/checkout.php';
	}
	
	if ( is_page(
		array(
			'privacy', // Политика конфиденциальности
			'user-agreement', // Пользовательское соглашение
			'rent-agreement' // Оферта
		)
	) ) {
		return __DIR__ . '/../pages/document.php';
	}
	
	
	if ( is_page('test') ) {
		return __DIR__ . '/../pages/test.php';
	}
	return $template;
}
