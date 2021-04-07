<?php global $home_page_id; ?>
        <footer>
            <?php if ( !is_mobile() ) : ?>
                <?php $footer_gallery = get_field( 'footer_gallery', $home_page_id ); ?>
                <?php if ( $footer_gallery ) : ?>
                <div class="prefooter">
                    <div class="prefooter__row">
                        <?php foreach ( $footer_gallery as $image_src ) : ?>
                            <div class="prefooter__item"><img src="<?= $image_src; ?>" /></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="footer">
                <div class="c-container">
                    <?php if ( have_rows( 'footer_repeater', $home_page_id ) ) : $i = 1; ?>
                        <?php while ( have_rows( 'footer_repeater', $home_page_id ) ) : the_row(); ?>
                            <?php if ( $i % 2 !== 0 ) : // Opens row ?>
                                <div class="footer__row">
                            <?php endif; ?>
                                    <div class="footer__column">
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
                                                                <p class="mainText-1 no-select"><?= $element['text']; ?></p>
                                                            <?php elseif ( $element['type'] === 'is_link' ) : ?>
                                                                <?php
                                                                $link = $element['link'];
                                                                $target = ( $link['target'] ) ? $link['target'] : '_self';
                                                                ?>
                                                                <a class="mainText-1" href="<?= $link['url']; ?>" target="<?= $target; ?>"><?= $link['title']; ?></a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                            <?php if ( $i % 2 === 0 ) : // Ends row ?>
                                </div>
                            <?php endif; ?>
                            <?php $i += 1; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <div class="footer__copyright">
                        <p class="mainText-2 no-select">&copy; 2021 - 2021, ООО "Холдинг Строй Групп", Все права защищены</p>
                    </div>
                </div>
            </div>
        </footer>
	
	    <?php wp_footer(); ?>

        </div>
	</body>
</html>