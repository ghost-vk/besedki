const createAnalyticsHandler = function () {
    return {
        fireContentView
    }
}

var analytics = analytics || {};

analytics.settings = {
    yandexID: 78198895
}

analytics.sendData = function (action) {
    let inThirtyMinutes = new Date(new Date().getTime() + 3 * 60 * 1000); // 3 minutes now
    switch (action) {
        case "view": {
            if (Cookies.get('isAlreadyView') === 'true') { // Already send
                break;
            }

            this._fireYandexEvent(action);

            Cookies.set('isAlreadyView', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "add": {
            this._fireYandexEvent(action);
            Cookies.set('isAlreadyAddToCart', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "secondTimeAdd": {
            this._fireYandexEvent(action);
            break;
        }
        case "purchase": {
            if (Cookies.get('isPurchaseFired') === 'true') { // Already send
                return;
            }
            this._fireYandexEvent(action);
            Cookies.set('isPurchaseFired', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "lid": {
            if (Cookies.get('isLidFired') === 'true') { // Already send
                return;
            }
            this._fireYandexEvent(action);
            Cookies.set('isLidFired', 'true', { expires: inThirtyMinutes });
            break;
        }
        case "proceed": {
            if (Cookies.get('isProceedFired') === 'true') { // Already send
                return;
            }
            this._fireYandexEvent(action);
            Cookies.set('isProceedFired', 'true', { expires: inThirtyMinutes });
            break;
        }
        default: {
            return;
        }
    }
}

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
    console.log("Отправка информации в Яндекс. Действие: " + actionCode);
    ym(id, 'reachGoal', actionCode);
}

analytics._fireYandexEvent = function (action) {
    // if (!ym) {
    //     return;
    // }
    let actionCode = this._getActionCode(action);
    if (!actionCode) {
        return;
    }
    this._sendDataYandex(this.settings.yandexID, actionCode);
}

/**
 * Listener fired when page is loaded
 * Send 'viewContent' event to platforms
 */
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(analytics.sendData.bind(analytics), 4000, "view");
});

if (document.location.href.includes("checkout/order-received/")) {
    analytics.sendData("purchase");
}