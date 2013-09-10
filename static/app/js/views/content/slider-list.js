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
        el: $('#center_head'),
        template: _.template($('#slider-list-item').html()),

        render: function(eventName) {
            _.each(this.model.models, function(steps){
                var stepsTemplate = this.template(steps.toJSON());
                $(this.el).append(stepsTemplate);
            }, this);

            return this;
        }

    });

});
