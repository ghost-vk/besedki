<div class="promo" id="promoSection">
	<div class="promo__img">
		<?php if ( is_mobile() ) : ?>
			<?php
			$image = get_field('promo_image_mobile');
			if ( ! empty($image) ) : ?>
				<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
			<?php endif; ?>
		<?php else : ?>
			<?php
			$image = get_field('promo_image');
			if ( ! empty($image) ) : ?>
				<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="promo__offer">
		<h1 class="title-1 no-select"><?php the_field('promo_title'); ?></h1>
	</div>
	<div class="promo__button">
		<a class="bigBtn bold hidden" id="lookAtAll" href="<?php echo home_url('/reservation'); ?>">
			<?php the_field('promo_btn_text'); ?>
		</a>
	</div>
</div>

<div class="priceLine">
	<div class="container">
		<div class="priceLine__row">
            <div class="priceLine__icon">
                <i class="fas fa-ruble-sign"></i>
            </div>
			<p class="priceLine__text">
				<?php the_field('promo_price_brief'); ?>
			</p>
		</div>
	</div>
</div>