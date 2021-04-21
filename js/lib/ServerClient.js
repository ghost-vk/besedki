/**
 * Class allow to get data from the server
 */
class ServerClient {
    /**
     * Constructor
     * @param settings { nonce: 'nonce-code', action: 'actionName, url: 'path/to/admin-ajax' }
     * @param query { Object }
     */
    constructor(settings, query) {
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
            console.log(response); // Test
        });
    }
}