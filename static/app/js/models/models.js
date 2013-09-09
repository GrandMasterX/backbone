/**
 * LoginModel object
 *
 * Model containing the interactive data as well as a large part of the logic
 * surrounding it: conversions, validations, computed properties,
 * and access control of LoginModel.
 *
 * Here is where we need to setup logic with database
 *
 */
define([
    'backbone'
], function(Backbone) {

    return Backbone.Model.extend({

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
        }
    });

});

