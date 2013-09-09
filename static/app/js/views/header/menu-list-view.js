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
    'collections/menu-list',
    'views/header/menu-list-tem-view'
], function ($, _, Backbone,Marionette, MenulistCollection,MenulistItemView) {

    var MenuListView = Backbone.View.extend({

        el: $('#menulist'),
        model: MenulistCollection,
        initialize: function() {
            this.model.bind("reset", this.render, this);
        },
        render: function(eventName) {
            _.each(this.model.models, function(wine) {
                $(this.el).append(new MenulistItemView({model: wine}).render().el);
            }, this);
            return this;
        }
    });

    return MenuListView;

});
