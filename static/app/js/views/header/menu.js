/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'text!templates/header/menu.html'
], function (Marionette, HeaderTemplate) {

    return Marionette.ItemView.extend({
        template: HeaderTemplate
    });
});
