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
    'models/menu-list'
], function ($, _, Backbone,MenuListModel) {

    var MenulistAllModel = Backbone.Model.extend({

        model: MenuListModel,
        url: 'http://localhost/my_git/site/Getmenu',

        constructor: function() {
            this.model = new MenuListModel();
            Backbone.Model.apply(this, arguments);
        },

        parse: function(data, options) {
            this.model.reset(data.model);
            return data.MenulistAllModel;
        }

    });

    return MenulistAllModel;
});
