<div class="homeQuestion" id="frequently-questions">
	<div class="container">
		<div class="homeQuestion__title titleAnimated" data-animation="left">
			<h3 class="title-1"><?php the_field('question_title'); ?></h3>
		</div>
		<div class="homeQuestion__subtitle">
			<p class="mainText-2"><?php the_field('question_subtitle'); ?></p>
		</div>
		<div class="homeQuestion__body">
			<?php if ( have_rows('question_repeater') ) : ?>
				<?php while ( have_rows('question_repeater') ) : the_row(); ?>
					<div class="homeQuestion__item hidden">
						<div class="homeQuestion__btn">
							<img src="<?= get_stylesheet_directory_uri(); ?>/img/icon/plus.svg" alt="Раскрыть отзыв">
						</div>
						<div class="homeQuestion__name mainTextBig">
							<p><?php the_sub_field('question'); ?></p>
						</div>
						<div class="homeQuestion__gap"></div>
						<div class="homeQuestion__answer">
							<p class="mainText-2"><?php the_sub_field('answer'); ?></p>
						</div>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>