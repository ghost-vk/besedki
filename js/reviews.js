import analytics from "./analytics";
import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import {stickButton} from "./lib/sticky-button";

import reviewsCss from './../style/reviews.css';

header();
analytics.startAnalytics();

$(document).ready(function () {
    pageLoader();
    stickButton();
    notifyCookies();
    callback($("#callbackForm"));
});