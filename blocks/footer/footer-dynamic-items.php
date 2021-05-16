<div class="footer__title">
	<h4 class="title-1 no-select"><?php the_sub_field('title'); ?></h4>
</div>
<div class="foooter__items">
	<?php if ( have_rows('elements_repeater', $home_page_id) ) : ?>
		<?php while ( have_rows('elements_repeater', $home_page_id) ) : the_row(); ?>
			<div class="footer__item">
				<?php $element = get_sub_field('element'); ?>
				<?php if ( $element ) : ?>
					<?php if ( $element['type'] === 'is_text' ) : ?>
						<p class="mainText-1 no-select"><?php echo wp_specialchars_decode($element['text']); ?></p>
					<?php elseif ( $element['type'] === 'is_link' ) : ?>
						<?php
						$link = $element['link'];
						$target = ( $link['target'] ) ? $link['target'] : '_self';
						?>
						<a class="mainText-1" href="<?= $link['url']; ?>"
						   target="<?= $target; ?>"><?php echo wp_specialchars_decode($link['title']); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
</div>