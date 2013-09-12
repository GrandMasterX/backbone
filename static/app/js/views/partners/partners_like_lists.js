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

        el: $('.bottom_faces'),

        template: _.template($('#partners-list-like-item').html()),

        render: function(eventName) {
            _.each(this.model.models, function(brands,index){
                var partnersTemplate = this.template(brands.toJSON());
                $(this.el).append(partnersTemplate);
            }, this);
            return this;
        }

    });

});
