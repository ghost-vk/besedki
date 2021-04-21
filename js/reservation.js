(function ($) {
    $(document).ready(function () {
        let state = store.getState();


        /**
         * Initializes map
         */
        const mapHandler = new MapHandler(state.reservation.map.settings.id, $("#updateMapPointsBtn"));
        mapHandler.init();


        /**
         * Location filter
         */
        const locationSelector = new MapFilterLocation($('#selectLocation'),
            state.reservation.filter.location);
        locationSelector.init();


        /**
         * Capacity filter
         */
        const capacitySelector = new MapFilterCapacity($("#selectCapacity"),
            state.reservation.filter.capacity);
        capacitySelector.init();


        /**
         * Toggle filters
         */
        (function () {
            let showFiltersBtn,
                filters,
                searchBtn;

            searchBtn = $("#updateMapPointsBtn");
            showFiltersBtn = $("#showFilters");
            filters = $("#filters");
            showFiltersBtn.click(function () {
                filters.toggle();
            });

            searchBtn.click(function () {
                if (showFiltersBtn.length) {
                    showFiltersBtn.click();
                }
            })
        })();


        /**
         * Changes product ID on map point click
         */
        state.reservation.map.settings.element.on("click", "span.mapPopup__open", function () {
            let productID;
            productID = $(this).attr("data-id");
            store.setProductID(productID);
        });
    });
})(jQuery);