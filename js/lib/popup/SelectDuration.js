import store from "../store";

/**
 * Class for works with selector in PopUp window
 */
class SelectDuration {
    /**
     * Constructor
     * @param el {jQuery object}
     * @param priceBox {jQuery object}
     * @param variations {Array[Object]} should contains elements: Object with 'price' property
     */
    constructor(el, priceBox, variations, popup) {
        this.el = el;
        this.options = [
            { name: '1 час', value: '1' },
            { name: '2 часа', value: '2' },
            { name: '3 часа', value: '3' },
            { name: 'Целый день', value: 'day' }
        ];
        this.index = 3;
        this.variations = variations;
        this.priceBox = priceBox;
        this.popup = popup;
    }

    /**
     * Init select
     */
    init() {
        this.select = this.el.select({
            data: this.options,
            index: this.index,
            itemClick: this._onOptionClick.bind(this),
            initCallback: this._onSelectorInit.bind(this)
        });

        this.popup.on('scroll', this._clickPopup.bind(this));
    }

    /**
     * Method fires on select option click
     * @private
     */
    _onOptionClick() {
        let currentValue = this.select.getValue(),
            availableDuration = ['1', '2', '3', 'day'];

        this._clickPopup();

        if (!availableDuration.includes(currentValue)) {
            return;
        }

        for (var i = 0, max = this.variations.length; i < max; i += 1) {
            if (this.variations[i].duration === currentValue) {
                this.priceBox.html(`${this.variations[i].price} &#8381;`);
                store.setBookingDuration(currentValue);
                store.setVariationID(this.variations[i].id);
            }
        }
    }

    /**
     * Changes price with depends to whole day duration on selector init
     * 3 element in variations should be the last one
     * @private
     */
    _onSelectorInit() {
        this.priceBox.html(`${this.variations[3].price} &#8381;`)
        store.setBookingDuration(this.options[3].value);
        store.setVariationID(this.variations[3].id);
    }

    /**
     * Click on popup wrapper
     * Used for close selector
     * @private
     */
    _clickPopup() {
        this.popup.click();
    }

    /**
     * Method returns selector object
     * @return {Selector}
     */
    getSelector() {
        return this.select;
    }
}

export default SelectDuration;