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

    return  Backbone.Collection.extend({

        url: 'site/Getmenu',

        model:MenulistModel,
    });

});
