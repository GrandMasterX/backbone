/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'models/menu',
    'backboneBUI',
    'collections/menu-list',
    'models/menu-list',
    'views/header/menu_list',
], function (Marionette, MenuModel, App, MenuListCollection, menuList, MenuListView) {

    return Backbone.View.extend({
        events:{
        },
        collection: MenuListCollection,

        initialize:function () {
            this.model = new menuList();
            var menuCollection = new this.collection();
            var menusView = new MenuListView({model: menuCollection});
            menuCollection.fetch();
            menuCollection.bind('reset', function () {
                menusView.render();
            });
        },

    });
});
