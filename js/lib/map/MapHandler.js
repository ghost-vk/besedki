/**
 * Class used for works with map
 * Main handler for map
 * Uses Leaflet map: https://leafletjs.com/
 */
class MapHandler {
    /**
     * Constructor
     * @param id {String} - map container
     * @param updateBtn {jQuery} - button for updating map points
     */
    constructor(id, updateBtn) {
        this.state = store.getState().reservation.map;
        this.id = id;
        this.center = [45.021213, 38.951729];
        this.zoom = 17;
        this.minZoom = 16;
        this.maxZoom = 18;
        this.updater = updateBtn;
        this.filterValue = {};
        this.loader = new Loader(jQuery(`#${id}`).parent().find("#mapLoader"));
    }

    /**
     * Method initialize map
     * @method init
     * @public
     */
    init() {
        this.map = L.map(this.id, {
            center: this.center,
            zoom:   this.zoom,
            layers: [new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')],
            attributionControl: false,
            minZoom: this.minZoom,
            maxZoom: this.maxZoom
        });

        this.icon = L.icon(this.state.settings.icon);

        this._createPoints();

        this.updater.click(this._onUpdaterClick.bind(this));

        let state = store.getState();

        // Save current value
        for (let key in state.reservation.filter.value) {
            this.filterValue[key] = state.reservation.filter.value[key];
        }
    }


    /**
     * Method delete all layers from map (tileLayer, markers, popups)
     */
    _deleteLayers() {
        this.map.eachLayer((function (layer) {
            this.map.removeLayer(layer);
        }).bind(this));
    }


    /**
     * Method updates map point
     * @private
     */
    _updateLayers(points) {
        this._deleteLayers();

        store.setMapPoints(points);

        // To server
        this.map.addLayer(new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));
        this._createPoints();

        this.loader.hide();

        let state = store.getState();

        // Copy new value
        for (let key in state.reservation.filter.value) {
            this.filterValue[key] = state.reservation.filter.value[key];
        }
    }


    /**
     * Method fires when click on updater button
     * @param e {Event}
     * @private
     */
    _onUpdaterClick(e) {
        e.preventDefault();
        let isEqual, state = store.getState();

        isEqual = true;

        for (let key in this.filterValue) {
            if (this.filterValue[key] !== state.reservation.filter.value[key]) {
                isEqual = false;
            }
        }

        if (isEqual === true) { // State was not changed
            return;
        }

        this.loader.show();

        let serverClient = new ServerClient({
            nonce: state.general.nonce,
            url: state.general.ajaxUrl,
            action: "get_updates_points_data"
        }, {
            location: state.reservation.filter.value.location,
            capacity: state.reservation.filter.value.capacity
        });
        serverClient.get(this._request.bind(this));
    }


    /**
     * Method creates points with popup on map
     * @method _createPoints
     * @private
     */
    _createPoints() {
        for (var i = 0, max = this.state.points.length; i < max; i += 1) {
            let marker, latitude, longitude, mapPopup;

            latitude = this.state.points[i].coordinates.latitude;
            longitude = this.state.points[i].coordinates.longitude;
            marker = L.marker(
                [latitude, longitude],
                {icon: this.icon}).addTo(this.map);

            mapPopup = new MapPopup(this.state.points[i]);

            marker.bindPopup(mapPopup.get());
        }
    }

    /**
     * Method fires another one depends on response from server
     * @param response { status: true, points: {} }
     * @private
     */
    _request(response) {
        this._updateLayers(response.points);
        if (response.status === false) {
            this.loader.hide();
            this._showFailNotification();
        }
    }

    /**
     * Method shows notification
     * Used for bad server response
     * @private
     */
    _showFailNotification() {
        let state, notificationArgs, notification;

        state = store.getState();

        notificationArgs = {
            text: "Ничего не найдено.<br />Попробуйте сделать другой запрос.",
            icon: '<i class="fas fa-map-marked-alt"></i>'
        }

        notification = new Notification(state.general.notificationContainer, notificationArgs);
        notification.init(3000);
    }
}