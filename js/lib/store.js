/**
 * Object for state management
 */
const store = {

    /**
     * App state
     */
    _state: {
        general: {
            nonce: utils.getLocalizeData('mainSettings', 'nonce'),
            ajaxUrl: utils.getLocalizeData('mainSettings', 'url'),
            notificationContainer: jQuery("#notification"),
            privacyUrl: utils.getLocalizeData('mainSettings', 'privacyUrl'),
            reservationPageUrl: utils.getLocalizeData('mainSettings', 'reservationPageUrl'),
            callbackResponse: utils.getLocalizeData('callbackText', 'text'), // TODO зацепить в ответ на запрос обратного звонка
        },
        reservation: {
            popup: {
                settings: {
                    popupID: "popupGallery",
                    el: jQuery("#popupGallery"),
                    cartURL: utils.getLocalizeData("mapState", 'cartURL')
                }
            },
            map: {
                settings: {
                    icon: {
                        iconUrl: utils.getLocalizeData("mapState", 'icon'),
                        iconSize: [26, 35],
                        iconAnchor:   [13, 35], // point of the icon which will correspond to marker's location
                        popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
                    },
                    id: "map",
                    element: jQuery("#map")
                },
                points: utils.getLocalizeData("mapState", 'defaultPoints')
            },
            filter: {
                location: [
                    { name: 'На берегу', value: 'shore' },
                    { name: 'В парке', value: 'territory' },
                    { name: 'Без разницы', value: 'no-matter' }
                ],
                capacity: [
                    { name: 'до 5', value: '5' },
                    { name: '5 - 30', value: '30' },
                    { name: '30 - 50', value: '50' },
                    { name: '50 - 150', value: '150' },
                    { name: 'Без разницы', value: 'no-matter' }
                ],
                value: {
                    location: 'no-matter',
                    capacity: 'no-matter'
                }
            }
        }
    },


    /**
     * Method returns state
     * @return {}
     */
    getState () {
        return this._state;
    },


    /**
     * Method set variation ID in state
     * @param id {String|Integer}
     */
    setVariationID(id) {
        this._state.reservation.variationID = id;
    },


    /**
     * Method sets product ID in state
     * @param id {'11'}
     */
    setProductID(id) {
        this._state.reservation.productID = id;
        this._openReservationPopup();
    },


    /**
     * Set booking duration
     * @param duration { '1' | '2' | '3' | 'day' | null }
     */
    setBookingDuration(duration) {
        this._state.reservation.bookingDuration = duration;
    },


    /**
     * Set date choice flag
     * @param value { Boolean }
     */
    setDateSelectedFlag(value) {
        this._state.reservation.isDateSelected = value;
    },


    /**
     * Set time choice flag
     * @param value { Boolean }
     */
    setTimeSelectedFlag(value) {
        this._state.reservation.isTimeSelected = value;
    },


    /**
     * Set time need for booking
     * @param value { '2021-05-12 13:00:00' | null }
     */
    setYmdHis(value) {
        this._state.reservation.bookingNeedTime = value;
    },


    /**
     * Method opens booking modal window
     * @private
     */
    _openReservationPopup() {
        let popup = new Popup(this._state.reservation.popup.settings.el, this._state.reservation.productID);
        popup.init();
    },


    /**
     * Set map filter value
     * @param type { 'location' | 'capacity' }
     * @param value { String }
     */
    setMapFilter(type, value) {
        if ( type === 'location' || type === 'capacity' ) {
            this._state.reservation.filter.value[type] = value;
        }
    },


    /**
     * Set new map points
     * @param points { [ {}, {}, {} ] }
     */
    setMapPoints(points) {
        this._state.reservation.map.points = points;
    }
}