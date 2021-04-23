<?php get_header(); ?>

<?php
require_once __DIR__ . '/../functions/bookingProduct.class.php';
$_bp = new BESEDKA\bookingProduct(336);
$_bp->add_to_cart(array(
	'start_datetime' => '2021-05-12 12:00:00',
	'duration' => '3',
	'variation_id' => 338,
));
?>

<?php require_once __DIR__ . '/../blocks/reservation/map/map.php'; // Map with filters ?>

<?php require_once __DIR__ . '/../blocks/callback-section.php'; // Callback ?>

<?php require_once __DIR__ . '/../blocks/reservation/popups/popup-gallery.php'; // Popup gallery with detail data ?>

<?php get_footer(); ?>