import utils from "../utils";
export const loadAnalytics = () => {
    return new Promise(() => {
        let yandex, google, pixel;
        yandex = loadYandex();
        google = loadGoogle('https://www.googletagmanager.com/gtag/js?id=UA-196988125-1');
    });
}

const loadYandex = () => {
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    if (typeof ym === "undefined") {
        return false;
    }

    ym(78198895, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
}

const loadGoogle = (src) => {
    utils.loadSource(src, true)
        .then(() => {
            if (typeof gtag === "undefined") {
                console.log('Google analytics is not loaded');
                return false;
            }
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-196988125-1');
        });
}