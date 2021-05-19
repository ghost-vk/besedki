/**
 * @namespace utils
 */
var utils = utils || {};

/**
 * Method returns localized data generated in enqueue.php
 * @param _object {'objectName'}
 * @param key {string}
 * @return {Object}
 */
utils.getLocalizeData = (_object, key) => {
    if (typeof window[_object] !== "undefined") {
        return window[_object][key];
    }
    return {};
};

/**
 * Method load script from src, and append it into head tag
 * @param src
 * @param isAsync
 * @return {Promise<unknown>}
 */
utils.loadSource = (src, isAsync) => {
    let async = (isAsync) ? isAsync : false;

    const scriptTag = document.createElement('script');
    scriptTag.type = 'text/javascript';
    scriptTag.async = async;

    return new Promise((resolve, reject) => {
       scriptTag.onload = () => resolve();
       scriptTag.onerror = () => reject();
       scriptTag.src = src;
       document.querySelector('head').appendChild(scriptTag);
    });
}

export default utils;