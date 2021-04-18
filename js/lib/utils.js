var utils = utils || {};

utils.getLocalizeData = (_object, key) => {
    return _object[key] ? _object[key] : null;
};