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
    'collections/partners_like_list',
    'models/menu-list',
    'views/partners/partners_like_lists',
], function (Marionette, MenuModel, App, BrendsListCollection, menuList, BrendsListView) {

    return Backbone.View.extend({
        events:{

        },

        collection: BrendsListCollection,

        initialize:function () {
            var brendCollection = new this.collection();
            var brendsView = new BrendsListView({model: brendCollection});
            brendCollection.fetch();
            brendCollection.bind('reset', function () {
                brendsView.render();
            });
        },

    });
});
