window.canv = {};

var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // At least Safari 3+: "[object HTMLElementConstructor]"
var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
var isNotABrowser = /*@cc_on!@*/false || !!document.documentMode; // At least IE6


canv.init = function(){
	var self = this;

	this.canvas = document.getElementById("canvas");
	this.ctx = canvas.getContext('2d');
	this.height = canvas.height;
	this.width = canvas.width;
	this.buttons = document.getElementsByClassName("button");
	// this.drawBackground(this.ctx, "white");
	// this.drawGradients(this.ctx);
	// this.drawText(this.ctx);

	// this.canvas.onmousemove = function(e){
	// 	// console.log(e.offsetX, e.offsetY);

	// 	self.pen(e.offsetX, e.offsetY, self.ctx);
	// }
	// // // this.drawCircle(this.ctx);

	// this.canvas.onclick = function(e){
	// 	self.drawCircleOnClick(e.offsetX, e.offsetY, self. ctx);
	// }

	// this.draw(this.ctx);
	// this.makeRect(this.ctx);
	// this.makeCircle(this.ctx);
	// this.drawGradients(this.ctx);
	// this.writeText(this.ctx);
	// this.canvas.onclick = function(e){
	// 	self.drawRandomCircle(e.offsetX, e.offsetY, self.ctx);
	// }
	this.squaresArr = [];
	this.toBeDragged = [];
	
	this.mode = "create";
	// this.dragging = false;

	
	for (var i=0; i < this.buttons.length; i++) {
	  this.buttons[i].onclick = function(){
	  	self.mode = this.innerHTML.toLowerCase().trim();
	  }
	}

	canvas.onmousedown = function(e){
		if(isChrome){
			var xx = e.offsetX;
			var yy = e.offsetY;
		}else if(isFirefox){
			var xx = e.clientX;
			var yy = e.clientY;
		}
		  
		self.selectSquare(xx, yy);
		canvas.onmousemove = function(e){
			// var tx =  + (e.offsetX - eSelected.offsetX)
			if(isChrome){
				var xx = e.offsetX;
				var yy = e.offsetY;
			}else if(isFirefox){
				var xx = e.clientX;
				var yy = e.clientY;
			}

			self.drag(xx, yy);
		}

		canvas.onmouseup = function(){
			canvas.onmousemove = function(){
				return false
			}
			self.toBeDragged = [];
			// console.log(1);
		}
	}




	canvas.onclick = function(e){
		// console.log(e.clientX);
		if(isChrome){
			var xx = e.offsetX;
			var yy = e.offsetY;
		}else if(isFirefox){
			var xx = e.clientX;
			var yy = e.clientY;
		}
		self.createRandomSquareOnClick(xx, yy, self.ctx);
	}

	// canvas.onclick = function(e){
	// 	return false;
	// }
	// canvas.addEventListener("onclick", self.createRandomSquareOnClick.bind(null,event)(),false);
	// canvas.removeEventListener('onclick');

}

canv.drag = function(x, y){
	if(this.toBeDragged.length !== 0){
		for(j in this.toBeDragged){
			var mySquare = this.toBeDragged[j];
			mySquare.move(x - mySquare.size/2, y - mySquare.size/2);
			mySquare.render(x, y);
		}
	}
}

canv.createRandomSquareOnClick = function(xx, yy, ctx){
	// console.log(arguments[0]);
	if(this.mode === "create"){

		var randomHexColor = "#" + Math.floor(Math.random() * 16777215).toString(16);
		var size = 50;
		var squareRandomColor = new canv.Square(xx - size/2, yy - size/2, size, randomHexColor, ctx);
		squareRandomColor.render();
		// console.log(squareRandomColor)
		this.squaresArr.push(squareRandomColor);

	}
}

canv.selectSquare = function(x, y){
	// console.log("1ST CHECK",x, y);
	if(this.mode === "move"){

		for(i in this.squaresArr){
			var aX = this.squaresArr[i].x; //var asd={} <- how is this called?
			var aY = this.squaresArr[i].y;
			var aSize = this.squaresArr[i].size;
			// console.log(x, aX, aSize);
			if((x >= aX && x <= aX + aSize) && (y >= aY && y <= aY + aSize)){
				// this.squaresArr[i].move(0, 0);
				this.toBeDragged = [this.squaresArr[i]];
				console.log(this.squaresArr.indexOf(this.squaresArr[i]));
				console.log(this.squaresArr[i]);
			}
		}
	}
}

canv.render = function(){
	this.drawBackground(this.ctx, "white");
	for(key in this.squaresArr){
		this.squaresArr[key].render();
	}
}

canv.Square = function(x, y, size, color,ctx){
	this.x = x;
	this.y = y;
	this.size = size;
	this.color = color;
	this.ctx = ctx;
}

canv.Square.prototype.render = function(){
	this.ctx.beginPath();
	this.ctx.rect(this.x, this.y, this.size, this.size);
	this.ctx.fillStyle = this.color;
	this.ctx.fill();
	this.ctx.closePath();
}

