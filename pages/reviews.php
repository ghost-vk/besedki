<?php get_header(); ?>

<?php if ( is_mobile() ) : ?>
	<div class="homeTopReservation">
		<div class="homeTopReservation__row">
			<a href="#" class="whiteBtn1">Забронировать</a>
		</div>
	</div>
<?php endif; ?>

<div class="reviewsAll">
    <div class="container">
        <div class="reviewsAll__title">
            <h1 class="title-1 no-select">Отзывы от наших гостей</h1>
        </div>
        <div class="reviewsAll__items">
            
            <?php
            $args = array(
                'post_type' => 'reviews',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
            );
            $the_query = new WP_Query($args);
            ?>
            
            <?php if ( is_mobile() ) : ?>
            
                <div class="reviewsAll__column mobile">
                    <?php if ( $the_query->have_posts() ) : ?>
                        <?php while ( $the_query->have_posts() ) : ?>
                            <?php
							$the_query->the_post();
                            $post_id = get_the_ID();
                            ?>
                            <div class="reviewsAll__item">
                                <div class="reviewsAll__image">
                                    <img src="<?php the_field('image'); ?>" />
                                </div>
                                <div class="reviewsAll__content">
                                    <p class="mainText-2"><?php the_field('text'); ?></p>
                                </div>
                                <div class="reviewsAll__name">
                                    <p><?php the_field('name'); ?></p>
                                    <?php
                                    $badge = get_field('badge');
                                    if ( $badge ) {
                                        echo '<span>' . $badge . '</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            
            <?php else : ?>
	
                <!--        FIRST COLUMN        -->
				<?php if ( $the_query->have_posts() ) : $i = 1; ?>
                    <div class="reviewsAll__column">
                        <?php while ( $the_query->have_posts() ) : ?>
                            <?php
							$the_query->the_post();
                            if ( $i % 2 === 0 ) {
								$i += 1;
                                continue;
                            }
                            ?>
                            <div class="reviewsAll__item">
                                <div class="reviewsAll__image">
                                    <img src="<?php the_field('image'); ?>" />
                                </div>
                                <div class="reviewsAll__content">
                                    <p class="mainText-2"><?php the_field('text'); ?></p>
                                </div>
                                <div class="reviewsAll__name">
                                    <p><?php the_field('name'); ?></p>
                                    <?php
                                    $badge = get_field('badge');
                                    if ( $badge ) {
                                        echo '<span>' . $badge . '</span>';
                                    }

									$i += 1;
                                    ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
					    <?php wp_reset_postdata(); ?>
                    </div>
				<?php endif; ?>

                <!--        SECOND COLUMN       -->
				<?php if ( $the_query->have_posts() ) : $i = 1; ?>
                    <div class="reviewsAll__column">
						<?php while ( $the_query->have_posts() ) : ?>
							<?php
							$the_query->the_post();
							if ( $i % 2 === 1 ) {
							    $i += 1;
								continue;
							}
							?>
                            <div class="reviewsAll__item">
                                <div class="reviewsAll__image">
                                    <img src="<?php the_field('image'); ?>" />
                                </div>
                                <div class="reviewsAll__content">
                                    <p class="mainText-2"><?php the_field('text'); ?></p>
                                </div>
                                <div class="reviewsAll__name">
                                    <p><?php the_field('name'); ?></p>
									<?php
									$badge = get_field('badge');
									if ( $badge ) {
										echo '<span>' . $badge . '</span>';
									}

									$i += 1;
									?>
                                </div>
                            </div>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
                    </div>
				<?php endif; ?>
            
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="reviewsCallback">
	<?php require_once __DIR__ . '/../blocks/callback-section.php'; // Callback ?>
</div>

<?php require_once __DIR__ . '/../blocks/sticky-button.php'; // Reservation button ?>

<?php get_footer(); ?>

