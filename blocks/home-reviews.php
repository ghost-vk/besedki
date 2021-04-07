<div class="homeReviews">
	<div class="container">
		<div class="homeReviews__title titleAnimated" data-animation="left">
			<h3 class="title-1 no-select"><?php the_field('reviews_title'); ?></h3>
		</div>
		<div class="homeReviews__row">
            <?php $review_ids = get_field('reviews_posts'); ?>
            <?php foreach ( $review_ids as $id ) : ?>
                <div class="homeReviews__item">
                    <img class="homeReviews__image" src="<?= the_field('image', $id); ?>" />
                    <p class="homeReviews__name mainTextBig"><?= the_field('name', $id); ?></p>
                    <p class="homeReviews__content mainText-2"><?= the_field('text', $id); ?></p>
                    <p class="homeReviews__label"><?= the_field('badge', $id); ?></p>
                </div>
            <?php endforeach; ?>
		</div>
		<div class="homeReviews__btn">
			<a href="<?= home_url('/reviews'); ?>" class="bigBtn green hidden" id="lookAllReviews"><?php the_field('reviews_btn_text'); ?></a>
		</div>
	</div>
</div>