canv.Square.prototype.move = function(newX, newY){
	var index = canv.squaresArr.indexOf(this);
	canv.squaresArr.splice(index, 1);
	this.x = newX;
	this.y = newY;
	canv.squaresArr.push(this);
	canv.render();
}



canv.drawRandomCircle = function(x, y, ctx){
	ctx.beginPath();
	ctx.fillStyle = "cyan";
	ctx.arc(x, y, 50, 0, Math.PI*2, false);
	ctx.fill();

	ctx.closePath();
}

canv.pen = function(x, y, ctx, oldX, oldY){
	ctx.beginPath();
	ctx.moveTo(x, y);
	// ctx.moveTo(this.width/2, this.width/2);
	ctx.lineTo(x+1, y+1);
	ctx.closePath();
	ctx.stroke();

}

canv.drawCircleOnClick = function(x, y, ctx){
	ctx.beginPath();
	var size = Math.random() * 50;
	var colorR = Math.floor(Math.random() * 255);
	var colorG = Math.floor(Math.random() * 255);
	var colorB = Math.floor(Math.random() * 255);
	var color = "rgba("+colorR+","+colorG+","+colorB+",1)"
	ctx.fillStyle = color;
	ctx.arc(x, y, size, 0, 2 * Math.PI, false);
	ctx.fill();
	ctx.closePath();
}

canv.clearCanvas = function(){
	this.ctx.clearRect(0, 0, this.width, this.height);
}

canv.stairs = function(context){
	context.strokeStyle = "black";
	context.beginPath();
	context.moveTo(0, 0);
	context.lineTo(100, 100);
	context.moveTo(100, 200);
	context.lineTo(200, 200);
	context.lineTo(200, 240);
	context.lineTo(300, 240);
	context.lineTo(300, 280);
	context.lineTo(400, 280);
	context.lineTo(400, 300);
	context.moveTo(400, 100);
	context.lineTo(400, 100);
	context.lineTo(400, 200);
	context.lineTo(300, 200);
	context.lineTo(300, 300);
	context.lineTo(200, 300);
	context.lineTo(200, 400);
	context.stroke();
}

canv.drawFace = function(ctx){

	ctx.beginPath();
	ctx.lineWidth = 30;
	ctx.lineCap = "butt";
	ctx.lineJoin = "round";
	ctx.strokeStyle = "black";
	ctx.fillStyle = "black";


	ctx.moveTo(50, 50);
	ctx.lineTo(150, 100);
	ctx.moveTo(this.width - 150, 100);
	ctx.lineTo(this.width - 50, 50);
	ctx.stroke();

	ctx.lineWidth = 20;
	ctx.moveTo(150, 250);
	ctx.lineTo(225, 280);
	ctx.lineTo(this.width - 150, 250)
	ctx.closePath();

	ctx.fill();
	ctx.stroke();
}

canv.drawRect = function(ctx){
	ctx.beginPath();
	ctx.rect(10, 10, this.width - 20, this.height - 20);
	// ctx.fillStyle = "blue";
	ctx.fill();
	ctx.stroke();
}

canv.drawCircle = function (ctx){
	ctx.beginPath();
	ctx.strokeStyle = "rgba(100,100,100,0.7)";
	ctx.lineWidth = 5;
	ctx.fillStyle = "cyan";
	ctx.arc(this.width/2, this.height/2, 350/2, 0, 2 * Math.PI, false);
	ctx.fill();

	ctx.stroke();
}

canv.drawCurve = function(ctx){
	ctx.beginPath();
	ctx.moveTo(50, 70);
	ctx.quadraticCurveTo(240, 270, 425, 35);
	ctx.stroke();

	ctx.beginPath();
	ctx.moveTo(75, 330);
	ctx.bezierCurveTo(110, 210, 260, 330, 400, 285);
	ctx.stroke();
}

canv.drawGradients = function(ctx){
	ctx.beginPath();
	ctx.rect(100, 10, this.width - 200, 200);
	var grad = ctx.createLinearGradient(
		300, 10, this.width - 200, 100
	);

	ctx.closePath();
	grad.addColorStop(0, "red");
	grad.addColorStop(1, "black");
	// grad.addColorStop(2, "green");
	ctx.fillStyle = grad;
	ctx.fill();

	ctx.beginPath();
	ctx.rect(
		100, 300, 300, 150
	);

	var radGrad = ctx.createRadialGradient(
		250, 370, 150, 250, 370, 100
	)

	ctx.closePath();
	radGrad.addColorStop(0, "red");
	radGrad.addColorStop(1, "black");
	ctx.fillStyle = radGrad;
	ctx.fill();
}

canv.drawText = function (ctx){
	ctx.fillStyle = "blue";
	ctx.textAlign = "center";
	ctx.textBaseline = "top";
	ctx.font = "bold 40px Arial";
	console.log(ctx.measureText("Hello World!"));
	ctx.fillText("Hello World!", this.width/2, this.height/2);
}


canv.drawBackground = function(ctx, color){
	ctx.rect(0, 0, this.width, this.height);
	ctx.fillStyle = color || "black";
	ctx.fill();
}