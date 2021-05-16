export const header = () => {
    let mobileMenuBtn = $('#mobileMenuBtn'),
        mobileMenu = $('#mobileMenu');

    if (!mobileMenuBtn) {
        return;
    }

    mobileMenuBtn.click(function () {
        mobileMenu.toggleClass('active');
    });
}