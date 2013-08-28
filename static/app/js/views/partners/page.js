/**
 * Created by AstraFit on 28.08.13.
 */
define([
    'backboneMarionette',
    'text!templates/partners/page.html'
], function (Marionette, PartnersTemplate) {

    return Marionette.ItemView.extend({
        template: PartnersTemplate
    });
});
