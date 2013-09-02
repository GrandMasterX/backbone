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
    'views/content/content'
], function (App, Router, FooterPageView,HeaderPageView,ContentPageView) {

    App.addInitializer(function() {
        /* render footer page */
        var footerPage = new FooterPageView();
        var headerPage = new HeaderPageView();
        var contentPage = new ContentPageView();
        App.footerRegion.show(footerPage);
        App.menuRegion.show(headerPage);
        App.pageRegion.show(contentPage);
    });

    /* attach router to the app */
    App.router = Router;

    App.start();

    Backbone.history.start();
    $('a').click(function(){
        $('html, body').animate({
            scrollTop: $( $(this).attr('href') ).offset().top
        }, 0);
        return false;
    });
    $(document).on("click", "a[href]:not([data-bypass])", function(evt) {
        // Get the absolute anchor href.
        var href = { prop: $(this).prop("href"), attr: $(this).attr("href") };
        // Get the absolute root.
        var root = location.protocol + "//" + location.host + App.root;

        // Ensure the root is part of the anchor href, meaning it's relative.
        if (href.prop.slice(0, root.length) === root) {
            // Stop the default event to ensure the link will not cause a page
            // refresh.
            evt.preventDefault();

            // `Backbone.history.navigate` is sufficient for all Routers and will
            // trigger the correct events. The Router's internal `navigate` method
            // calls this anyways.  The fragment is sliced from the root.
            Backbone.history.navigate(href.attr, true);
        }
    });
});
