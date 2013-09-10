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
    'collections/slider-list',
    'views/content/slider-list',
], function (Marionette, SliderCollectionList, SliderListView) {

    return Backbone.View.extend({

        events:{

        },

        collection: SliderCollectionList,

        initialize:function () {
            var SliderCollectionList = new this.collection();
            var sliderView = new SliderListView({model: SliderCollectionList});
            SliderCollectionList.fetch();
            SliderCollectionList.bind('reset', function () {
                sliderView.render();
            });
        },
    });
});
