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

    var ModalModel = Backbone.Model.extend({
        defaults:{
            name: null,
            email: null
        },

        /**
         * validation object
         * @see backbone.validation.js
         */
        validation: {
            name: {
                required: true,
                msg: 'name is required'
            },
            company: {
                required: true,
                msg: 'company is required'
            },
            site: {
                required: true,
                msg: 'site is required'
            },
            mail: {
                required: true,
                msg: 'mail is required'
            },
            shop: {
                required: true,
                msg: 'shop is required'
            }
        },

        urlRoot: 'api/main'
    });

    return ModalModel;
});
