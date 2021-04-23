/**
 * Class for works with slider in PopUp window
 */
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
     * Reset slick slider
     */
    resetSlider = () => {
        if (this.slider === "undefined" || !this.slider.slick('getSlick')) {
            return;
        }

        this.slider.slick('unslick');
        this.slider.html('');
    }

    /**
     * Method adds slides to Slick slider
     */
    addSlides = () => {
        let template = `
                    <div class="popupGallery__bg"
                     style="background: center / cover no-repeat url('${this.gallery[0]}')">
                    </div>
                `;
        this.slider.slick('slickAdd', template);
    }
}


/**
 * Class for works with big (main) slider
 * @extends Slider
 */
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


/**
 * Class for works with navigation slider
 * Need only on desktop by default
 * @extends Slider
 */
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