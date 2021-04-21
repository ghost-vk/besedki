/**
 * Module is responsible for notifications users
 * about uncompleted status site
 */
(function ($) {
    $(document).ready(function () {
        let state, notification, args;

        state = store.getState();

        if (Cookies.get("isNotification") !== "true") {
            args = {
                text: `Наш сайт находится в разработке, мы еще не подключили платежные системы.
                    <br /><br />На данный момент на сайте нельзя забронировать беседку.`
            }
            notification = new Notification(state.general.notificationContainer, args)
            notification.init(6000);

            var inFifteenMinutes = new Date(new Date().getTime() + 15 * 60 * 1000);
            Cookies.set('isNotification', 'true', { expires: inFifteenMinutes });
        }
    });
})(jQuery);