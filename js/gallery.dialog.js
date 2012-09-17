
(function($) {
   $.widget("ui.gallery_dialog",  {
     _init: function() {
       var self = this;
       if (!self.options.immediate) {
         this.element.click(function(event) {
           event.preventDefault();
           self._show($(event.currentTarget).attr("href"));
           return false;
         });
       } else {
         self._show(this.element.attr("href"));
       }
     },

     _show: function(sHref) {
       var self = this;
       var eDialog = '<div id="g-modal" tabindex="-1" role="dialog" aria-labelledby="g-modal-label" aria-hidden="true"></div>';

       if ($("#g-modal").length) {
         $("#g-modal").modal("hide");
       }
       $("body").append(eDialog);

       if (!self.options.close) {
         self.options.close = self.close_dialog;
       }
       $("#g-modal").modal(self.options);

       //$("#g-modal").gallery_show_loading();

       $.ajax({
         url: sHref,
         type: "GET",
         beforeSend: function(xhr) {
           // Until we convert to jquery 1.4, we need to save the XMLHttpRequest object so that we
           // can detect the mime type of the reply
           this.xhrData = xhr;
         },
         success: function(data, textStatus, xhr) {
           // Pre jquery 1.4, get the saved XMLHttpRequest object
           if (xhr == undefined) {
             xhr = this.xhrData;
           }
           var mimeType = /^(\w+\/\w+)\;?/.exec(xhr.getResponseHeader("Content-Type"));

           var content = "";
           if (mimeType[1] == "application/json") {
             data = JSON.parse(data);
	     content = data.html;
           } else {
             content = data;
           }

           $("#g-modal .modal-body").html(""+content+"");//.gallery_show_loading();

           if ($("#g-modal form").length) {
             self.form_loaded(null, $("#g-modal form"));
           }
           self._layout();

           $("#g-modal").modal("open");
           self._set_title();

           if ($("#g-modal form").length) {
             self._ajaxify_dialog();
           }
         }
       });
       $("#g-modal").dialog("option", "self", self);
     },

     _layout: function() {
       var dialogWidth;
       var dialogHeight = $("#g-modal").height();
       var cssWidth = new String($("#g-modal form").css("width"));
       var childWidth = cssWidth.replace(/[^0-9]/g,"");
       var size = $.gallery_get_viewport_size();
       if ($("#g-modal iframe").length) {
         dialogWidth = size.width() - 100;
         // Set the iframe width and height
         $("#g-modal iframe").width("100%").height(size.height() - 100);
       } else if ($("#g-modal .g-dialog-panel").length) {
         dialogWidth = size.width() - 100;
         $("#g-modal").dialog("option", "height", size.height() - 100);
       } else if (childWidth == "" || childWidth > 300) {
         dialogWidth = 500;
       }
       $("#g-modal").dialog('option', 'width', dialogWidth);
     },

     form_loaded: function(event, ui) {
       // Should be defined (and localized) in the theme
       MSG_CANCEL = MSG_CANCEL || 'Cancel';
       var eCancel = '<a href="#" class="g-cancel g-left">' + MSG_CANCEL + '</a>';
       if ($("#g-modal .submit").length) {
         $("#g-modal .submit").addClass("ui-state-default ui-corner-all");
         $.fn.gallery_hover_init();
         $("#g-modal .submit").parent().append(eCancel);
         $("#g-modal .g-cancel").click(function(event) {
           $("#g-modal").dialog("close");
           event.preventDefault();
         });
        }
       $("#g-modal .ui-state-default").hover(
         function() {
           $(this).addClass("ui-state-hover");
         },
         function() {
           $(this).removeClass("ui-state-hover");
         }
       );
     },

     close_dialog: function(event, ui) {
       var self = $("#g-modal").dialog("option", "self");
       if ($("#g-modal form").length) {
         self._trigger("form_closing", null, $("#g-modal form"));
       }
       self._trigger("dialog_closing", null, $("#g-modal"));
       $("#g-modal").dialog("destroy").remove();
     },

     _ajaxify_dialog: function() {
       var self = this;
       $("#g-modal form").ajaxForm({
         beforeSubmit: function(formData, form, options) {
           form.find(":submit")
             .addClass("btn-disabled")
             .attr("disabled", "disabled");
           return true;
         },
         beforeSend: function(xhr) {
           // Until we convert to jquery 1.4, we need to save the XMLHttpRequest object so that we
           // can detect the mime type of the reply
           this.xhrData = xhr;
         },
         success: function(data) {
           // Pre jquery 1.4, get the saved XMLHttpRequest object
           xhr = this.xhrData;
           if (xhr) {
             var mimeType = /^(\w+\/\w+)\;?/.exec(xhr.getResponseHeader("Content-Type"));

             var content = "";
             if (mimeType[1] == "application/json") {
               data = JSON.parse(data);
             } else {
               data = {"html": escape(data)};
             }
           } else {
             // Uploading files (eg: watermark) uses a fake xhr in jquery.form.js so
             // all we have is in the data field, which should be some very simple JSON.
             // Weirdly enough in Chrome the result gets wrapped in a <pre> element and
             // looks like this:
             //   <pre style="word-wrap: break-word; white-space: pre-wrap;">{"result":"success",
             //   "location":"\/~bharat\/gallery3\/index.php\/admin\/watermarks"}</pre>
             // bizarre.  Strip that off before parsing.
             data = JSON.parse(data.match("({.*})")[0]);
           }

           if (data.html) {
             $("#g-modal").html(data.html);
             $("#g-modal").dialog("option", "position", "center");
             $("#g-modal form :submit").removeClass("ui-state-disabled")
               .attr("disabled", null);
             self._set_title();
             self._ajaxify_dialog();
             self.form_loaded(null, $("#g-modal form"));
             if (typeof data.reset == 'function') {
               eval(data.reset + '()');
             }
           }
           if (data.result == "success") {
             if (data.location) {
               window.location = data.location;
             } else {
               window.location.reload();
             }
           }
         }
       });
     },

     _set_title: function() {
       // Remove titlebar for progress dialogs or set title
       if ($("#g-modal #g-progress").length) {
         $(".ui-dialog-titlebar").remove();
       } else if ($("#g-modal h1").length) {
         $("#g-modal").dialog('option', 'title', $("#g-modal h1:eq(0)").html());
         $("#g-modal h1:eq(0)").hide();
       } else if ($("#g-modal fieldset legend").length) {
         $("#g-modal").dialog('option', 'title', $("#g-modal fieldset legend:eq(0)").html());
       }
     },

     form_closing: function(event, ui) {},
     dialog_closing: function(event, ui) {}
   });

   $.extend($.ui.gallery_dialog,  {
     defaults: {
       autoOpen: false,
       autoResize: true,
       modal: true,
       resizable: false,
       position: "center"
     }
   });
})(jQuery);
