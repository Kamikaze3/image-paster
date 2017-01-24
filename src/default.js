var resourceLink = "/file";

document.addEventListener('paste', function(e){
	if (e.clipboardData) {
		var items = e.clipboardData.items;
		if (items) {
			for (var i = 0; i < items.length; i++) {
				if (items[i].type.indexOf("image") !== -1) {
					var blob = items[i].getAsFile();
					var URLObj = window.URL || window.webkitURL;
					var source = URLObj.createObjectURL(blob);

					// Create new image
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

					// Upload the image
					var formData = new FormData(); 
					formData.append('file', blob);

					var xhr = new XMLHttpRequest();

					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4)
							console.log(xhr.responseText);
					};

					xhr.open('POST', resourceLink, true);
					xhr.setRequestHeader('X_FILENAME', blob.name);
					xhr.send(formData);
				}
			}
			e.preventDefault();
		}
	}
}, false);