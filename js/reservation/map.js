/**
 * @namespace BESEDKA
 */
var BESEDKA = BESEDKA || {};

BESEDKA.reservation = {};

BESEDKA.reservation.state = {
    map: {
        settings: {
            mapContainer: jQuery("#map"),
            init: { center : [45.021303, 38.952325], height: '100%', zoom: 16 },
            elements: {
                name: 'Беседка #1',
                points: [ 45.021303, 38.952325 ],
                description: 'Беседка у берега',
            },
            iconSettings: {
                iconUrl: mapData.icon, // mapData creates in enqueue.php
                iconSize: [26, 35],
                iconAnchor:   [13, 35], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
            }
        },
        methods: {
            getPopupTemplate: (data) => {
                return `
                    <div class="mapPopup">
                        <div class="mapPopup__row">
                            <div class="mapPopup__column">
                                <span class="mapPopup__title">
                                    ${data.title}
                                </span>
                                <img class="mapPopup__image" src="${data.image}" alt="" />
                            </div>
                            <div class="mapPopup__column">
                                <span class="mapPopup__capacity">
                                    <i class="fas fa-users"></i> ${data.capacity}
                                </span>
                                <span class="mapPopup__price">
                                    <i class="fas fa-ruble-sign"></i> ${data.minPrice} - ${data.maxPrice}
                                </span>
                                <a href="#" class="mapPopup__open" data-id="${data.id}">Подробнее</a>
                                <a href="#" class="mapPopup__open" data-id="${data.id}">Забронировать</a>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
    },
    filters: {
        location: {}
    }
};

// MAP
let mapSettings, mapMethods;
mapSettings = BESEDKA.reservation.state.map.settings;
mapMethods = BESEDKA.reservation.state.map.methods;

// BESEDKA.map = L.map('map', {
//     center: mapSettings.init.center,
//     zoom:   mapSettings.init.zoom,
//     layers: [new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')],
//     attributionControl: false,
//     minZoom: 15,
//     maxZoom: 18
// });

// mapSettings.icon = L.icon(mapSettings.iconSettings);

// let createPoints = () => {
//     let data = mapData.defaultPoints;
//
//     for (var i = 0, max = data.length; i < max; i += 1) {
//         let marker;
//         marker = L.marker(
//             [data[i].coordinates.latitude, data[i].coordinates.longitude],
//             {icon: mapSettings.icon}).addTo(BESEDKA.map);
//     }
// }
// createPoints();





var popupData = {
    title: 'Беседка #1',
    image: mapData.testImage,
    capacity: 10,
    minPrice: 3000,
    maxPrice: 7000,
    id: 123
};

// marker.bindPopup(mapMethods.getPopupTemplate(popupData)).openPopup();

(function ($) {
    $(document).ready(function () {

        // Selects settings
        let selectLocation,
            selectCapacity;

        const locationOptions = [
            { name: 'На берегу', value: 'shore' },
            { name: 'В парке', value: 'territory' }
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



        // Selects logic
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