import 'slick-carousel';

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

export default Slider;