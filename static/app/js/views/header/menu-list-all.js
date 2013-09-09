define([
    'backboneMarionette',
    'backboneBUI',
    'text!templates/header/menu-list.html',
    'models/menu-list',
    'jquery',
    'underscore',
    'backbone',
    'views/header/menu-list-tem-view'
], function (Marionette,App, MenulistView,MenulistModel,$, _, Backbone, MenuListItemTpl) {

    var MenulistItemView = Backbone.View.extend({
        el: $('#menulist'),
        model: MenulistModel,
        template: MenuListItemTpl,

        initialize: function() {
            this.model.bind("reset", this.render, this);
        },
        render: function(eventName) {
            console.log(this.model.models);
            console.log(this.model.models.get('name'));
            _.each(this.model.models, function(model) {
                $(this.el).append(new this.template({model: model}).render().el);
            }, this);
            return this;
        }

    });

    return MenulistItemView;

});