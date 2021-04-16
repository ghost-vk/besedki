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
        this.loader = wrapper.find("#popupLoader");
        this.slider = wrapper.find("#popupSlider");
        this.sliderNav = wrapper.find("#popupSliderNav");
        this.selectBox = wrapper.find("#selectDuration");
        this.priceBox = wrapper.find("#popupPriceBox");
    }

    /**
     * Method initializes PopUp, get data from server
     * @method init
     */
    init = () => {
        let client, clientSettings, query;

        this.showLoader();
        this.show();

        query = {
            id: this.id,
            data_for: "popup"
        }

        clientSettings = {
            nonce: popupData.nonce,
            action: "get_booking_product_data",
            url: popupData.url
        }

        client = new ServerClient(clientSettings, query);
        client.get(this.update); // Get data from server

        this.closeBtn.click(this.destroy);
    }

    /**
     * Method destroys PopUp data (Slider, Select, Datetimepicker) and close PopUp window
     */
    destroy = () => {
        // Reset slick sliders
        let slider = new Slider(this.slider);
        slider.resetSlider();

        if (sliderNav.length) {
            let sliderNav = new Slider(this.sliderNav);
            sliderNav.resetSlider();
        }

        this.selector.destroy();

        this.hide();
    }

    /**
     * Update data in PopUp window, setup Slider, Select, Datetimepicker
     * @param data {Object} from server
     */
    update = (data) => {
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

        let selector = new SelectDuration(this.selectBox, this.priceBox, data.variations);
        selector.init();
        this.selector = selector.getSelector();
        console.log(this.selector);

        this.hideLoader();
    }

    /**
     * Show popup
     */
    show = () => {
        this.wrapper.addClass("z");

        let removeOpacity = () => {
            this.wrapper.addClass("active");
        }
        setTimeout(removeOpacity, 100);
    }

    /**
     * Hide popup
     */
    hide = () => {
        this.wrapper.removeClass("active");

        let addOpacity = () => {
            this.wrapper.removeClass("active");
        }
        setTimeout(addOpacity, 200);
    }

    /**
     * Show loader
     */
    showLoader = () => {
        this.loader.addClass("z");

        this.loader.html(`
                    <div class="popupGallery__loader-wrapper">
                        <div class="wrapper">
                            <div class="circle"></div>
                            <div class="circle"></div>
                            <div class="circle"></div>
                            <div class="shadow"></div>
                            <div class="shadow"></div>
                            <div class="shadow"></div>
                            <span>Загрузка</span>
                        </div>
                    </div>
                `);

        setTimeout( function () {
            this.loader.addClass("active")
        }.bind(this), 100);
    }

    /**
     * Hide loader
     */
    hideLoader = () => {
        this.loader.removeClass("active");

        setTimeout( function () {
            this.loader.removeClass("z")
        }.bind(this), 150);

        this.loader.html("");
    }
}