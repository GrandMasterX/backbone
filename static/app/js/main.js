/**
 * main configuration file
 */
// Use ECMAScript 5 Strict Mode
"use strict";

// Define jQuery as AMD module
define.amd.jQuery = true;

// Require.js allows us to configure mappings to paths
// as demonstrated below:
// TODO: Load minified version of the libs or use Require.js's JS compiler (R)
require.config({
    paths:{

        /* jquery + jquery-ui + jquery-plugins*/
        jquery:[
            'https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min',
            'libs/jquery/jquery-1.8.0.min'
        ],

        /* underscore */
        underscore:'libs/underscore/underscore',
        underscoreString:'libs/underscore/underscore.string',

        /* backbone */
        backbone:'libs/backbone/backbone',
        backboneRelational:'libs/backbone/backbone-relational',
        backboneBinder:'libs/backbone/backbone.model-binder',
        backboneValidation:'libs/backbone/backbone.validation',
        backboneMarionette: 'libs/backbone/backbone.marionette',

        /* bui */
        backboneBUI:'libs/bui/backbone-bui',

        /* requirejs plugins*/
        text:'libs/require/text',
        domReady:'libs/require/domReady',

        /* utility libraries */
        json:'libs/utils/json2',
        stringFormat:'libs/utils/string-format', /* TODO: move away to the object that actually requires it */
        parser:'libs/utils/parser',
        session:'libs/utils/session',
        http:'libs/utils/http',
        /* a shortcut to have the templates outside of the js directory */
        templates:'../templates'
    },
    shim : {
        backbone : {
            exports : 'Backbone',
            deps : ['jquery','underscore']
        },
        backboneMarionette: {
            exports: 'Backbone.Marionette',
            deps: ['backbone']
        },
        backboneBUI: {
            deps: ['backbone']
        },
        underscore : {
            exports : '_'
        }
    },
    deps : ['jquery', 'underscore'],
    waitSeconds:15
})
;

// Let's kick off the application
// Let's kick off the application
require([
    'app',
    'router',
    'views/footer/footer',
    'views/header/menu',
    'views/content/content',
    'views/service/page',
    'views/how_it_works/page',
    'views/partners/page',
    'views/contacts/page',

], function (App, Router, FooterPageView,HeaderPageView,ContentPageView,ServicePageView,HowitworksPageView,PartnersPageView,ContactsPageView) {

    App.addInitializer(function() {
        /* render footer page */
        var footerPage = new FooterPageView();
        var headerPage = new HeaderPageView();
        var contentPage = new ContentPageView();
        var servicePage = new ServicePageView();
        var howitworksPage = new HowitworksPageView();
        var partnersPage = new PartnersPageView();
        var contactsPage = new ContactsPageView();
        App.footerRegion.show(footerPage);
        App.menuRegion.show(headerPage);
        App.pageRegion.show(contentPage);
        //App.serviceRegion.show(servicePage);
       // App.howitworksRegion.show(howitworksPage);
        //App.partnersRegion.show(partnersPage);
        //App.contactsRegion.show(contactsPage);
    });

    /* attach router to the app */
    App.router = Router;

    App.start();

    Backbone.history.start({pushState: true, root:'/my_git'});

});
