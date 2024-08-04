
new function () {
	ajax = {
		post: function(url, data, callback) {
            if (url != '/api/admins/select_order_info'){
                if (typeof ld == 'undefined') {
                    var loader_overlay = loader.show('body');
                }
            }
			var excallback = function(data) {
				if (data.STATUS == 1) {
					loader.hide(loader_overlay);
					var message_array = [];
					for(var i in data.MESSAGE_ARRAY) {
						message_array[sizeof(message_array)] = data.MESSAGE_ARRAY[i].MESSAGE
					}
					var messages = implode("\n", message_array);
					$.alert({
						title: false,
						theme: 'white',
						content: messages,
						confirmButton: 'OK',
						confirmButtonClass: 'btn-info',
					});

				}
				else {
					loader.hide(loader_overlay);
					callback(data);
				}
			};
			var jqxhr = $.ajax({
				type:"post",
				url:url,
				data:data,
				timeout:120000,
				dataType: "json",
				success:excallback
			});
			return jqxhr;
		}
	}
}
