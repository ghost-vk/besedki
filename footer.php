<?php global $home_page_id; ?>
        <footer>
            <?php if ( !is_mobile() ) : ?>
                <?php $footer_gallery = get_field( 'footer_gallery', $home_page_id ); ?>
                <?php if ( $footer_gallery ) : ?>
                <div class="prefooter">
                    <div class="prefooter__row">
                        <?php foreach ( $footer_gallery as $image ) : ?>
                            <div class="prefooter__item">
								<?php
								if ( ! empty($image) ) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								<?php endif; ?>
                            </div>
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
                                <?php if ( $i === 1 ) : // First show sitemap (hard displays) ?>
                                    <?php require_once __DIR__ . '/blocks/footer/footer-sitemap.php'; ?>
                                <?php else : ?>
                                    <?php require __DIR__ . '/blocks/footer/footer-dynamic-items.php'; ?>
                                <?php endif; ?>
                            </div>
                        
							<?php if ( $i % 2 === 0 ) : // Ends row ?>
                                </div>
							<?php endif; ?>
							<?php $i += 1; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <div class="footer__copyright">
                        <p class="mainText-2 no-select">&copy; 2021 - 2021, ООО "ШЕРИНГГРУПП", Все права защищены</p>
                    </div>
                </div>
            </div>
        </footer>
        <!--   NOTIFICATION   -->
        <div class="notification" id="notification"></div>
	
	    <?php wp_footer(); ?>

        </div>
	</body>
</html>