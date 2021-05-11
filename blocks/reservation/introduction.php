<?php $page_id = get_hide_current_page_id(); ?>

<div class="introductionReservation">
    <div class="introductionReservation__title">
        <h1 class="title-1"><?php echo the_field('booking_page_title', $page_id); ?></h1>
        <p class="mainText-1"><?php echo the_field('booking_page_subtitle', $page_id); ?></p>
    </div>
    <div class="introductionReservation__content">
        <div class="postBlock">
            <div class="postBlock__wrapper">
                <div class="container">
					<?php echo the_field('booking_page_brief', $page_id); ?>
                </div>
            </div>
        </div>
    </div>
</div>