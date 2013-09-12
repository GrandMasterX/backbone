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

    return Backbone.View.extend({

        el: $('.main_brands_wrapper'),

        template: _.template($('#partners-list-item').html()),
        template1:_.template($('#partners-list-item1').html()),

        render: function(eventName) {
            _.each(this.model.models, function(brands,index){
                if(index%2==0) {
                    var partnersTemplate = this.template(brands.toJSON());
                } else {
                    var partnersTemplate = this.template1(brands.toJSON());
                }
                $(this.el).append(partnersTemplate);
            }, this);
            return this;
        }

    });

});
