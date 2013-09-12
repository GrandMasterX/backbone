/**
 * Application controller
 *
 * @author GrandMaster zgrandmasterz@gmail.com
 */
define([
    'backboneMarionette',
    'http',
    'app',
    'session',
    'collections/menu-list',
], function(Marionette, Http, App,MenulistCollection) {
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
            require(['views/content/slider','views/content/steps','views/content/content'], function(sliderPageView,StepsPageView,ModalPageView){
                $('#center_head,#steps').html('');
                var sliderPage = new sliderPageView();
                var stepsPage = new StepsPageView();
                var modalPage = new ModalPageView();
                var bg_image = $('.menu').find('li:eq(0)');
                $('.main_page_bg').animate({opacity: 1},3000);

                /*$('.menu a').click(function(e){
                    if(e.target !== bg_image.find('a')[0]) {
                        if($('.wrapper ').hasClass('main_page_bg'))
                            $('.wrapper ').removeClass('main_page_bg');
                    } else {
                        if(!$('.wrapper ').hasClass('main_page_bg'))
                            $('.wrapper ').addClass('main_page_bg');
                    }
                });*/
            })

        },
        /* renders about service page */
        goto_service: function() {
            require(['views/service/service'], function(ServicePage){
                $('#center_head,#steps').html('');
                var servicePage = new ServicePage();
                //App.pageRegion.show(servicePage);
                $('.main_page_bg').css({'opacity' : '0'});
            });
        },
        /* renders dashboard */
        goto_howitworks: function() {

            require(['views/how_it_works/page'], function(HowitworksPage){
                $('#center_head,#steps').html('');
                var howitworksPage = new HowitworksPage();
                App.pageRegion.show(howitworksPage);
                $('.main_page_bg').css({'opacity' : '0'});
            });
        },

        goto_partners: function() {
            require(['views/partners/brends_list'], function(BrendsPage){
                new BrendsPage();
            });
        },
        /* renders dashboard */
        goto_contacts: function() {

            require(['views/contacts/page'], function(ContactsPage){
                $('#center_head,#steps').html('');
                var contactsPage = new ContactsPage();
                App.pageRegion.show(contactsPage);
                $('#steps,.main_page_bg').hide();
                $('.main_page_bg').css({'opacity' : '0'});
            });
        },
        /* triggers not found error/404 when page is not found */
        goto_notFound: function() {
            App.router.navigate('error/404', {trigger: true});
        }
    }
});