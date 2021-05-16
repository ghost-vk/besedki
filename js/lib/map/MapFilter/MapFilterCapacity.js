import MapFilter from "./MapFilter";
import store from "../../store";

class MapFilterCapacity extends MapFilter {
    _updateState() {
        store.setMapFilter('capacity', this.selector.getValue());
    }
}

export default MapFilterCapacity;