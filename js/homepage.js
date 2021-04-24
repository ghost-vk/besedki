(function ($) {
    $(document).ready(function () {
        let slickContainer = $("#slickContainer");

        slickContainer.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            dots: true,
            arrows: false,
            appendDots: $("#slickDots"),
            adaptiveHeight: true,
            fade: true,
            speed: 500,
            cssEase: 'linear',
            useTransform: false,
            infinite: false
        });

        let questionItem = $(".homeQuestion__item");
        questionItem.click(function () {
            $(this).toggleClass('active');
        });

        var animateHome = function() {
            let lookAtAll = $("#lookAtAll"),
                features = $(".homeFeatures .homeFeatures__item"),
                titles = $(".titleAnimated"),
                lookAllReviews = $("#lookAllReviews"),
                questions = $(".homeQuestion .homeQuestion__item"),
                atmosphereImages = $(".homeAtmosphere .homeAtmosphere__img");

            // First button
            lookAtAll.viewportChecker({
                classToAdd: "visible animate__animated animate__fadeInDown"
            });

            // Features
            for (var i = 0, max = features.length; i < max; i += 1) {
                $(features[i]).viewportChecker({
                    classToAdd: "visible animate__animated animate__fadeIn"
                });
            }

            // Titles
            for (var i = 0, max = titles.length; i < max; i += 1) {
                let current = $(titles[i]),
                    animation = current.attr('data-animation'),
                    animationClass;
                animationClass = (animation === "left") ? "animate__fadeInLeft" : "animate__fadeInRight";

                current.viewportChecker({
                    classToAdd: `active animate__animated ${animationClass}`
                });
            }

            // Reviews button
            lookAllReviews.viewportChecker({
                classToAdd: "visible animate__animated animate__fadeInDown"
            });

            // Questions
            for (var i = 0, max = questions.length; i < max; i += 1) {
                $(questions[i]).viewportChecker({
                    classToAdd: "visible animate__animated animate__slideInLeft"
                });
            }

            // Bottom images
            for (var i = 0, max = atmosphereImages.length; i < max; i += 1) {
                $(atmosphereImages[i]).viewportChecker({
                    classToAdd: "visible animate__animated animate__fadeIn"
                });
            }


        }
        animateHome();
    });
})(jQuery);