document.addEventListener('paste', function(e){
	if (e.clipboardData) {
		console.log(e.clipboardData);
		var items = e.clipboardData.items;
		if (items) {
			paste_event_support = true;
			//access data directly
			for (var i = 0; i < items.length; i++) {
				if (items[i].type.indexOf("image") !== -1) {
					//image
					var blob = items[i].getAsFile();
					var URLObj = window.URL || window.webkitURL;
					var source = URLObj.createObjectURL(blob);
					paste_createImage(source);
				}
			}
			e.preventDefault();
		}
	}
}, false);

function paste_createImage(source) {
	var pastedImage = new Image();
	pastedImage.onload = function () {
		var canvas = document.createElement('canvas');
		document.body.appendChild(canvas);

		canvas.width = pastedImage.width;
		canvas.height = pastedImage.height;
		canvas.style = "border:1px solid grey;";
		canvas.getContext('2d').drawImage(pastedImage, 0, 0);
	};
	pastedImage.src = source;
};
