/**
 * Created by AstraFit on 28.08.13.
 */
/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'views/service/service-list',
    'collections/service-list'
], function (Marionette, ServiceListView, ServiceCollectionList) {

    return Backbone.View.extend({

        events:{

        },

        collection: ServiceCollectionList,

        initialize:function () {
            var seviceCollection = new this.collection();
            var serviceView = new ServiceListView({model: seviceCollection});
            seviceCollection.fetch();
            seviceCollection.bind('reset', function () {
                serviceView.render();
            });
        },
    });
});
