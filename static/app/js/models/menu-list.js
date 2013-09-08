/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'jquery',
    'underscore',
    'backbone',
], function ($, _, Backbone) {

    var MenulistModel = Backbone.Model.extend({

        url: 'http://localhost/my_git/site/Getmenu',

        defaults:{
            "id":null,
            "name":"",
            "is_blocked":"",
            "info":"",
            "weight":""
        },

        parse: function(response) {
            return response;
        }

    });

    return MenulistModel;
});
