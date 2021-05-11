<div class="homeFeatures">
	<div class="container">
		<div class="homeFeatures__title titleAnimated" data-animation="left">
			<h3 class="title-1"><?php the_field('features_title'); ?></h3>
		</div>
		<div class="homeFeatures__body">
			<?php for ($i = 1; $i < 5; $i += 1) : ?>
				<div class="homeFeatures__item hidden">
					<?php $data = get_field("features_$i"); ?>
					<div class="homeFeatures__image">
						<?php
						$image = $data['image'];
						if ( ! empty($image) ) : ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
						<?php endif; ?>
					</div>
					<div class="homeFeatures__text">
						<p class="mainText-1"><?= $data['text']; ?></p>
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</div>