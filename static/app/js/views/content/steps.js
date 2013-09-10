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
    'text!templates/content/page.html',
    'collections/steps-list',
    'views/content/steps-list',
], function (Marionette, ContentTemplate, StepsCollectionList, StepsListView) {

    return Backbone.View.extend({

        events:{

        },

        collection: StepsCollectionList,

        initialize:function () {
            var stepsCollection = new this.collection();
            var stepsView = new StepsListView({model: stepsCollection});
            stepsCollection.fetch();
            stepsCollection.bind('reset', function () {
                stepsView.render();
            });
        },
    });
});
