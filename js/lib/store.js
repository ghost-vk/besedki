store = {
    _state: {
        reservation: {}
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