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
        include_once __DIR__ . '/../class/Viewer.php'; // Filter products
        include_once __DIR__ . '/../class/ViewerPopup.php'; // Filter products
        
//        $_bpv = new BESEDKA\BookingProductViewer(11);
//        $popup_data = $_bpv->GetPopupData();
        
        $_vp = new \BESEDKA\ViewerPopup(11);
        var_dump($_vp->get());
        
        ?>
    </div>
</div>

<?php get_footer(); ?>