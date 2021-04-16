(function ($) {
    $(document).ready(function () {
        BESEDKA.testMethod = () => {
            let popup = new Popup(jQuery("#popupGallery"), 11);
            popup.init();
        }

        BESEDKA.testMethod();
    });
})(jQuery);