class DatetimeHandler {
    /**
     * Constructor
     * @param el {jQuery}
     * @param id {String|Integer} WC_Product_Variable ID
     */
    constructor(el, id) {
        this.el = el;
        this.id = id;
    }

    /**
     * Method starts Datetimepicker with options
     * @method init
     */
    init() {
        this.options = {
            inline: true,
            format: "d.m.Y H:i",
            minDate: 0,
            withoutCopyright: true,
            todayButton: false,
            defaultSelect: false,
            timepickerScrollbar: false,
            allowTimes: [''],
            onSelectDate: this._onSelectDate.bind(this),
            onSelectTime: this._onSelectTime.bind(this)
        }

        this.el.datetimepicker(this.options); // Starts Datetimepicker
        this.el.datetimepicker("reset"); // Reset initial value - current datetime
    }

    /**
     * Method add available times for booking to Datetimepicker
     * @method getTime
     */
    _onSelectDate() {
        let state, client, clientQuery, clientSettings;
        if (typeof this.id === "undefined") {
            return;
        }

        state = store.getState();
        store.setDateSelectedFlag(true);

        this.toggleLoader();

        clientQuery = {
            product_id: this.id,
            rent_date: this._getYmd()
        };

        clientSettings = {
            nonce: state.general.nonce,
            action: "get_available_rent_time",
            url: state.general.ajaxUrl
        };

        client = new ServerClient(clientSettings, clientQuery);
        client.get(this.setNewTimes.bind(this));
    }

    /**
     * Method show or hide loader
     * @method toggleLoader
     */
    toggleLoader = () => {
        this.el.datetimepicker('toggleLoader');
    }

    /**
     * Returns formated string from datetimepicker in "Y-m-d", f.e "2000-01-01"
     * @return {string}
     * @method getYmd
     * @private
     */
    _getYmd = () => {
        let needDate = this.el.datetimepicker('getValue'),
            Y, m, d;

        if (needDate) {
            Y = needDate.getFullYear();
            m = needDate.getMonth() + 1;
            d = needDate.getDate();

            return `${Y}-${m}-${d}`;
        } else {
            return;
        }
    }

    /**
     * Method returns formated string from datetimepicker in "Y-m-d H:i:s", f.e "2000-01-01 14:00:00"
     * @return {string}
     * @method getYmdHis
     */
    _setYmdHis() {
        let state = store.getState();
        if (!state.reservation.isDateSelected) {
            return false;
        }

        if (!state.reservation.isTimeSelected) {
            this.el.datetimepicker("addTimeboxErrorBorder");
            return false;
        } else {
            this.el.datetimepicker("removeTimeboxErrorBorder");
        }

        let needDate = this.el.datetimepicker('getValue'),
            Y, m, d, H,
            value;

        if (needDate) {
            Y = needDate.getFullYear();
            m = needDate.getMonth() + 1;
            d = needDate.getDate();
            H = needDate.getHours();

            value = `${Y}-${m}-${d} ${H}:00:00`;
        } else {
            return;
        }

        store.setYmdHis(value);
    }

    /**
     * Method set times after AJAX query to server
     * @method setNewTimes
     * @param times {Array[String]}
     * times should be array contains times, f.e ["13:00", "14:00"]
     */
    setNewTimes(data) {
        if (!Array.isArray(data.times)) {
            return;
        }
        this.el.datetimepicker('addTimeboxActiveClass');
        this.el.datetimepicker('setOptions', {
            allowTimes: data.times
        });

        this.toggleLoader();
    }

    /**
     * Method set time selected flag in state
     * @private
     */
    _onSelectTime() {
        store.setTimeSelectedFlag(true);
        this._setYmdHis();
    }
}