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

export default utils;