class MapFilter {
    /**
     * Constructor
     * @param element {jQuery}
     * @param props { name: 'For display', value: 'value' }
     */
    constructor(element, props) {
        this.element = element;
        this.props = props;
    }

    init() {
        let index = this.props.length - 1;
        this.selector = this.element.select({
            data: this.props,
            index: index,
            itemClick: this._updateState.bind(this)
        });
    }

    /**
     * Should be overridden in child
     * @private
     */
    _updateState() {
        console.log('State should be changed');
    }
}

export default MapFilter;