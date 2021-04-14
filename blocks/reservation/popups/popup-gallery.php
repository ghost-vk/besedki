<div class="popupGallery">
    <div class="popupGallery__body">
        <div class="popupGallery__header">
            <!--     POPUP TITLE     -->
            <div class="popupGallery__title">
                <span>Беседка #1</span>
            </div>
            <!--     CLOSE BUTTON     -->
            <div class="popupGallery__close">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <!--    GALLERY    -->
        <div class="popupGallery__gallery">
                <!--     MAIN SLIDER     -->
                <div class="popupGallery__slider" id="popupSlider">
                    <div class="popupGallery__bg"
                         style="background: center / cover no-repeat url('<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg')">
                    </div>
                    <div class="popupGallery__bg"
                         style="background: center / cover no-repeat url('<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-2.jpg')">
                    </div>
                    <div class="popupGallery__bg"
                         style="background: center / cover no-repeat url('<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg')">
                    </div>
                </div>
                <!--      NAVIGATION ARROWS     -->
                <div class="popupGallery__arrows" id="popupSliderArrows"></div>
            
                <!--    BADGES    -->
                <span class="popupGallery__location badge"><i class="fas fa-map-marker-alt"></i> На берегу</span>
                <span class="popupGallery__capacity badge"><i class="fas fa-users"></i> До 20 человек</span>
                <span class="popupGallery__diapason badge"><i class="fas fa-tags"></i></i> 1 000 Р - 7 000 Р</span>
            
            <?php if ( ! is_mobile() ) : // Navigation slider only on desktop ?>
                <!--     NAVIGATION SLIDER DESKTOP     -->
                <div class="popupGallery__nav" id="popupSliderNav">
                    <div class="popupGallery__bg"
                         style="background: center / cover no-repeat url('<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg')">
                    </div>
                    <div class="popupGallery__bg"
                         style="background: center / cover no-repeat url('<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-2.jpg')">
                    </div>
                    <div class="popupGallery__bg"
                         style="background: center / cover no-repeat url('<?php echo get_stylesheet_directory_uri(); ?>/img/picture/gallery-image.jpg')">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!--     DETAILS     -->
        <div class="popupGallery__details">
            <div class="popupGallery__row">
                <!--     DURATION SELECTOR     -->
                <div class="popupGallery__duration">
                    <div class="popupGallery__label">
                        <span>Длительность</span>
                    </div>
                    <div class="filterSelect">
                        <div class="filterSelect__select select" id="selectDuration">
                            <input type="hidden">
                            <div class="select-inner"></div>
                        </div>
                    </div>
                </div>
                <!--     DYNAMIC PRICE     -->
                <div class="popupGallery__price">
                    <div class="popupGallery__label">
                        <span>Стоимость</span>
                    </div>
                    <p>3 000 Р</p>
                </div>
                <!--   DATETIME PICKER   -->
                <div class="popupGallery__datetime">
                    <div class="popupGallery__label">
                        <span>Дата и время</span>
                    </div>
                    <div class="popupGallery__picker">
                        <input id="datetimepicker" type="text" />
                    </div>
                </div>
            </div>
        </div>
        <!--  SUBMIT  -->
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