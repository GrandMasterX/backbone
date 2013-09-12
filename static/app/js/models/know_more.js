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
    'libs/backbone/backbone.validation'
], function($, _, Backbone) {

    return Backbone.Model.extend({
        defaults:{
            email: null
        },

        validation: {
            mail: {
                required: true,
                msg: 'mail is required'
            },
        },

        //urlRoot: 'api/main'
    });
});
