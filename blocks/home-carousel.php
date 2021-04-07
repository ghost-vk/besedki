<div class="homeCarousel">
    <div class="container">
        <div class="homeCarousel__title titleAnimated" data-animation="right">
            <h3 class="title-1"><?php the_field('slider_title'); ?></h3>
        </div>
        <div class="homeCarousel__subtitle">
            <p class="mainText-2"><?php the_field('slider_subtitle'); ?></p>
        </div>
        <div class="homeCarousel__row" id="slickContainer">
            <?php if ( have_rows('slider_repeater') ) : $i = 0; ?>
                <?php while ( have_rows('slider_repeater') ) : the_row(); ?>
                    <?php $lazy_loading = ( $i > 0 ) ? 'loading="lazy"' : ''; ?>
                    <div class="homeCarousel__item"><img src="<?php the_sub_field('image');?>" <?= $lazy_loading; ?> /></div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <div class="homeCarousel__dots" id="slickDots"></div>
    </div>
</div>