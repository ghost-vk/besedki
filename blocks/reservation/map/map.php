<div class="reservationWindow">
	<div class="reservationWindow__container container">
        <!-- SHOW FILTER BUTTON -->
        <div class="reservationWindow__filterOpener">
            <div class="showPoint">
                <a href="#" id="showFilters">
                    <i class="fas fa-filter"></i>
                    <span>Подобрать вариант</span>
                </a>
            </div>
        </div>
		<div class="reservationWindow__row" id="filters">
			<!-- SELECT LOCATION -->
            <div class="reservationWindow__filter">
                <div class="filterSelect">
                    <div class="filterSelect__name">
                        <span>Расположение</span>
                    </div>
                    <div class="filterSelect__select select" id="selectLocation">
                        <input type="hidden">
                        <div class="select-inner"></div>
                    </div>
                </div>
            </div>
			<!-- SELECT CAPACITY -->
            <div class="reservationWindow__filter">
                <div class="filterSelect">
                    <div class="filterSelect__name">
                        <span>Количество человек</span>
                    </div>
                    <div class="filterSelect__select select" id="selectCapacity">
                        <input type="hidden">
                        <div class="select-inner"></div>
                    </div>
                </div>
            </div>
			<!-- SHOW MAP POINT BUTTON -->
            <div class="reservationWindow__search">
                <div class="showPoint">
                    <a href="#">
                        <i class="fas fa-search"></i>
                        <span>Показать на карте</span>
                    </a>
                </div>
            </div>
		</div>
        <!--    MAP    -->
        <div class="reservationMap">
        
        </div>
	</div>
</div>