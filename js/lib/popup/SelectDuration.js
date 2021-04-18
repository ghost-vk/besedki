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
    constructor(el, priceBox, variations) {
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
    }

    /**
     * Init select
     */
    init() {
        this.select = this.el.select({
            data: this.options,
            index: this.index,
            itemClick: this.changePrice.bind(this),
            initCallback: this.initPrice.bind(this)
        });
    }

    /**
     * Function 'changePrice' fires on select option click
     */
    changePrice() {
        let currentValue = this.select.getValue()
        for (var i = 0, max = this.variations.length; i < max; i += 1) {
            if (this.variations[i].duration === currentValue) {
                this.priceBox.html(`${this.variations[i].price} &#8381;`);
                store.setVariationID(this.variations[i].id);
            }
        }
    }

    /**
     * Changes price with depends to whole day duration on selector init
     */
    initPrice() {
        this.priceBox.html(`${this.variations[3].price} &#8381;`)
    }

    /**
     * Method returns selector object
     * @return {Selector}
     */
    getSelector() {
        return this.select;
    }
}