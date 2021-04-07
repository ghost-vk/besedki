<?php
add_action( 'after_setup_theme', 'register_menu' );
function register_menu() {
	register_nav_menus( [
		'header_menu' => 'Меню в шапке',
//		'footer_menu' => 'Footer menu',
//		'sidebar_menu' => 'Sidebar menu'
	] );
}