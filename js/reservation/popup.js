var BESEDKA = BESEDKA || {};
(function ($) {
    $(document).ready(function () {
        BESEDKA.testMethod = () => {
            let popup = new Popup(jQuery("#popupGallery"), 11);
            popup.init();
        }

        BESEDKA.initMap = () => {
            let map = new MapHandler("map");
            map.init();
        }

        BESEDKA.initMap();
    });
})(jQuery);