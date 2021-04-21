<div class="reservationWindow">
	<div class="reservationWindow__container container">
        <?php if ( is_mobile() ) : ?>
            <!-- SHOW FILTER BUTTON -->
            <div class="reservationWindow__filterOpener">
                <div class="showPoint">
                    <a href="#" id="showFilters">
                        <i class="fas fa-filter"></i>
                        <span>Подобрать вариант</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <!-- FILTER SECTION -->
		<?php require_once __DIR__ . '/filters.php'; ?>
        <!--    MAP    -->
        <div class="reservationMap">
            <div id="map"></div>
            <div class="loader" id="mapLoader"></div>
        </div>
	</div>
</div>