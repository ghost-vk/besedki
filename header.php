<?php
do_action('store_user_key_in_cookie'); // Stores user key in COOKIE, used for identification in booking process
$rollback_page_id = get_hide_current_page_id();
$page_id = ( $rollback_page_id ) ? $rollback_page_id : get_the_ID();
?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php the_field('og_description', $rollback_page_id); ?>">
    <?php do_action('render_meta_robots', $page_id); ?>
    <?php do_action('render_og'); // Render Open Graph tags ?>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preload" as="style"
	href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap">
	<link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');"
	href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap">
	<noscript><div><img src="https://mc.yandex.ru/watch/78198895" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<script src="https://kit.fontawesome.com/519fd0f28a.js" crossorigin="anonymous" async></script>
	<?php wp_head(); ?>
</head>
	<body class="lightBg">
        <div id="main">
            <!--      HEADER      -->
            <header>
                <?php
                global $home_page_id;
                $home_page_id = 18;
                
                // Contacts data
                $address = get_field('contacts_address', $home_page_id);
				$target = $address['target'] ? $address['target'] : '_self';
                $phone = get_field('contacts_phone', $home_page_id);
                ?>
                <?php if ( ! is_mobile() ) : ?>
                    <div class="preheader">
                        <div class="preheader__iconbox">
                            <?php require_once __DIR__ . '/blocks/social-iconbox.php'; ?>
                        </div>
                        <div class="preheader__contacts">
                            <?php if ( $address ) : ?>
                                <a href="<?php echo $address['url']; ?>" target="<?php echo $target; ?>"><?php echo $address['title']; ?></a>
                            <?php endif; ?>
                            <?php if ( $phone ) : ?>
                                <a class="underline" href="<?php echo $phone['url']; ?>"><?php echo $phone['title']; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ( ! is_mobile() ) : ?>
                    <div class="header">
                        <div class="c-container">
                            <div class="header__icon">
                                <a href="<?php echo home_url(); ?>">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon/logo.svg" alt="Логотип">
                                </a>
                            </div>
                            <div class="header__reservation">
                                <?php if ( ! is_archive() ) : ?>
                                    <a class="whiteBtn1" href="<?php echo home_url('/reservation'); ?>">Забронировать</a>
                                <?php else : ?>
                                    <a class="whiteBtn1" href="<?php echo home_url(); ?>">На главную</a>
                                <?php endif; ?>
                            </div>
                            <div class="header__elements">
								<?php wp_nav_menu( [ 'theme_location' => 'header_menu' ] ); ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="headerMobile">
                        <div class="headerMobile__icon">
                            <a href="<?php echo home_url(); ?>">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon/logo_mobile.svg" alt="Логотип">
                            </a>
                        </div>
                        <div class="headerMobile__row">
                            <div class="headerMobile__phone">
                                <a href="<?php echo $phone['url']; ?>">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M33.9841 28.0947C33.9173 27.6819 33.6585 27.3291 33.2709 27.1195L27.5369 23.7411L27.4897 23.7147C27.2492 23.5944 26.9837 23.5327 26.7149 23.5347C26.2345 23.5347 25.7757 23.7167 25.4573 24.0359L23.7649 25.7291C23.6925 25.7979 23.4565 25.8975 23.3849 25.9011C23.3653 25.8995 21.4157 25.7591 17.8265 22.1695C14.2437 18.5875 14.0917 16.6319 14.0905 16.6319C14.0925 16.5319 14.1909 16.2967 14.2609 16.2239L15.7041 14.7811C16.2125 14.2715 16.3649 13.4267 16.0633 12.7723L12.8761 6.77511C12.6445 6.29831 12.1945 6.00391 11.6953 6.00391C11.3421 6.00391 11.0013 6.15031 10.7349 6.41631L6.80087 10.3415C6.42367 10.7167 6.09887 11.3727 6.02807 11.9007C5.99367 12.1531 5.29567 18.1779 13.5557 26.4391C20.5681 33.4507 26.0361 33.9955 27.5461 33.9955C27.73 33.9979 27.9138 33.9884 28.0965 33.9671C28.6229 33.8967 29.2781 33.5727 29.6529 33.1971L33.5837 29.2667C33.9045 28.9443 34.0509 28.5183 33.9841 28.0947Z" fill="#114410"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="headerMobile__burger" id="mobileMenuBtn">
                                <span></span>
                            </div>
                            <div class="headerMobile__address">
                                <a href="<?php echo $address['url']; ?>" target="<?php echo $target; ?>"><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;<?php echo $address['title']; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </header>
            <!--     PAGE LOADER       -->
            <div class="pageLoader">
                <div id="mainLoader" class="pageLoader__wrapper active z">
                    <div class="pageLoader__container">
                        <div class="lds-spinner">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ( is_mobile() ) : ?>
                <!--      MOBILE MENU      -->
                <div class="mobileMenu" id="mobileMenu">
                    <div class="mobileMenu__wrapper">
                        <div class="mobileMenu__reservation">
                            <a class="greenBtn1" href="<?= home_url('/reservation'); ?>">Забронировать</a>
                        </div>
                        <div class="mobileMenu__elements">
                            <?php
                            wp_nav_menu( [
                                'theme_location' => 'header_menu',
                            ] );
                            ?>
                        </div>
                        <div class="mobileMenu__iconbox">
                            <?php require_once __DIR__ . '/blocks/social-iconbox.php'; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>