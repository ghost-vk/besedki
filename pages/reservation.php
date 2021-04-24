<?php get_header(); ?>

<?php
//require_once __DIR__ . '/../class/DurationAvailability/DurationHandler.php';
//$duration_availability_handler = new \BESEDKA\DurationAvailabilityHandler('1', '2021-05-12 10:00:00');
//$duration_availability_handler->IsAvailable();
//$data = get_field('duration_availability_group', 'options');
//var_dump($data['one_hour']);
?>

<?php require_once __DIR__ . '/../blocks/reservation/map/map.php'; // Map with filters ?>

<?php require_once __DIR__ . '/../blocks/callback-section.php'; // Callback ?>

<?php require_once __DIR__ . '/../blocks/reservation/popups/popup-gallery.php'; // Popup gallery with detail data ?>

<?php get_footer(); ?>