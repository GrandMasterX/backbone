/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'text!templates/header/menu.html',
    'models/menu',
    'backboneBUI',
    'collections/menu-list',
    'views/header/menu-list-all',
    'models/menu-list'
], function (Marionette, HeaderTemplate, MenuModel, App, MenulistCollection,MenulistItemView, menuList) {

    return Marionette.ItemView.extend({
        template: HeaderTemplate,
        events:{
            'click a' : 'main'
        },

        initialize:function () {
            //_.bindAll(this, 'logout', 'checkAuth', 'error');


            // setup global events
            //App.vent.on('site:logout', this.logout, this);
            this.model = new menuList();
            this.before();
            //console.log(this.model);
            //this.model.on('error', this.error);
            //this.model.on('success', this.success);

            // fire checkAuth event when the attribute authenticated of
            // the LoginModel has been changed
            //this.model.on('change:authenticated', this.checkAuth);

        },
         main: function(e) {
            this.model.url = 'http://localhost/my_git/site/Getmenu';
            this.model.save('data');
        },

        before:function (callback) {
            var that = this;
            that.model = new menuList();
            if (this.menuList) {
                if (callback) callback();
            } else {
                that.menuList = new MenulistCollection(that.model);
                that.menuList.fetch(
                    {   success:function () {
                            console.log(that.menuList);
                            console.log(that.menuList.models[0].attributes);
                            console.log(that.menuList.models[1].attributes);
                            /*$('.allin').html(new MenulistItemView({model:that.menuList}).render());
                            if (callback)
                                callback();*/
                        }
                    }
                );
            }
        }

    });
});
