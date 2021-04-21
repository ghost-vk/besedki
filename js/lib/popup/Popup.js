/**
 * Class for works with booking reservation modal window
 */
class Popup {
    /**
     * Constructor
     * @param wrapper
     * @param id {String|Integer} Variable Product ID (woocommerce)
     */
    constructor(wrapper, id) {
        this.id = id;
        this.wrapper = wrapper;
        this.closeBtn = wrapper.find("#closeBtn");
        this.loader = new Loader(wrapper.find("#popupLoader"));
        this.slider = wrapper.find("#popupSlider");
        this.sliderNav = wrapper.find("#popupSliderNav");
        this.selectBox = wrapper.find("#selectDuration");
        this.priceBox = wrapper.find("#popupPriceBox");
        this.datetimeInput = wrapper.find("#datetimepicker");
        this.bookBtn = wrapper.find("#popupBookBtn");
        this.errorBlock = wrapper.find("#popupErrorBlock");
    }

    /**
     * Method initializes PopUp, get data from server
     * @method init
     */
    init() {
        let client, clientSettings, query, state;

        state = store.getState();

        this.fixBody();
        this.showLoader();
        this.show();

        query = {
            id: this.id,
            data_for: "popup"
        }

        clientSettings = {
            nonce: state.general.nonce,
            action: "get_booking_product_data",
            url: state.general.ajaxUrl
        }

        client = new ServerClient(clientSettings, query);
        client.get(this.update.bind(this)); // Get data from server

        let dth = new DatetimeHandler(this.datetimeInput, this.id);
        this.dth = dth;
        dth.init();

        this.closeBtn.click(this.destroy.bind(this));
        this.bookBtn.click(this.submit.bind(this))
    }


    /**
     * Method destroys PopUp data (Slider, Select, Datetimepicker) and close PopUp window
     */
    destroy() {
        let state = store.getState();

        // Reset slick sliders
        let slider = new Slider(this.slider);
        slider.resetSlider();

        if (this.sliderNav.length) {
            let sliderNav = new Slider(this.sliderNav);
            sliderNav.resetSlider();
        }

        // Reset selector
        this.selector.destroy();

        // Reset datetimepicker
        this.datetimeInput.datetimepicker("destroy");
        state.reservation.isDateSelected = false;
        state.reservation.isTimeSelected = false;

        this.unfixBody();
        this.hide();

        this.loader.hide();
    }


    /**
     * Update data in PopUp window, setup Slider, Select, Datetimepicker
     * @param data {Object} from server
     */
    update (data) {
        this.wrapper.find("#popupTitle").text(data.name);
        this.wrapper.find("#badgeLocation").text(data.location);
        this.wrapper.find("#badgeCapacity").text(data.capacity);
        this.wrapper.find("#badgeMinPrice").text(data.min);
        this.wrapper.find("#badgeMaxPrice").text(data.max);

        // Works with gallery
        let isNavExist = (this.sliderNav.length) ? true : false;

        let sliderMain = new SliderMain(this.slider, isNavExist, 'popupSliderNav');
        sliderMain.setGallery(data.gallery);
        sliderMain.init();
        sliderMain.addSlides();

        let sliderNav = new SliderNav(this.sliderNav, 'popupSlider');
        sliderNav.setGallery(data.gallery);
        sliderNav.init();
        sliderNav.addSlides();

        let popupSelector = new SelectDuration(this.selectBox, this.priceBox, data.variations);
        popupSelector.init();
        this.selector = popupSelector.getSelector();

        this.hideLoader();
    }


    /**
     * Show popup
     */
    show() {
        this.wrapper.addClass("z");

        let removeOpacity = () => {
            this.wrapper.addClass("active");
        }
        setTimeout(removeOpacity, 100);
    }


    /**
     * Hide popup
     */
    hide() {
        this.wrapper.removeClass("active");

        let addOpacity = () => {
            this.wrapper.removeClass("active");
        }
        setTimeout(addOpacity, 200);
    }


    /**
     * Show loader
     */
    showLoader() {
        this.loader.show();
    }


    /**
     * Hide loader
     */
    hideLoader() {
        this.loader.hide();
    }


    /**
     * Fix document body
     */
    fixBody() { // TODO протестировать
        jQuery("body").css("overflow", "hidden");
    }


    /**
     * Let document body scroll
     */
    unfixBody() {
        jQuery("body").css("overflow", "auto");
    }


    /**
     * Method provides submit button logic
     * First, collect data from frontend
     * Second, do server request
     * @method submit
     */
    submit() {
        let booking = new Booking(this.id, this.dth.getYmdHis(), this.selector.getValue());
        if (typeof booking === "object" && booking.error === true) {
            let error = new PopupError(this.errorBlock, booking.errorText);
            error.show();
            return;
        }
        if (booking instanceof Booking) {
            let popupError = new PopupError(this.errorBlock);
            popupError.hide();
        }

        this.loader.show();
        booking.request(this.destroy.bind(this), this.hideLoader.bind(this));
    }
}


/**
 * Class for display error when not enough data to do server request
 * No datetime, no duration, no ID
 */
class PopupError {
    /**
     * Constructor
     * @param el {jQuery}
     * @param error {String}
     */
    constructor(el, error=null) {
        this.el = el;
        this.error = error;
    }

    /**
     * Method show error block (put HTML inside)
     * @method show
     */
    show() {
        this.el.html(`
            <p class="popupGallery__error">
                <i class="fas fa-exclamation-circle"></i>
                ${this.error}
            </p>`);
    }

    /**
     * Method deletes content of error block
     * @method hide
     */
    hide() {
        this.el.html("");
    }
}