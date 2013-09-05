/**
 * UserModel object
 *
 * Resources taken from Sherago <not yet used in kmodeling>
 *
 */
define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone) {

    urlRoot: "api/wines",

    var MenuModel = Backbone.Model.extend({

    });


    var WineCollection = Backbone.Collection.extend({
        model: Wine,
        url: "api/wines"
    });

    return MenuModel;
});
