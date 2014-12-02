/**
 * This file is part of AntoineK_Slider for Magento.
 *
 * @license All rights reserved
 * @author Antoine Kociuba <antoine.kociuba@gmail.com>
 * @category AntoineK
 * @package AntoineK_Slider
 * @copyright Copyright (c) 2014 Antoine Kociuba (http://www.antoinekociuba.com)
 */

Window.keepMultiModalWindow = true;
var sliderAjaxFormPopup = Class.create({
    overlayShowEffectOptions : null,
    overlayHideEffectOptions : null,
    initialize: function(name) {
        this.slideFormId = 'slide_edit_form';
        this.varienForm = null;
        this.popupId = 'slider-slide-form';

        this.window = null;
        this.global = window;
        if(typeof name != 'undefined')
            this.global[name] = this;

        this.messages = {
            newTitle: 'Add Slide',
            editTitle: 'Edit Slide',
            deleteConfirmMessage: 'Are you sure you want to delete this slide?',
            errorMessage: 'An error occurred'
        };
        document.observe('dom:loaded', this.translateMessages.bind(this));
    },
    open : function(formUrl, sliderId, slideId) {
        if (formUrl) {
            new Ajax.Request(formUrl, {
                parameters: {
                    slider_id: sliderId,
                    slide_id: slideId
                },
                onSuccess: function(transport) {
                    try {
                        // Open dialog with ajax response content
                        this.openDialogWindow(transport.responseText, sliderId, slideId);
                    } catch(e) {
                        alert(e.message);
                    }
                }.bind(this)
            });
        }
    },
    deleteSlide : function(button, formUrl, slideId) {
        if ( confirm(this.messages.deleteConfirmMessage) ) {
            if (formUrl) {
                new Ajax.Request(formUrl, {
                    parameters: {
                        id: slideId
                    },
                    onLoading: function(){
                        try {
                            // Disable delete button
                            $(button).addClassName('disabled').writeAttribute('disabled', 'disabled');
                        } catch(e) {
                            alert(e.message);
                        }
                    },
                    onSuccess: function(transport) {
                        try {
                            // Reload the grid
                            if(typeof slide_gridJsObject != 'undefined'){
                                slide_gridJsObject.resetFilter();
                            }
                        } catch(e) {
                            alert(e.message);
                        }
                    },
                    onFailure: function (transport) {
                        try {
                            // Enable delete button
                            $(button).removeClassName('disabled').removeAttribute('disabled');
                            // Display error message
                            var jsonReponse = transport.responseJSON;
                            if(jsonReponse && jsonReponse.error){
                                alert(jsonReponse.error);
                            }else{
                                alert(popupObject.messages.errorMessage);
                            }
                        } catch(e) {
                            alert(e.message);
                        }
                    }
                });
            }
        }
        return false;
    },
    openDialogWindow : function(content, sliderId, slideId) {
        this.overlayShowEffectOptions = Windows.overlayShowEffectOptions;
        this.overlayHideEffectOptions = Windows.overlayHideEffectOptions;
        Windows.overlayShowEffectOptions = {duration:0};
        Windows.overlayHideEffectOptions = {duration:0};

        Dialog.confirm(content, {
            draggable:true,
            resizable:true,
            closable:true,
            className:"magento",
            windowClassName:"popup-window",
            title:(typeof slideId == 'undefined' || slideId === null ? this.messages.newTitle : this.messages.editTitle),
            width:950,
            height:'auto',
            zIndex:1000,
            recenterAuto:false,
            hideEffect:Element.hide,
            showEffect:Element.show,
            id:this.popupId,
            buttonClass:"form-button",
            okLabel:"Submit",
            ok: this.okDialogWindow.bind(this),
            cancel: this.closeDialogWindow.bind(this),
            onClose: this.closeDialogWindow.bind(this)
        });

        content.evalScripts.bind(content).defer();
    },
    okDialogWindow : function(dialogWindow) {

        // Initialize current varienForm instance
        if (typeof this.varienForm == 'undefined' || this.varienForm == null) {
            this.varienForm = new varienForm(this.slideFormId);
            this.varienForm.submit = function(popupObject) {

                // If form validation passed
                if (this.validator.validate()) {
                    var form = $(this.formId);
                    var url = form.action;

                    // Ajax form submission
                    new Ajax.Request(url, {
                        onLoading: function(){
                            try {
                                // Disable submit button
                                $$('#slider-slide-form .ok_button')[0].addClassName('disabled').writeAttribute('disabled', 'disabled');
                            } catch(e) {
                                alert(e.message);
                            }
                        },
                        onSuccess: function(transport) {
                            try {
                                // Close the dialog
                                popupObject.closeDialogWindow(dialogWindow);
                                // Reload the grid
                                if(typeof slide_gridJsObject != 'undefined'){
                                    slide_gridJsObject.resetFilter();
                                }
                            } catch(e) {
                                alert(e.message);
                            }
                        },
                        onFailure: function (transport) {
                            try {
                                // Enable submit button
                                $$('#slider-slide-form .ok_button')[0].removeClassName('disabled').removeAttribute('disabled');
                                // Display error message
                                var jsonReponse = transport.responseJSON;
                                if(jsonReponse && jsonReponse.error){
                                    alert(jsonReponse.error);
                                }else{
                                    alert(popupObject.messages.errorMessage);
                                }
                            } catch(e) {
                                alert(e.message);
                            }
                        },
                        parameters: form.serialize(true)
                    });
                }
            }.bind(this.varienForm);
        }

        this.varienForm.submit(this);
    },
    closeDialogWindow : function(dialogWindow) {

        // Destroy current varienForm instance
        this.varienForm = null;

        // Close dialog
        dialogWindow.close();
        Windows.overlayShowEffectOptions = this.overlayShowEffectOptions;
        Windows.overlayHideEffectOptions = this.overlayHideEffectOptions;
    },
    translateMessages: function() {
        if(typeof Translator != 'undefined' && Translator) {
            for(var line in this.messages) {
                this.messages[line] = Translator.translate(this.messages[line]);
            }
        }
    }
});

new sliderAjaxFormPopup('sliderAjaxFormPopup');