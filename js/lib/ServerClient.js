import store from "./store";

/**
 * Class allow to get data from the server
 */
class ServerClient {
    /**
     * Constructor
     * @param settings { nonce: 'nonce-code', action: 'actionName, url: 'path/to/admin-ajax' }
     * @param query { Object }
     */
    constructor(settings, query = {}) {
        this.data = query;
        this.data.nonce = settings.nonce;
        this.data.action = settings.action;
        this.url = settings.url;
    }

    /**
     * Get data from server and call function from callback param
     * @method get
     * @param callback { Function } - Function will be called after get response from server
     */
    get(callback = null) {
        jQuery.post(this.url, this.data, function (response) {
            if (typeof callback === "function") {
                callback(response);
            }
            // console.log(response); // Test
        }).fail(this._failGetResponse);
    }

    /**
     * Method fires when no success getting response from server
     * @private
     */
    _failGetResponse() {
        let args, notification, state;
        state = store.getState();
        args = {
            text: `Возникла ошибка на сервере<br />Пожалуйста, перезагрузите страницу`,
            icon: '<i class="fas fa-sync-alt"></i>'
        }
        notification = new Notification(state.general.notificationContainer, args)
        notification.init(10000);
    }
}

export default ServerClient;