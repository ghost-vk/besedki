import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import mainCss from './../style/main.css';
import {startAnalyticsAfterLoading} from "./lib/analytics/analytics-handler";

startAnalyticsAfterLoading();
header();

$(document).ready(function () {
   pageLoader();
   notifyCookies();
   callback($("#callbackForm"));
});