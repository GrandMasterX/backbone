    /**
 * Created by AstraFit on 28.08.13.
 */
    define([
        'backboneMarionette',
        'text!templates/contacts/page.html'
    ], function (Marionette, ContactsTemplate) {

        return Marionette.ItemView.extend({
            template: ContactsTemplate
        });
    });
