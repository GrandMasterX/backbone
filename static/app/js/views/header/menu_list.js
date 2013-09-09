/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'backboneBUI',
    'text!templates/header/menu-list',
    'models/menu-list',
    'jquery',
    'underscore',
    'backbone',
    'views/header/menu-list-item-view'
], function (Marionette,App, MenulistView,MenulistModel,$, _, Backbone,MenuListItemViews) {

    var MenilistView = Marionette.ItemView.extend({
        el: $('#menulist'),
        model: MenulistModel,
        template: MenuListItemViews,

        initialize: function() {
            this.model.bind("reset", this.render, this);
        },
        render: function(eventName) {
            _.each(this.model.models, function(wine) {
                $(this.el).append(new this.template({model: wine}).render().el);
            }, this);
            return this;
        }

    });

    return MenilistView;

});
