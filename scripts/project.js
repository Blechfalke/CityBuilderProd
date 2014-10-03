(function (project, $, undefined){
	 project.createDialog = function (url, text, picture, width, height) {
		 var dialogId = 'dialog_' + project.guid();
     var dialog = $('#' + dialogId);
     if ($('#' + dialogId).length == 0) {
         dialog = $('<div id="' + dialogId + '" style="display:none;"></div>').appendTo('body');
     }
     var options = {
         close: function (event, ui) {
             dialog.remove();
         },
         modal: true,
         position: {
        	 my: "center", at: "center", of: window        	 
         },
         width: width,
         height: height,
         resizable: false,
         draggable: false,
         buttons: {
            /* 'Continue': function () {
                 $(this).dialog('close');
             }*/
         }
     };
     $('a').css('cursor', 'progress');
     $('body').css('cursor', 'progress');
     var createdDialog = dialog.dialog(options);
     var urlWithParams = url;
     localStorage.setItem('text', text);
     localStorage.setItem('pic', picture);
     dialog.load(
         urlWithParams,
         function () {
             $('.ui-dialog :button').blur();
             $('a').css('cursor', 'pointer');
             $('body').css('cursor', 'auto');
         }
     );
     return createdDialog;
};
	project.guid = function () {
	    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
	        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
	        return v.toString(16);
	    });
	};
project.alert = function (text) {
	var dialogId = 'dialog_' + project.guid();
    var dialog = $('#' + dialogId);
    if ($('#' + dialogId).length == 0) {
        dialog = $('<div id="' + dialogId + '" style="display:none;"></div>').appendTo('body');
    }
    var options = {
        close: function (event, ui) {
            dialog.remove();
        },
        modal: true,
        position: {
       	 my: "center", at: "center", of: window        	 
        },
        width: 500,
        height: 150,
        draggable: false,
        resizable: false       
    };
    $('a').css('cursor', 'progress');
    $('body').css('cursor', 'progress');
    var createdDialog = dialog.dialog(options);
    var urlWithParams = 'view/alert.html';
    localStorage.setItem('alert', text);
    dialog.load(
        urlWithParams,
        function () {
            $('.ui-dialog :button').blur();
            $('a').css('cursor', 'pointer');
            $('body').css('cursor', 'auto');
        }
    );
    return createdDialog;
};
}(window.project = window.project || {}, jQuery));