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
    'text!templates/header/menu-list.html',
    'models/menu-list',
    'jquery',
    'underscore',
    'backbone',
], function (Marionette,App, MenulistView,MenulistModel,$, _, Backbone) {

    var MenulistView = Marionette.ItemView.extend({
        template: MenulistView,

        tagName:'ul',

        events:{
            //'click a' : 'main'
        },

        initialize:function () {
            this.model = new MenulistModel();
            this.model.bind("reset", this.render, this);
            var self = this;
            this.model.bind("add", function (MenulistModel) {
                $(self.el).append(new MenulistView({model:MenulistModel}).render().el);
            });
        },
        render:function (e) {
            _.each(this.model.models, function (MenulistModel) {
                $(this.el).append(new MenulistView({model:MenulistModel}).render().el);
            }, this);
            return this;
        },

    });

    return MenulistView;

});
