/**
 * Created by AstraFit on 28.08.13.
 */
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
    'text!templates/how_it_works/page.html'
], function (Marionette, HowitworksTemplate) {

    return Marionette.ItemView.extend({
        template: HowitworksTemplate
    });
});
