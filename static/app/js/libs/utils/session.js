define([
    'jquery'
], function ($) {
    var authUri = 'http://localhost/backbone_yii/site/isLogged';

    return {
        /**
         * Checks whether is logged in or not
         * @return {Boolean}
         */
        checkAuth:function (callback) {
            $.when($.ajax(authUri)).then(callback);
        }
    };
});