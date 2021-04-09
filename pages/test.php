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
        include_once __DIR__ . '/../class/BookingFilter.php'; // Filter products
        
        $_bf = new BESEDKA\BookingFilter();
        
        
        echo 'Все беседки: <br>';
        $all_ids = $_bf->GetAll();
        var_dump($all_ids);
        echo '<br><br>';
        
        
		echo 'Беседки на берегу: <br>';
        $shore_ids = $_bf->GetFiltered('shore', false);
		var_dump($shore_ids);
		echo '<br><br>';


		echo 'Беседки на территории: <br>';
		$shore_ids = $_bf->GetFiltered('territory', false);
		var_dump($shore_ids);
		echo '<br><br>';
		
		
		echo 'Беседки на более 20 человек: <br>';
		$capacity_ids = $_bf->GetFiltered(false, 20);
		var_dump($capacity_ids);
		echo '<br><br>';

		
		echo 'Беседки на более 20 человек и на берегу: <br>';
		$capacity_ids = $_bf->GetFiltered('shore', 20);
		var_dump($capacity_ids);
		echo '<br><br>';
		
		
        ?>
    </div>
</div>

<?php get_footer(); ?>