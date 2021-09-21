import utils from "../utils";
export const loadAnalytics = () => {
    return new Promise((resolve, reject) => {
        loadYandex()
            .then(loadGoogle)
            .then(loadFbp)
            .then(() => resolve())
            .catch((err) => {
                console.log(err)
                reject()
            })
    });
}

const loadYandex = () => {
    return new Promise((resolve, reject) => {
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        if (typeof ym === "undefined") {
            reject()
        }

        ym(78198895, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
        resolve()
    })
}

const loadGoogle = () => {
    return new Promise((resolve, reject) => {
        const src = 'https://www.googletagmanager.com/gtag/js?id=UA-196988125-1'
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
                resolve()
            })
            .catch(() => {
                console.log('Analytics is not loaded');
                reject()
            });
    })

}

const loadFbp = () => {
    return new Promise((resolve, reject) => {
        try {
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '917818138808850');
            fbq('track', 'PageView');
            resolve()
        } catch (err) {
            reject()
        }
    })
}