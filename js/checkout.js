import {startAnalyticsAfterLoading} from "./lib/analytics/analytics-handler";
import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import {createMaskInput} from "./lib/masked-input";
import {validateCheckout} from "./lib/checkout-validation";

import cartCss from './../style/cart.css';

startAnalyticsAfterLoading();
header();

$(document).ready(() => {
    pageLoader();
    notifyCookies();
    callback($("#callbackForm"));

    createMaskInput();
    validateCheckout();
});