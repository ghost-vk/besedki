/**
 * Class Loader used for show loader
 * F.e when do server request
 */
class Loader {

    /**
     * Constructor
     * @param element {jQuery}
     */
    constructor(element) {
        this.loader = element;
    }


    /**
     * Method shows loader
     */
    show() {
        this.loader.addClass("z");
        this.loader.html(`
            <div class="loader-wrapper">
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
            this.loader.addClass("active");
        }.bind(this), 100);
    }


    /**
     * Method hides loader
     */
    hide() {
        this.loader.removeClass("active");

        setTimeout( function () {
            this.loader.removeClass("z");
        }.bind(this), 150);

        this.loader.html("");
    }
}