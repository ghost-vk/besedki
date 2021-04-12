/**
 * @namespace BESEDKA
 */
var BESEDKA = BESEDKA || {}

BESEDKA.reservation = {
    state: {
        filters: {
            location
        }
    }
}

(function ($) {
    $(document).ready(function () {

        let selectLocation,
            selectCapacity;

        const locationOptions = [
            { name:'На берегу', value:'shore' },
            { name:'В парке', value:'territory' }
        ];

        const capacityOptions = [
            { name: '2 - 5', value: '5' },
            { name: '5 - 30', value: '30' },
            { name: '30 - 150', value: '150' }
        ];

        selectLocation = $('#selectLocation');
        selectLocation.select({
            data: locationOptions
        });

        selectCapacity = $('#selectCapacity');
        selectCapacity.select({
            data: capacityOptions
        });


        (function () {
            let showFiltersBtn,
                filters;

            showFiltersBtn = $("#showFilters");
            filters = $("#filters");
            showFiltersBtn.click(function () {
                filters.toggle();
            });
        })();

    });
})(jQuery);