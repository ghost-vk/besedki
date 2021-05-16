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

export default PopupError;