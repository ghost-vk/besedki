import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import {stickButton} from "./lib/sticky-button";

import reviewsCss from './../style/reviews.css';
import {startAnalyticsAfterLoading} from "./lib/analytics/analytics-handler";

startAnalyticsAfterLoading();
header();

$(document).ready(function () {
    pageLoader();
    stickButton();
    notifyCookies();
    callback($("#callbackForm"));
});