<?php
/*
Template Name: Тестовая страница
Template Post Type: page
*/
?>

<?php get_header(); ?>

<div class="tester">
    <div style="min-height: 700px; padding: 30px; font-family: 'Helvetica Neue'">
        <?php
        include_once __DIR__ . '/../class/BookingProductViewer.php'; // Filter products
        
        $_bpv = new BESEDKA\BookingProductViewer(11);
        $popup_data = $_bpv->GetPopupData();
        
        ?>
    </div>
</div>

<?php get_footer(); ?>