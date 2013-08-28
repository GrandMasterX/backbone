/**
 * Created by AstraFit on 28.08.13.
 */
/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'text!templates/service/page.html'
], function (Marionette, ServiceTemplate) {

    return Marionette.ItemView.extend({
        template: ServiceTemplate
    });
});
