class MapHandler {
    constructor(id) {
        this.state = store.getState().reservation.map;
        this.id = id;
        this.center = [45.021303, 38.952325];
        this.zoom = 16;
        this.minZoom = 15;
        this.maxZoom = 18;
    }

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

        for (var i = 0, max = this.state.points.length; i < max; i += 1) {
            let marker, latitude, longitude;
            latitude = this.state.points[i].coordinates.latitude;
            longitude = this.state.points[i].coordinates.longitude;
            marker = L.marker(
                [latitude, longitude],
                {icon: this.icon}).addTo(this.map);
        }
    }
}