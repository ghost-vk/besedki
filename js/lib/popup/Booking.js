class Booking {
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

    request(callbackSuccess=null, callbackFailure=null) {
        let serverQuery, clientSettings, serverClient, state;
        console.log(`Booking: ${this.id} ${this.datetime} ${this.duration}`);
        state = store.getState();

        serverQuery = {
            product_id: this.id,
            variation_id: state.reservation.variationID,
            rent_datetime: this.datetime,
            rent_duration: this.duration
        }

        clientSettings = {
            nonce: popupData.nonce,
            action: "add_booking_to_cart",
            url: popupData.url
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

    getError(text) {
        return {
            error: true,
            errorText: `${text}`
        }
    }

    showNotification(response) {
        let notificationArgs, notification;

        if (response.status === false) {
            notificationArgs = {
                text: "К сожалению, выбранное время уже занято либо не доступно",
                icon: '<i class="fas fa-exclamation-triangle"></i>',
            }
        } else {
            notificationArgs = {
                text: "Для завершения бронирования необходимо оплатить заказ",
                icon: '<i class="fas fa-check-circle"></i>',
                linkUrl: popupData.cartURL,
                linkTitle: 'Оплатить',
            }
        }

        notification = new Notification(jQuery("#notification"), notificationArgs);
        notification.init();
    }
}