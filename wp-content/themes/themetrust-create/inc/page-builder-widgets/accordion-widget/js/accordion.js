
jQuery(function ($) {

    $('.ct-accordion').each(function () {

        var accordion = $(this);

        new Create_Accordion(accordion);

    });

});

var Create_Accordion = function (accordion) {

    // toggle elems
    this.panels = accordion.find('.ct-panel');

    this.toggle = false;

    if (accordion.data('toggle') == true)
        this.toggle = true;

    this.current = null;

    // init events
    this.initEvents();
};

Create_Accordion.prototype.show = function (panel) {

    if (this.toggle) {
        if (panel.hasClass('ct-active')) {
            this.close(panel);
        }
        else {
            this.open(panel);
        }
    }
    else {
        // if the panel is already open, close it else open it after closing existing one
        if (panel.hasClass('ct-active')) {
            this.close(panel);
            this.current = null;
        }
        else {
            this.close(this.current);
            this.open(panel);
            this.current = panel;
        }
    }

};

Create_Accordion.prototype.close = function (panel) {

    if (panel !== null) {
        panel.children('.ct-panel-content').slideUp(300);
        panel.removeClass('ct-active');
    }

};

Create_Accordion.prototype.open = function (panel) {

    if (panel !== null) {
        panel.children('.ct-panel-content').slideDown(300);
        panel.addClass('ct-active');
    }

};


Create_Accordion.prototype.initEvents = function () {

    var self = this;

    this.panels.find('.ct-panel-title').click(function (event) {

        event.preventDefault();

        var panel = jQuery(this).parent();

        self.show(panel);
    });
};

