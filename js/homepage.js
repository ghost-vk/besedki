import 'slick-carousel';
import {animateHome} from "./lib/homepage/animate";
import {stickButton} from "./lib/sticky-button";
import {startAnalyticsAfterLoading} from "./lib/analytics/analytics-handler";
import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import slickCss from './../node_modules/slick-carousel/slick/slick.css';
import animateCss from './../node_modules/animate.css/animate.min.css';
import homepageCss from './../style/homepage.css';

startAnalyticsAfterLoading();
header();

animateHome(); // Animations

$(document).ready(function () {
    pageLoader();
    notifyCookies();
    callback($("#callbackForm"));

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

    stickButton(); // Booking button
});