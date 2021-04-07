<?php get_header(); ?>

<?php if ( is_mobile() ) : ?>
    <div class="homeTopReservation">
        <div class="homeTopReservation__row">
            <a href="#" class="whiteBtn1">Забронировать</a>
        </div>
    </div>
<?php endif; ?>

<div class="promo" id="promoSection">
    <div class="promo__img">
        <?php if ( is_mobile() ) : ?>
            <img src="<?php the_field('promo_image_mobile'); ?>" alt="Беседка на 150 человек">
        <?php else : ?>
            <img src="<?php the_field('promo_image'); ?>" alt="Беседка на 150 человек">
        <?php endif; ?>
    </div>
    <div class="promo__offer">
        <h1 class="title-1 no-select"><?php the_field('promo_title'); ?></h1>
    </div>
    <div class="promo__button">
        <a class="bigBtn bold" id="lookAtAll" href="<?= home_url('/reservation'); ?>"><?php the_field('promo_btn_text'); ?></a>
    </div>
</div>

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
                        <img src="<?= $data['image']; ?>">
                    </div>
                    <div class="homeFeatures__text">
                        <p class="mainText-1"><?= $data['text']; ?></p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../blocks/home-carousel.php'; // Carousel section ?>

<?php require_once __DIR__ . '/../blocks/home-reviews.php'; // Highlight reviews ?>

<div class="homeNumbers">
    <div class="homeNumbers__title titleAnimated" data-animation="right">
        <h3 class="title-1"><?php the_field('numbers_title'); ?></h3>
    </div>
    <?php $background_image = get_field('numbers_bg'); ?>
    <style>
        .homeNumbers__row {
            background: center / cover url("<?= $background_image ?>");
            background: linear-gradient(180deg, #eaf0eb 14.92%, rgba(234, 240, 235, 0) 39.4%), center / cover url("<?= $background_image ?>");
        }
    </style>
    <div class="homeNumbers__row">
        <?php for ($i = 1; $i < 5; $i += 1) : ?>
            <?php $data = get_field("numbers_$i"); ?>
            <div class="homeNumbers__item">
                <p class="homeNumbers__number no-select"><?= $data['num']; ?></p>
                <p class="homeNumbers__text no-select mainText-2"><?= $data['text']; ?></p>
            </div>
        <?php endfor; ?>
    </div>
</div>

<div class="homeQuestion">
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
                                <img src="<?php the_sub_field('image'); ?>" />
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
                                <img src="<?php the_sub_field('image'); ?>" />
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php $i += 1; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="homeCallback">
	<?php require_once __DIR__ . '/../blocks/callback-section.php'; // Callback ?>
</div>

<?php require_once __DIR__ . '/../blocks/sticky-button.php'; // Reservation button ?>

<?php get_footer(); ?>
