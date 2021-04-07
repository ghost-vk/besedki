(function ($) {
    $(document).ready(function () {
        let mobileMenuBtn = $('#mobileMenuBtn'),
            mobileMenu = $('#mobileMenu');

        mobileMenuBtn.click(function () {
            mobileMenu.toggleClass('active');
        });
    });
})(jQuery);