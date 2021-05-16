import analytics from "./analytics";
import {notifyCookies} from "./lib/cookies-notification";
import {header} from "./lib/header";
import {callback} from "./lib/callback";
import {pageLoader} from "./lib/page-loader";

import mainCss from './../style/main.css';

header();
analytics.startAnalytics();

$(document).ready(function () {
   pageLoader();
   notifyCookies();
   callback($("#callbackForm"));
});