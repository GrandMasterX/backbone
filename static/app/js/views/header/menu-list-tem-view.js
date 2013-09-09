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
    'views/header/menu_names',
    'models/menu-list',
    'jquery',
    'underscore',
    'backbone',

], function (Marionette,App, MenulistItemTpl, MenilistModel,$, _, Backbone) {

    var MenulistItemView = Marionette.ItemView.extend({
        el: $('#wineList'),
        tagName: "li",
        template: _.template($('menu-list-item').html()),
        render: function(eventName) {
            console.log(this.template);
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        }

    });

    return MenulistItemView;

});
