<div class="popupGallery">
    <div class="popupGallery__body">
        <div class="popupGallery__header">
            <div class="popupGallery__title">
                <span>Беседка #1</span>
            </div>
            <div class="popupGallery__close">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="popupGallery__gallery">
<!--            <div class="popupGallery__slider-wrapper">-->
                <div class="popupGallery__slider" id="popupSlider">
                    <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt=""></div>
                    <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt=""></div>
                    <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt=""></div>
                    <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt=""></div>
                </div>
                <div class="popupGallery__arrows" id="popupSliderArrows"></div>
                <span class="popupGallery__location badge"><i class="fas fa-map-marker-alt"></i> На берегу</span>
                <span class="popupGallery__capacity badge"><i class="fas fa-users"></i> До 20 человек</span>
<!--            </div>-->
            
            <div class="popupGallery__nav" id="popupSliderNav">
                <div>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt="">
                </div>
                <div>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt="">
                </div>
                <div>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt="">
                </div>
                <div>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="popupGallery__details">
            <div class="popupGallery__row">
                <div class="popupGallery__duration">
                    <div class="popupGallery__label">
                        <span>Продолжительность аренды</span>
                    </div>
                    <div class="filterSelect">
                        <div class="filterSelect__select select" id="selectDuration">
                            <input type="hidden">
                            <div class="select-inner"></div>
                        </div>
                    </div>
                </div>
                <div class="popupGallery__price">
                    <div class="popupGallery__label">
                        <span>Стоимость</span>
                    </div>
                    <p>3 000 Р</p>
                </div>
            </div>
        </div>
        <div class="popupGallery__button">
            <!--      ERROR      -->
<!--            <p class="popupGallery__error">-->
<!--                <i class="fas fa-exclamation-circle"></i>-->
<!--                Необходимо выбрать продолжительность аренды-->
<!--            </p>-->
            <button class="bigBtn">Выбрать дату и время</button>
        </div>
    </div>
</div>