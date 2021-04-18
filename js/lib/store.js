const store = {
    _state: {
        reservation: {
            map: {
                settings: {
                    icon: {
                        iconUrl: utils.getLocalizeData(mapState, 'icon'),
                        iconSize: [26, 35],
                        iconAnchor:   [13, 35], // point of the icon which will correspond to marker's location
                        popupAnchor:  [0, -35] // point from which the popup should open relative to the iconAnchor
                    }
                },
                points: utils.getLocalizeData(mapState, 'defaultPoints')
            }
        }
    },

    /**
     * Return state
     * @return {}
     */
    getState () {
        return this._state;
    },

    /**
     * Set variation ID to state
     * @param id {String|Integer}
     */
    setVariationID(id) {
        this._state.reservation.variationID = id;
    }
}