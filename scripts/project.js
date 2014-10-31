(function(project, $, undefined) {
	project.createDialog = function(url, text, picture, width, height) {
		var dialogId = 'dialog-' + project.guid();
		var dialog = $('#' + dialogId);
		if ($('#' + dialogId).length == 0) {
			dialog = $(
					'<div id="' + dialogId + '" style="display:none;"></div>')
					.appendTo('body');
		}
		var options = {
			close : function(event, ui) {
				dialog.remove();
			},
			modal : true,
			position : {
				my : "center",
				at : "center",
				collision: "flipfit",
				of : "#wrapper"
			},
			width : width,
			height : height,
			resizable : false,
			draggable : false
		};
		var createdDialog = dialog.dialog(options);
		localStorage.setItem('text', text);
		localStorage.setItem('pic', picture);
		dialog.load(url, function() {
			$('.ui-dialog :button').blur();
			$('a').css('cursor', 'pointer');
			$('body').css('cursor', 'auto');
		});
		return createdDialog;
	};
	// http://stackoverflow.com/questions/105034/how-to-create-a-guid-uuid-in-javascript
	project.guid = function() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g,
				function(c) {
					var r = Math.random() * 16 | 0, v = c == 'x' ? r
							: (r & 0x3 | 0x8);
					return v.toString(16);
				});
	};
	project.alert = function(text) {
		var dialogId = 'dialog-' + project.guid();
		var dialog = $('#' + dialogId);
		if ($('#' + dialogId).length == 0) {
			dialog = $(
					'<div id="' + dialogId + '" style="display:none;"></div>')
					.appendTo('body');
		}
		var options = {
			close : function(event, ui) {
				dialog.remove();
			},
			modal : true,
			position : {
				my : "center",
				at : "center",
				collision: "flipfit",
				of : "#wrapper"
			},
			width : 'auto',
			height : 'auto',
			draggable : false,
			resizable : false,
			buttons : {
				'Continue' : function() {
					$(this).dialog('close');
				}
			}
		};
		var inside = "<div  style='width:450px;margin:0 15px;' >"
				+ "<div id='alert' style='width:430px; background-color:white; border: 1px solid black;text-align:center;padding:10px;' >"
				+ text + "</div> </div>"
		dialog.html(inside);
		var createdDialog = dialog.dialog(options);
		return createdDialog;
	};
	project.confirm = function(text, buttonYes, buttonNo, target, targetArray) {
		var dialogId = 'dialog-' + project.guid();
		var dialog = $('#' + dialogId);
		if ($('#' + dialogId).length == 0) {
			dialog = $(
					'<div id="' + dialogId + '" style="display:none;"></div>')
					.appendTo('body');
		}
		var options = {
			close : function(event, ui) {
				dialog.remove();
			},
			modal : true,
			position : {
				my : "center",
				at : "center",
				collision: "flipfit",
				of : "#wrapper"
			},
			width : 'auto',
			height : 'auto',
			draggable : false,
			resizable : false,
			buttons : [ {
				text : buttonYes,
				click : function() {
					readInputs();

					$("#wrapper").load(target, targetArray);
					i_technology = null;
					$(this).dialog("close");
					$(".pageButtons").prop('disabled', true);
				}
			}, {
				text : buttonNo,
				click : function() {
					$(this).dialog("close");
				}
			} ]
		};
		var inside = "<div  style='width:450px;margin:0 15px;' >"
				+ "<div id='alert' style='width:430px; background-color:white; border: 1px solid black;text-align:center;padding:10px;' >"
				+ text + "</div> </div>"
		dialog.html(inside);
		var createdDialog = dialog.dialog(options);
		return createdDialog;
	};
}(window.project = window.project || {}, jQuery));