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
    'text!templates/content/content.html'
], function (Marionette, ContentTemplate) {

    return Marionette.ItemView.extend({
        template: ContentTemplate
    });
});
