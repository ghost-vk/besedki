/**
 * Class used for add booking to cart
 * @class Booking
 *
 */
class Booking {
    /**
     * Constructor
     * @param id { '11' }
     * @param datetime { 'Y-m-d H:i:s' }
     * @param duration { '1' | '2' | '3' | 'day'}
     * @return {{errorText: string, error: boolean}}
     */
    constructor(id, datetime, duration) {
        let error;
        if (!datetime) {
            error = this.getError("Выберите дату и время для бронирования");
            return error;
        }
        if (!duration) {
            error = this.getError("Выберите продолжительность аренды");
            return error;
        }
        if (!id) {
            error = this.getError("Ошибка сервера, попробуйте перезагрузить страницу");
            return error;
        }
        this.id = id;
        this.datetime = datetime;
        this.duration = duration;
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
            product_id: this.id,
            variation_id: state.reservation.variationID,
            rent_datetime: this.datetime,
            rent_duration: this.duration
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
            } else if (typeof callbackFailure === "function" && response.status === false) {
                callbackFailure();
            }
            this.showNotification(response);
        }.bind(this));
    }


    /**
     * Method get error if have bad response from server.
     * @param text
     * @return {{errorText: string, error: boolean}}
     */
    getError(text) {
        return {
            error: true,
            errorText: `${text}`
        }
    }


    /**
     * Method call Notification to show server response
     * @param response { 'status': boolean }
     */
    showNotification(response) {
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

        notification = new Notification(jQuery("#notification"), notificationArgs);
        notification.init();
    }
}