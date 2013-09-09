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
    'backboneMarionette',
    'models/menu-list'
], function ($, _, Backbone,Marionette, MenulistModel) {

    var MenulistCollection = Backbone.Collection.extend({

        url: 'site/Getmenu',

        model:MenulistModel,
    });

    return MenulistCollection;

});
