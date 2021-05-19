import ServerClient from "../ServerClient";
import store from "../store";
import Notification from "../Notification";
import Cookies from 'js-cookie';
import analytics from "../analytics/analytics-data";

/**
 * Class used for add booking to cart
 * @class Booking
 *
 */
class Booking {
    /**
     * Constructor
     * @param state {
     *   bookingNeedTime: '2021-05-12 13:00:00',
     *   bookingDuration: 'day',
     *   productID: '312',
     *   variationID: '316'
     * }
     * @return {{errorText: string, error: boolean}}
     */
    constructor(state) { // Only state should be here
        let error;
        if (!state.bookingNeedTime) {
            error = this._getError("Выберите дату и время для бронирования");
            return error;
        }
        if (!state.bookingDuration) {
            error = this._getError("Выберите продолжительность аренды");
            return error;
        }
        if (!state.productID || !state.variationID) {
            error = this._getError("Ошибка сервера, попробуйте перезагрузить страницу");
            return error;
        }
        this.productID = state.productID;
        this.variationID = state.variationID;
        this.bookingNeedTime = state.bookingNeedTime;
        this.bookingDuration = state.bookingDuration;
    }


    /**
     * Method send request to server, fire callback.
     * @param callbackSuccess {Function|null}
     * @param callbackFailure {Function|null}
     */
    request(callbackSuccess=null, callbackFailure=null) {
        let serverQuery, clientSettings, serverClient, state;
        state = store.getState();

        serverQuery = {
            product_id: this.productID,
            variation_id: this.variationID,
            rent_datetime: this.bookingNeedTime,
            rent_duration: this.bookingDuration
        }

        clientSettings = {
            nonce: state.general.nonce,
            action: "add_booking_to_cart",
            url: state.general.ajaxUrl
        }

        serverClient = new ServerClient(clientSettings, serverQuery);
        serverClient.get(function(response) {
            if (typeof callbackSuccess === "function" && response.status === true) {
                callbackSuccess();
                let analyticsEvent = (Cookies.get('isAlreadyAddToCart') === 'true') ? 'secondTimeAdd' : 'add';
                analytics.sendData(analyticsEvent);
            } else if (typeof callbackFailure === "function" && response.status === false) {
                callbackFailure();
            }
            this._showNotification(response);
        }.bind(this));
    }


    /**
     * Method get error if have bad response from server.
     * @param text
     * @return {{errorText: string, error: boolean}}
     */
    _getError(text) {
        return {
            error: true,
            errorText: `${text}`
        }
    }


    /**
     * Method call Notification to show server response
     * @param response { 'status': boolean }
     */
    _showNotification(response) {
        let notificationArgs, notification, state;

        state = store.getState();


        if (response.status === false) {
            notificationArgs = {
                text: "К сожалению, выбранное время уже занято либо не доступно",
                icon: '<i class="fas fa-exclamation-triangle"></i>',
            }
        } else {
            notificationArgs = {
                text: "Для завершения бронирования необходимо оплатить заказ",
                icon: '<i class="fas fa-check-circle"></i>',
                linkUrl: state.reservation.popup.settings.cartURL,
                linkTitle: 'Оплатить',
            }
        }

        notification = new Notification($("#notification"), notificationArgs);
        notification.init(5000);
    }
}

export default Booking;