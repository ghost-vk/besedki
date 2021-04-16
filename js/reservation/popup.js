BESEDKA.testMethod = () => {

}

(function ($) {
    $(document).ready(function () {

        // SLIDER
        let popupWindow,
            slider,
            sliderNav;

        popupWindow = $(".popupGallery");
        slider = popupWindow.find("#popupSlider");
        sliderNav = popupWindow.find("#popupSliderNav");


        // SELECT DURATION
        // const durationOptions = [
        //     { name: '1 час', value: '1' },
        //     { name: '2 часа', value: '2' },
        //     { name: '3 часа', value: '3' },
        //     { name: 'Целый день', value: 'day' }
        // ];
        //
        // const selectDuration = $('#selectDuration');
        // selectDuration.select({
        //     data: durationOptions,
        //     index: 3
        // });


        // DATETIME
        const picker = $('#datetimepicker');
        const datetimeArgs = {
            inline: true,
            format: "d.m.Y H:i",
            minDate: 0,
            withoutCopyright: true,
            todayButton: false,
            // allowTimes: [''],

            // onSelectDate: function($dtp) {
            //     if (!settings.productID.length) {
            //         return; // Показываем, что сначала надо выбрать беседку
            //     }
            //
            //     picker.datetimepicker('toggleLoader');
            //
            //     let data = { // Data to send via AJAX
            //         action: 'get_available_rent_time',
            //         product_id: settings.productID,
            //         rent_date: getYmd(picker),
            //         nonce: bookingDatetime.nonce
            //     }
            //
            //     // console.log(data); // Test
            //
            //     $.post( bookingDatetime.url, data, function (response) {
            //         console.log(response); // Test
            //         setNewTimes(response.times);
            //         picker.datetimepicker('toggleLoader');
            //     });
            // },
        };

        picker.datetimepicker(datetimeArgs); // Starts Datetimepicker

        class ServerClient {
            constructor(query) {
                this.data = query;
                this.data.nonce = popupData.nonce;
                this.data.action = "get_booking_product_data";
                this.url = popupData.url;
            }

            get = (callback = null) => {
                $.post(this.url, this.data, function (response) {
                    if (typeof callback === "function") {
                        callback(response);
                    }
                    console.log(response); // Test
                });
            }
        }

        class Popup {
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

            init = () => {
                let client, query;

                this.showLoader();
                this.show();

                query = {
                    id: this.id,
                    data_for: "popup"
                }
                client = new ServerClient(query);
                client.get(this.update); // Get data from server

                this.closeBtn.click(this.destroy);
            }

            destroy = () => {
                // Reset slick sliders
                slider = new Slider(this.slider);
                slider.resetSlider();

                if (sliderNav.length) {
                    sliderNav = new Slider(this.sliderNav);
                    sliderNav.resetSlider();
                }

                this.selector.destroy();

                this.hide();
            }

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

        class Slider {
            /**
             * Slider block which should init like slick slider
             * @param slider jQuery object
             */
            constructor(slider) {
                this.slider = slider;
            }

            /**
             * Set images for sliding
             * @param gallery {Array}
             */
            setGallery = (gallery) => {
                this.gallery = gallery;
            }

            /**
             * Reset slick slider // TODO Повесить эту функцию на выключение окна
             */
            resetSlider = () => {
                if (! this.slider.length) {
                    return;
                }

                this.slider.slick('unslick');
                this.slider.html('');
            }

            addSlides = () => {
                let template = `
                    <div class="popupGallery__bg"
                     style="background: center / cover no-repeat url('${this.gallery[0]}')">
                    </div>
                `;
                this.slider.slick('slickAdd', template);
            }
        }

        class SliderMain extends Slider {
            /**
             * Constructor
             * @param slider {jQuery object}
             * @param isNavExist {Boolean}
             * @param sliderNavID {String} HTML ID of slick navigation slider
             */
            constructor(slider, isNavExist, sliderNavID = false) {
                super(slider);
                this.isNavExist = isNavExist;
                this.sliderNavID = sliderNavID;
            }

            init = () => {
                this.slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    dots: false,
                    asNavFor: (this.isNavExist) ? `#${this.sliderNavID}` : null,
                    respondTo: 'slider',
                    arrows: true,
                    appendArrows: "#popupSliderArrows",
                    prevArrow: "<div class='arrowLeft'><i class=\"fas fa-chevron-circle-left\"></i></div>",
                    nextArrow: "<div class='arrowRight'><i class=\"fas fa-chevron-circle-right\"></i></div>"
                });
            }

            getSlideTemplate = (image) => {
                return `
                    <div class="popupGallery__bg"
                     style="background: center / cover no-repeat url('${image}')">
                    </div>
                `;
            }

            /**
             * Add slides into slider
             */
            addSlides = () => {
                let slide;

                if (!this.gallery) {
                    return;
                }

                for (var i = 0, max = this.gallery.length; i < max; i += 1) {
                    slide = this.getSlideTemplate(this.gallery[i]);
                    this.slider.slick('slickAdd', slide);
                }
            }
        }

        class SliderNav extends Slider {
            /**
             * Constructor
             * @param slider {jQuery object}
             * @param sliderID {String} HTML ID of slick slider
             */
            constructor(slider, sliderID) {
                super(slider);
                this.sliderID = sliderID;
            }


            init = () => {
                this.slider.slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: `#${this.sliderID}`,
                    dots: false,
                    arrows: false,
                    focusOnSelect: true,
                    vertical: true
                });
            }

            getSlideTemplate = (image) => {
                return `
                    <div class="popupGallery__bg"
                         style="background: center / cover no-repeat url('${image}')">
                    </div>
                `;
            }

            /**
             * Add slides into slider
             */
            addSlides = () => {
                let slide;

                if (!this.gallery) {
                    return;
                }

                for (var i = 0, max = this.gallery.length; i < max; i += 1) {
                    slide = this.getSlideTemplate(this.gallery[i]);
                    this.slider.slick('slickAdd', slide);
                }
            }
        }

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
            init = () => {
                this.select = this.el.select({
                    data: this.options,
                    index: this.index,
                    itemClick: this.changePrice,
                    initCallback: this.initPrice
                });
            }

            /**
             * Function 'changePrice' fires on select option click
             */
            changePrice = () => {
                let currentValue = this.select.getValue()
                for (var i = 0, max = this.variations.length; i < max; i += 1) {
                    if (this.variations[i].duration === currentValue) {
                        this.priceBox.html(`${this.variations[i].price} &#8381;`);
                    }
                }
            }

            /**
             * Changes price with depends to whole day duration on selector init
             */
            initPrice = () => {
                this.priceBox.html(`${this.variations[3].price} &#8381;`)
            }

            /**
             * Method returns selector object
             * @return {Selector}
             */
            getSelector = () => {
                return this.select;
            }
        }

        BESEDKA.testMethod = () => {
            let popup = new Popup(jQuery("#popupGallery"), 11);
            popup.init();
        }

        BESEDKA.testMethod();

    });
})(jQuery);