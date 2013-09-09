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
    'models/menu-list',
    'jquery',
    'underscore',
    'backbone',
], function (Marionette,App, MenuListModel,$, _, Backbone) {

    var MenuListView = Backbone.View.extend({
        el: $('#menuList'),
        template: _.template($('#menu-list-item').html()),

        initialize: function() {
            this.model.bind("reset", this.render, this);
        },
        render: function(eventName) {
            _.each(this.model.models, function(menu){
                var menuTemplate = this.template(menu.toJSON());
                $(this.el).append(menuTemplate);
            }, this);

            return this;
        }

    });

    return MenuListView;

});
