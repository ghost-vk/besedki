import MapFilter from "./MapFilter";
import store from "../../store";

class MapFilterLocation extends MapFilter {
    _updateState() {
        store.setMapFilter('location', this.selector.getValue());
    }
}

export default MapFilterLocation;