class Notification {
    constructor(el, data) {
        this.text = data.text;
        this.icon = (data.icon) ? data.icon : '<i class="fas fa-info-circle"></i>';
        this.linkUrl = data.linkUrl;
        this.linkTitle = data.linkTitle
        this.el = el;
        this.closeButton = jQuery('<span class="notification__close notification-button">Закрыть</span>');
    }

    init(timeout = 7000) {
        let template = this.createTemplate();
        this.el.html(template);
        this.show();

        this.closeButton = this.el.find(".notification__close");

        this.closeButton.click(this.destroy.bind(this));
        setTimeout(this.destroy.bind(this), timeout);
    }

    show() {
        this.el.addClass('notification-active');
    }

    hide() {
        this.el.removeClass("notification-active");
    }

    createTemplate() {
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

    destroy() {
        this.hide();
        this.el.html("");
    }
}