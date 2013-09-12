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
], function ($, _, Backbone,Marionette, listModel) {

    return  Backbone.Collection.extend({

        url: 'site/Getpartners',

        model:listModel,
    });

});
