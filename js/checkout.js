import analytics from "./analytics";
import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import {createMaskInput} from "./lib/masked-input";
import {validateCheckout} from "./lib/checkout-validation";

import cartCss from './../style/cart.css';

header();
analytics.startAnalytics();

$(document).ready(() => {
    pageLoader();
    notifyCookies();
    callback($("#callbackForm"));

    createMaskInput();
    validateCheckout();
});