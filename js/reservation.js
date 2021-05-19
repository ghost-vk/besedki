import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import store from "./lib/store";
import MapHandler from "./lib/map/MapHandler";
import MapFilterLocation from "./lib/map/MapFilter/MapFilterLocation";
import MapFilterCapacity from "./lib/map/MapFilter/MapFilterCapacity";
import {createDatetimepicker} from "./lib/vendor/datetimepicker";
import {createCustomSelect} from "./lib/vendor/custom-select";

import slickCss from './../node_modules/slick-carousel/slick/slick.css';
import datetimepickerCss from './../style/vendor/datetimepicker.css';
import selectCss from './../style/vendor/select.css';
import bookingCss from './../style/reservation-page/booking.css';
import {startAnalyticsAfterLoading} from "./lib/analytics/analytics-handler";

startAnalyticsAfterLoading();
header();

$(document).ready(function () {
    pageLoader();
    notifyCookies();
    callback($("#callbackForm"));
});

$(document).ready(function () {
    createDatetimepicker();
    createCustomSelect();

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
        let productID = $(this).attr("data-id");
        store.setProductID(productID);
    });
});