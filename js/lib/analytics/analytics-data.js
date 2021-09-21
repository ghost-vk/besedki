import Cookies from 'js-cookie';
import {opacity} from "../../../../../../wp-includes/js/codemirror/csslint";

/**
 * @namespace analytics
 * @type {Object}
 */
var analytics = analytics || {};

analytics.settings = {
    yandexID: 78198895
}

/**
 * Main handler send data to analytics platforms
 * @param action
 */
analytics.sendData = function (action) {
    let inThirtyMinutes = new Date(new Date().getTime() + 30 * 60 * 1000); // 3 minutes now
    switch (action) {
        case "view": {
            if (Cookies.get('isAlreadyView') === 'true') { // Already send
                break;
            }

            this._fireEvent(action);

            Cookies.set('isAlreadyView', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "add": {
            this._fireEvent(action);
            Cookies.set('isAlreadyAddToCart', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "secondTimeAdd": {
            this._fireEvent(action);
            break;
        }
        case "purchase": {
            if (Cookies.get('isPurchaseFired') === 'true') { // Already send
                return;
            }
            this._fireEvent(action);
            Cookies.set('isPurchaseFired', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "lid": {
            if (Cookies.get('isLidFired') === 'true') { // Already send
                return;
            }
            this._fireEvent(action);
            Cookies.set('isLidFired', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "proceed": {
            if (Cookies.get('isProceedFired') === 'true') { // Already send
                return;
            }
            this._fireEvent(action);
            Cookies.set('isProceedFired', 'true', { expires: inThirtyMinutes });
            break;
        }
        default: {
            return;
        }
    }
}

/**
 * Method returns analytics action code (event name)
 * @param action
 * @return {string|boolean}
 * @private
 */
analytics._getActionCode = function (action) {
    switch (action) {
        case "view": {
            return "contentView";
            break;
        }
        case "add": {
            return "addToCart";
            break;
        }
        case "secondTimeAdd": {
            return "secondAdd";
            break;
        }
        case "purchase": {
            return "purchase";
            break;
        }
        case "lid": {
            return "getLid";
            break;
        }
        case "proceed": {
            return "startCheckout";
            break;
        }
        default: {
            return false;
        }
    }
}

/** YANDEX */
analytics._sendDataYandex = function (id, actionCode) {
    if (typeof ym === "undefined") {
        return;
    }
    // console.log("Отправка информации в Яндекс. Действие: " + actionCode);
    ym(id, 'reachGoal', actionCode);
}

/** GOOGLE ANALYTICS */
analytics._sendDataGoogle = function (actionCode) {
    if (typeof gtag === "undefined") {
        return;
    }
    // console.log("Отправка информации в Google. Действие: " + actionCode);
    gtag('event', actionCode);
}

const getFbpCode = (actionCode) => {
    if (!['contentView', 'addToCart', 'secondAdd', 'purchase', 'getLid', 'startCheckout'].includes(actionCode)) {
        return null
    }
    switch (actionCode) {
        case "contentView": {
            return "ViewContent";
            break;
        }
        case "addToCart": {
            return "AddToCart";
            break;
        }
        case "secondAdd": {
            return "AddToCart";
            break;
        }
        case "purchase": {
            return "Purchase";
            break;
        }
        case "getLid": {
            return "Lead";
            break;
        }
        case "startCheckout": {
            return "InitiateCheckout";
            break;
        }
        default: {
            return false;
        }
    }
}

analytics._sendDataFbp = (actionCode) => {
    if (typeof fbq === "undefined" || !actionCode) {
        return;
    }
    fbq('track', actionCode)
}

/**
 * Method fires event in all analytics platform
 * @param action {String}
 * @private
 */
analytics._fireEvent = function (action) {
    let actionCode = this._getActionCode(action);
    if (!actionCode) {
        return;
    }
    this._sendDataYandex(this.settings.yandexID, actionCode);
    this._sendDataGoogle(actionCode);
    this._sendDataFbp(getFbpCode(actionCode))
}

analytics.startAnalytics = () => {
    /**
     * Listener fired when page is loaded
     * Send 'viewContent' event to platforms
     */
    setTimeout(analytics.sendData.bind(analytics), 10000, "view");

    /** Purchase event */
    if (document.location.href.includes("checkout/order-received/")) {
        analytics.sendData("purchase");
    }
}

export default analytics;