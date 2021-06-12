(function($, window, document, undefined) {

    'use strict';

    var defaults = {};

    var Delete = function(element) {

        // You can access all lightgallery variables and functions like this.
        this.core = $(element).data('lightGallery');

        this.$el = $(element);
        this.core.s = $.extend({}, defaults, this.core.s)

        this.init();

        return this;
    }

    Delete.prototype.init = function() {
        var deleteIcon = '<span id="lg-clear" class="lg-icon deletePicture"><span class="glyphicon glyphicon-trash"></span></span>';
        this.core.$outer.find('.lg-toolbar').append(deleteIcon);

        this.delete();

    };


    Delete.prototype.delete = function() {
        var that = this;
        this.core.$outer.find('.deletePicture').on('click', function() {
            var imgEl =  $(that.core.$el.children()[that.core.index]).find(".img-thumbnail");
            var key = imgEl.data("key");
            //var param = imgEl.data("param");
            var flag = false;
            if(key !="" && typeof key !="undefined")
            {

                $.ajax({
                    async: false,
                    type: "POST",
                    url: key,
                    //data: param,
                    //url: "delete-gallery-file?id="+key,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (response) {
                        if(response.success)
                        {
                            flag = true;
                        }
                        if(response.error)
                        {
                            alert(response.msg);
                        }
                    }
                });
                
            }
            if(flag == false){
                return false;
            } 
            var elements;
            if (that.core.s.dynamic) {
                elements = that.core.s.dynamicEl;
            } else {
                if (that.core.s.selector === 'this') {
                    elements = that.core.$el;
                } else if (that.core.s.selector !== '') {
                    if (that.core.s.selectWithin) {
                        elements = jQuery(that.core.s.selectWithin).find(that.core.s.selector);
                    } else {
                        elements = that.core.$el.find(jQuery(that.core.s.selector));
                    }
                } else {
                    elements = that.core.$el.children();
                }
            }
            that.core.modules.Thumbnail.destroy();

            elements.splice(that.core.index, 1);

            if (!that.core.s.dynamic) {
                
                that.core.$el.children()[that.core.index].remove();
                that.core.$items.splice(that.core.index, 1);
            }

            that.core.$slide.splice(that.core.index, 1);
            that.core.$outer.find('.lg-inner').children()[that.core.index].remove();

            if (elements.length > 0) {
                that.core.index--;
                that.core.goToNextSlide();

                if (that.core.s.counter)
                    $('#lg-counter-all').text(elements.length);

                if (elements.length == 1)
                    that.core.$outer.find('.lg-actions').remove();

                that.core.modules.Thumbnail = new $.fn.lightGallery.modules.Thumbnail(that.core.$el);
            } else
                that.core.destroy();

        });
    }

    /**
     * Destroy function must be defined.
     * lightgallery will automatically call your module destroy function
     * before destroying the gallery
     */
    Delete.prototype.destroy = function() {

    }

    // Attach your module with lightgallery
    $.fn.lightGallery.modules.delete = Delete;


})(jQuery, window, document);