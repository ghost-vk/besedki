<?php
/*
Template Name: Тестовая страница
Template Post Type: page
*/
?>

<?php get_header(); ?>

<div class="tester">
    <div class="">
        <?php
        $start = ( !empty($_POST['start']) ) ? $_POST['start'] : '';
        if ( !empty($start) ) {
            var_dump($start);
        } ?>
    </div>
    <form>
        <input type="text" id="datetimepicker" name="start"/>
        <select id="" name="duration">
            <option value="day">День</option>
            <option value="1">1 час</option>
            <option value="2">2 часа</option>
            <option value="3">3 часа</option>
        </select>
        <button id="rent-submit">Забронировать</button>
        <button id="change-settings">Добавить доступное время</button>
        <button id="loader-toggler">Включить/выключить лоадер</button>
    </form>
    <div>
        <?php
        require_once __DIR__ . '/functions/bookingProduct.class.php';
        $bookingProduct = new BESEDKA\bookingProduct(11);
        $data = array (
                'start_datetime' => '2021-03-23 14:00:00',
                'duration' => '2'
        );

        if ( $bookingProduct->validate() === true ) {
//			$bookingProduct->remove_completed();
//			$bookingProduct->insert_row($data);
			
            $available_times = $bookingProduct->get_available_time('2021-03-27');
//            var_dump($available_times);
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>