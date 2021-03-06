import store from "./store";
import * as Cookies from 'js-cookie';
import Notification from "./Notification";

/**
 * Module is responsible for show message about usage cookie
 */
export const notifyCookies = () => {
    let state = store.getState();

    // Function shows message about cookie usage
    let showCookieUsageMessage = () => {
        let args, notification;
        args = {
            text: `На этом веб-сайте используются файлы cookie.<br />
                   Продолжая пользоваться сайтом вы соглашаетесь с использованием cookie.`,
            icon: '<i class="fas fa-cookie"></i>',
            linkUrl: state.general.privacyUrl,
            linkTitle: 'Подробнее'
        }
        notification = new Notification(state.general.notificationContainer, args);
        notification.init(20000);
    }

    if (Cookies.get('isCookieNotification') !== 'true') { // User is not notificated
        setTimeout(showCookieUsageMessage, 10000);

        let inTwentyMinutes = new Date(new Date().getTime() + 20 * 60 * 1000);
        Cookies.set('isCookieNotification', 'true', { expires: inTwentyMinutes });
    }
}