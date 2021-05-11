<?php get_header(); ?>

<?php
if ( is_mobile() ) {
	require_once __DIR__ . '/../blocks/buttons/reservation-after-header-btn.php';
}
?>

<?php require_once __DIR__ . '/../blocks/homepage/promo.php'; ?>

<?php require_once __DIR__ . '/../blocks/homepage/post-content.php'; ?>

<?php require_once __DIR__ . '/../blocks/homepage/features.php'; ?>

<?php require_once __DIR__ . '/../blocks/homepage/home-carousel.php'; // Carousel section ?>

<?php require_once __DIR__ . '/../blocks/homepage/home-reviews.php'; // Highlight reviews ?>

<?php require_once __DIR__ . '/../blocks/homepage/numbers.php'; ?>

<?php require_once __DIR__ . '/../blocks/homepage/questions.php'; ?>

<?php require_once __DIR__ . '/../blocks/homepage/bottom-blocks.php'; ?>

<div class="homeCallback">
	<?php require_once __DIR__ . '/../blocks/callback-section.php'; // Callback ?>
</div>

<?php require_once __DIR__ . '/../blocks/buttons/sticky-button.php'; // Reservation button ?>

<?php get_footer(); ?>
