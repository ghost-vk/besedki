import 'slick-carousel';
import Slider from "./Slider";

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

export default SliderNav;