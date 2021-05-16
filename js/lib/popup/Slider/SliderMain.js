import Slider from "./Slider";
import 'slick-carousel';

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

export default SliderMain;
