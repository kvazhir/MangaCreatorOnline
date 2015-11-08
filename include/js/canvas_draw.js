window.canv = {};

var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // At least Safari 3+: "[object HTMLElementConstructor]"
var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
var isNotABrowser = /*@cc_on!@*/false || !!document.documentMode; // At least IE6

// var xpos = $('#canvas').offset().left;
// var ypos = $('#canvas').offset().top;
if(isFirefox)
	$(document).ready(function(){
		$(this).scrollTop(0);
		document.getElementById('canvas').getClientRects();
		window.xypos = document.getElementById('canvas').getBoundingClientRect();
	})


canv.init = function(){
	var self = this;
	// alert(document.location.pathname.split('/')[3]);
	this.canvas = document.getElementById("canvas");
	this.ctx = canvas.getContext("2d");
	this.height = canvas.height;
	this.width = canvas.width;
	// console.log(this.height);

	this.imageObj = new Image();
	if(/^\/manga\/draw\/(\d)+$/i.test(document.location.pathname)){
		$.post('/include/async/get_manga.php', {id:document.location.pathname.split('/')[3]}, function(data){
			self.imageObj.src = data;
		});
	}
	// alert(window.data_url);
	// this.imageObj.src = self.data;
	this.imageObj.onload = function(){
		self.renderImage(self.ctx, self.imageObj);
	}
	// window.originalImage = this.canvas.toDataURL();
	// console.log(window.originalImage);

	// this.colorButton = document.getElementById("submitColor");
	//this.draw(this.ctx);
	//this.makeRect(this.ctx);
	//this.makeCircle(this.ctx);
	//this.drawGradients(this.ctx);
	//this.writeText(this.ctx);
	/* this.canvas.onclick = function(e){
		console.log(e.offsetX, e.offsetY);
		self.drawRandomCircle(e.offsetX, e.offsetY, self.ctx);
	}
	*/
		//self.ctx.moveTo(0, 0);
	self.test;
	this.canvas.onmousedown = function(e){
		//this.test = !this.test;
		self.ctx.beginPath();
		// self.ctx.strokeStyle = 'rgba(0,0,0,0.1)';
		self.test = true;
		if(isFirefox) // this works for Firefox
		{
			xpos = e.pageX - window.xypos.left;
			ypos = e.pageY - window.xypos.top;
			// xpos = e.pageX - $('#canvas').offset().left;
			// ypos = e.pageY - $('#canvas').offset().top;

		} else		// works in Google Chrome
		{
			xpos = e.offsetX;
			ypos = e.offsetY;
		}
		self.movePointer(xpos, ypos, self.ctx);
		// console.log('MouseDown');
	}

	this.canvas.onmouseup = function(){
		//this.test = !this.test;
		self.test = false;

		// console.log(canvas.toDataURL());
		// console.log('MouseUp');
		//self.movePointer(e.offsetX, e.offsetY, self.ctx);

	}
	this.canvas.onmousemove = function(e){
		//console.log(e.offsetX, e.offsetY);
		/*if(arr)
			var arr = [e.offsetX, e.offsetY];*/
		if(isFirefox) // this works for Firefox
		{
			xpos = e.pageX - window.xypos.left;
			ypos = e.pageY - window.xypos.top;
		} else		// works in Google Chrome
		{
			xpos = e.offsetX;
			ypos = e.offsetY;
		}
		self.pen(xpos, ypos, self.ctx);//, arr[0], arr[1]);

	}

	// this.colorButton.onclick = function(){
	// 	var color = document.getElementById("color").value;
	// 	// console.log(color);
	// 	self.changeColor(color, self.ctx);
	//
	// }

	// document.getElementById("color").onkeypress = function(e){
	// 	console.log(e);
	// 	if (e.keyCode=='13') {
	// 		var color = document.getElementById("color").value;
	// 		// console.log(color);
	// 		self.changeColor(color, self.ctx);
	//
	// 	}
	//
	// }

}

canv.renderImage = function(ctx, imageObj){
	ctx.drawImage(imageObj, 0, 0);
}

canv.changeColor = function(color, ctx){
	ctx.beginPath();
	ctx.strokeStyle = color;

}

canv.pen = function(x, y, ctx){
	// ctx.beginPath();
	//ctx.moveTo(x, y);
	//console.log(this.test, x, y);
	if(this.test){
		// ctx.beginPath();
		// ctx.strokeStyle = 'rgba(0,0,0,0.1)';
		ctx.lineTo(x, y);
		//ctx.closePath();
		ctx.stroke();
		//ctx.closePath();
	}
}

canv.movePointer = function(x, y, ctx){
	//if(test){
	//ctx.beginPath();
	//this.test = !this.test;
	ctx.moveTo(x, y);

	/* }
	else{
		ctx.closePath();
	} */
	// console.log('moved successfully');
	//ctx.stroke();
}

canv.drawRandomCircle = function(x, y, ctx){
	var size = Math.random() * 50;
	var r = Math.floor(Math.random() * 255);
	var g = Math.floor(Math.random() * 255);
	var b = Math.floor(Math.random() * 255);
	ctx.beginPath();
	ctx.arc(x, y, size, 0, 2 * Math.PI, false);
	ctx.fillStyle = "rgb("+r+","+g+","+b+")";
	ctx.fill();
	ctx.closePath();
}

canv.writeText = function(ctx){
	//NOPE ctx.beginPath();
	ctx.font = "Bold 43px 'Old English Text MT'";
	ctx.textAlign = "right";		//BS
	ctx.textBaseline = "bottom";		//BS
	// console.log(ctx.measureText("Potatoes"));
	ctx.fillText("Hello World!", 250, 250);

}

canv.makeCircle = function(ctx){
	ctx.beginPath();
	ctx.arc(250, 250, 100, 0, 1.5 * Math.PI);//, true); //(optional, false = clockwise, true = counterclockwise
	ctx.lineTo(250, 250);
	ctx.closePath();
	ctx.stroke();


}

canv.drawGradients = function(ctx){
	ctx.beginPath();
	ctx.rect(100, 10, this.width - 200, 200);
	var grad = ctx .createLinearGradient(
	300, 10, this.width - 200, 0
	);


	ctx.closePath();
	grad.addColorStop(0, "red");
	grad.addColorStop(1, "black");
	ctx.fillStyle = grad;
	ctx.fill();

	ctx.beginPath();
	ctx.rect(
	100, 300, 300, 150
	);

	var radGrad = ctx.createRadialGradient(
	250, 370, 150, 250, 370, 100
	);

	ctx.closePath();
	radGrad.addColorStop(0, "red");
	radGrad.addColorStop(1, "black");
	ctx.fillStyle = radGrad;
	ctx.fill();

}

canv.makeRect = function(ctx){
	ctx.beginPath();
	ctx.rect(100, 200, 100, 200);
	ctx.fillStyle = "gray";
	ctx.lineWidth = 3;
	ctx.stroke();
	ctx.fill();

	ctx.closePath();

}

canv.draw = function(ctx){
	ctx.beginPath();
	ctx.strokeStyle = "red";
	ctx.lineWidth = 6;
	//ctx.lineCap = "round";
	//ctx.lineJoin = "round";
	ctx.moveTo(200, 300);
	ctx.lineTo(400, 300);
	ctx.lineTo(400, 500);
	ctx.stroke();
	ctx.closePath();
}
