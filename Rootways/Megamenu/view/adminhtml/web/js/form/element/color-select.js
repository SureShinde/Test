define([
    'Magento_Ui/js/form/element/abstract',
    'mageUtils',
    'jquery',
    'jquery/colorpicker/js/colorpicker'
], function (Element, utils, $) {
    'use strict';

    return Element.extend({
        defaults: {
            visible: true,
            label: '',
            error: '',
            uid: utils.uniqueid(),
            disabled: false,
            links: {
                value: '${ $.provider }:data.my_color_picker'
            }
        },

        initialize: function () {
            this._super();
        },

        initColorPickerCallback: function (element) {
            var self = this;

            $(element).ColorPicker({
                onSubmit: function(hsb, hex, rgb, el) {
                    self.value(hex);
                    $(el).ColorPickerHide();
                },
                onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
                }
            }).bind('keyup', function(){
                $(this).ColorPickerSetColor(this.value);
            });
        }
    });
});
