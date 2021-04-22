<div class="popupGallery" id="popupGallery">
    <div class="popupGallery__body">
        <!--     HEADER      -->
        <div class="popupGallery__header">
            <!--     POPUP TITLE      -->
            <div class="popupGallery__title">
                <span id="popupTitle"></span>
            </div>
            <!--     CLOSE BUTTON     -->
            <div class="popupGallery__close" id="closeBtn">
                <i class="fas fa-times"></i>
            </div>
        </div>
        
        <!--     GALLERY     -->
        <div class="popupGallery__gallery">
            
            <!--     MAIN SLIDER     -->
            <div class="popupGallery__slider" id="popupSlider"></div>
            
            <!--      NAVIGATION ARROWS     -->
            <div class="popupGallery__arrows" id="popupSliderArrows"></div>
        
            <!--    BADGES    -->
            <div class="popupGallery__location badge">
                <span>
                    <i class="fas fa-map-marker-alt"></i> <span id="badgeLocation"></span>
                </span>
            </div>
            <div class="popupGallery__capacity badge">
                <span >
                    <i class="fas fa-users"></i> До <span id="badgeCapacity"></span> чел.
                </span>
            </div>
            <div class="popupGallery__diapason badge">
                <span>
                    <i class="fas fa-tags"></i>
                    <span id="badgeMinPrice"></span> &#8381; -
                    <span id="badgeMaxPrice"></span> &#8381;
                </span>
            </div>
            
            <?php if ( ! is_mobile() ) : // Navigation slider only on desktop ?>
                <!--     NAVIGATION SLIDER DESKTOP     -->
                <div class="popupGallery__nav" id="popupSliderNav"></div>
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
                    <p id="popupPriceBox">3 000 Р</p>
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
        
        <!--     SUBMIT      -->
        <div class="popupGallery__button">
            <!--      ERROR      -->
            <div id="popupErrorBlock"></div>
            <button class="bigBtn" id="popupBookBtn">Забронировать</button>
        </div>
        
        <!--     LOADER      -->
        <div class="popupGallery__loader" id="popupLoader"></div>
    </div>
</div>