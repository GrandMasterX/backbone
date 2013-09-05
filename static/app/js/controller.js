/**
 * Application controller
 *
 * @author GrandMaster zgrandmasterz@gmail.com
 */
define([
    'backboneMarionette',
    'http',
    'app',
    'session'
], function(Marionette, Http, App) {
    'use strict';

    return {
        /* renders error page with correspondent failure number */
        goto_error: function (actions) {
            require(['views/error/page'], function(ErrorPage){
                if(Http.isUnAuthorized(actions)) {
                    App.router.navigate('index', {trigger:true});
                    return false;
                }
                var description = Http.getStatusDescription(actions) || 'Unknown';
                var errorPage = new ErrorPage({model: new Backbone.Model({number:actions, description:description})});
                App.pageRegion.show(errorPage);
            });
        },
        /* renders index page - load main page*/
        goto_index: function() {
            require(['views/content/content'], function(IndexPage){
                var indexPage = new IndexPage();
                App.pageRegion.show(indexPage);
            })

        },
        /* renders about service page */
        goto_service: function() {
            require(['views/service/page'], function(ServicePage){
                var servicePage = new ServicePage();
                App.pageRegion.show(servicePage);
            });
        },
        /* renders dashboard */
        goto_howitworks: function() {

            require(['views/how_it_works/page'], function(HowitworksPage){
                var howitworksPage = new HowitworksPage();
                App.pageRegion.show(howitworksPage);
            });
        },
        /* renders dashboard */
        goto_partners: function() {

            require(['views/partners/page'], function(PartnersPage){
                var partnersPage = new PartnersPage();
                App.pageRegion.show(partnersPage);
            });
        },
        /* renders dashboard */
        goto_contacts: function() {

            require(['views/contacts/page'], function(ContactsPage){
                var contactsPage = new ContactsPage();
                App.pageRegion.show(contactsPage);
            });
        },
        /* triggers not found error/404 when page is not found */
        goto_notFound: function() {
            App.router.navigate('error/404', {trigger: true});
        }
    }
});