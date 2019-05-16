(function($){

    window.App = window.App || {};
    App.Widgets = App.Widgets || {};
    App.Ctrl = App.Ctrl || {};
    App.CtrlInstances = App.CtrlInstances || {};
    App.Locale = App.Locale || {};


    var Application = can.Control.extend(
        {
        },
        {
            init: function () {
            },

            bootstrap: function () {
                var method;

                for (method in this) {
                    if (method.length > 4 && method.substr(0, 4) === 'init') {
                        this[method]();
                    }
                }

                can.route.ready();
            },

            /**
             * Навешивает контроллер на DOM элемент и возвращает его instance
             * @param selector
             * @param controllerName
             * @param settings
             * @returns {*}
             */
            installController: function (selector, controllerName, settings) {
                settings = settings || {};
                App.CtrlInstances[controllerName] = this.element.find(selector)[controllerName](settings).control(controllerName);
                return App.CtrlInstances[controllerName];
            },

            initCustomComponents: function () {

            },

            initWidgets: function () {
                this.element.find('[data-app-controller]').each(this.proxy(function (i, el) {
                    var $el = $(el),
                        ctrl = $el.data('app-controller'),
                        opts = $el.data('app-options');

                    this.installController($el, ctrl, opts);
                }));
            }
        }
    );


    $(function(){
        window.application = new Application('html');
        window.application.bootstrap();
    });

}(jQuery));


window.dbg = function () {
    console.log.apply(console, arguments);
};
