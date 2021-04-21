/**
 * Class Notification used for showing
 * response to user after some action
 */
class Notification {
    /**
     * Constructor
     * @param el { jQuery }
     * @param data {
     *   text: 'notification text',
     *   icon: 'FA icon tag',
     *   linkUrl: 'http://some/url' - no required
     *   linkTitle: 'Link title' - no required
     * }
     */
    constructor(el, data) {
        this.text = data.text;
        this.icon = (data.icon) ? data.icon : '<i class="fas fa-info-circle"></i>';
        this.linkUrl = data.linkUrl;
        this.linkTitle = data.linkTitle
        this.el = el;
    }

    /**
     * Method initialize notification window
     * @param timeout { 7000 }
     * @public
     */
    init(timeout = 7000) {
        let template = this._createTemplate();
        this.el.html(template);
        this._show();

        this.closeButton = this.el.find(".notification__close");

        this.closeButton.click(this.destroy.bind(this));
        setTimeout(this.destroy.bind(this), timeout);
    }

    /**
     * Method hides notification wrapper
     * Destroy inner content
     * @public
     */
    destroy() {
        this.el.removeClass("notification-active");
        this.el.html("");
    }

    /**
     * Method show notification window
     * @private
     */
    _show() {
        this.el.addClass('notification-active');
    }

    /**
     * Method creates notification body
     * @return {string}
     * @private
     */
    _createTemplate() {
        let template;
        template = `
            <div class="notification__row">
                <div class="notification__icon">${this.icon}</div>
                <p>${this.text}</p>
            </div>
            <div class="notification__group">
        `;

        if (this.linkUrl && this.linkTitle) {
            template += `<a class="notification__link notification-button"
                href="${this.linkUrl}">${this.linkTitle}</a>`;
        }

        template += `<span class="notification__close notification-button">Закрыть</span>
            </div>`;

        return template;
    }
}