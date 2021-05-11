<div class="homeAtmosphere">
	<div class="container">
		<div class="homeAtmosphere__title titleAnimated" data-animation="right">
			<h3 class="title-1"><?php the_field('atmosphere_title'); ?></h3>
		</div>
		<div class="homeAtmosphere__subtitle">
			<p class="mainText-2"><?php the_field('atmosphere_subtitle'); ?></p>
		</div>
		<div class="homeAtmosphere__body">
			<?php if ( have_rows('atmosphere_blocks') ) : $i = 1; ?>
				<?php while ( have_rows('atmosphere_blocks') ) : the_row(); ?>
					<div class="homeAtmosphere__row">
						<?php if ( $i % 2 !== 0 ) : ?>
							<div class="homeAtmosphere__img hidden">
								<?php
								$image = get_sub_field('image');
								if ( ! empty($image) ) : ?>
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								<?php endif; ?>
							</div>
							<div class="homeAtmosphere__content">
								<div class="homeAtmosphere__name">
									<p class="mainTextBig"><?php the_sub_field('title'); ?></p>
								</div>
								<div class="homeAtmosphere__text">
									<p class="mainText-1"><?php the_sub_field('text'); ?></p>
								</div>
							</div>
						<?php else : ?>
							<div class="homeAtmosphere__content">
								<div class="homeAtmosphere__name">
									<p class="mainTextBig"><?php the_sub_field('title'); ?></p>
								</div>
								<div class="homeAtmosphere__text">
									<p class="mainText-1"><?php the_sub_field('text'); ?></p>
								</div>
							</div>
							<div class="homeAtmosphere__img hidden">
								<?php
								$image = get_sub_field('image');
								if ( ! empty($image) ) : ?>
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
					<?php $i += 1; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>