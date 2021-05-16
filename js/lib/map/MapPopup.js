/**
 * Class used for creating popup on map
 */
class MapPopup {
    /**
     * Constructor
     * @param data { title: 'Беседка 1', image: 'path/to/img', capacity: '10', id: '11', min: '2900', max: '6 900' }
     */
    constructor(data) {
        this.title = data.title;
        this.image = data.image;
        this.capacity = data.capacity;
        this.id = data.id; // WC_Product_Variable ID
        this.minPrice = data.min;
        this.maxPrice = data.max;
    }


    /**
     * Method get popup template for map
     * @public
     * @return {string}
     */
    get() {
        return this._createTemplate();
    }


    /**
     * Method returns popup template
     * @return {string}
     * @private
     */
    _createTemplate() {
        return `
                <div class="mapPopup">
                    <div class="mapPopup__row">
                        <div class="mapPopup__column">
                            <span class="mapPopup__title">
                                ${this.title}
                            </span>
                            <img class="mapPopup__image" src="${this.image}" alt="" />
                        </div>
                        <div class="mapPopup__column">
                            <span class="mapPopup__capacity">
                                <i class="fas fa-users"></i> ${this.capacity}
                            </span>
                            <span class="mapPopup__price">
                                <i class="fas fa-ruble-sign"></i> ${this.minPrice} - ${this.maxPrice}
                            </span>
                            <span class="mapPopup__open" data-id="${this.id}">Подробнее</span>
                            <span class="mapPopup__open" data-id="${this.id}">Забронировать</span>
                        </div>
                    </div>
                </div>
            `;
    }
}

export default MapPopup;