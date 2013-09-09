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
    'models/meni_list'
], function ($, _, Backbone,Marionette, MenilistModel) {

    var MenilistCollection = Backbone.Collection.extend({

        url: 'http://localhost/my_git/site/Getmenu',

        model:MenilistModel
    });

    return MenilistCollection;

});
