<?php
echo '
<div id="contain_canvas" class="noselect">
	<canvas id="canvas" width="1000px" height="900px" style="cursor:crosshair; border:1px solid black">
		<p>No canvas support.</p>
	</canvas>
	<div id="buttons">
		<button class="button green_ button" id="save_canvas">Save</button>
		<button class="button red_ button" id="cancel_canvas">Cancel</button>
		<!-- <button id="test">test</button> -->
	</div>
</div>
';
echo '
<div id="opacityContainer">
	<div id="opacitySelector">
	</div>
</div>
<div id="tools">
	<label class="pen"><input type="radio" name="tool" value="pen"checked><span>✎</span></label>
	<label class="eraser"><input type="radio" name="tool" value="eraser"><span><i class="fa fa-eraser"></i></span></label>
</div>
';
echo '
<canvas id="cc" width="300" height="270" style="display: none;"></canvas>
';
?>
<script>
canv.init();
window.errorOnce = false;
window.saveCanvas = false;
document.getElementById('save_canvas').onclick = function(){
	var id = document.location.pathname.split('/')[3];
	resizeDataURL();
	$.post('/include/async/edit_manga.php', {data:canv.canvas.toDataURL(), thumbnail:window.thumbnail, id:id}, function(data){
		// console.log(data); //Comment soon!!!
		if(data){
			window.saveCanvas = true;
			// $.growl({ title: "Saved", message: 'Saved successfully...' });
		} else {
			window.saveCanvas = false;
			//$.growl.error({ title: "", message: 'Not saved at all...' });
		}
	});
}

document.getElementById('cancel_canvas').onclick = function(){
	// document.location.pathname = '/manga';
	window.history.back();
}

$("#opacitySelector").draggable({
	containment: "#opacityContainer",
	scroll: false,
	cursorAt: {
		top: 15
	},
	axis: "y",
	drag: function (event, ui) {
		var val = 162 - ui.offset.top;
		// console.log(162 - ui.offset.top);
		// console.log('rgba(50,50,50,'+(ui.offset.top-50) / 100+')');
		canv.ctx.strokeStyle = 'rgba(0,0,0,'+val/100+')';
		document.getElementById('opacitySelector').style.backgroundColor = 'rgba(0,0,0,'+ (val+10) / 100+')';
	},
});
document.getElementById('opacitySelector').onmousedown = function(){
	// console.log(canvasPreparedToShipping('canvas','dest_canvas'));
	// console.log(canv.canvas.toDataURL());
	document.getElementsByName('tool')[0].checked = true;
	canv.ctx.strokeStyle = 'black';
	canv.ctx.lineWidth = 1;
	document.getElementById('canvas').style.cursor = 'crosshair';
}
for(var i=0; i<2; i++){
	document.getElementsByName('tool')[i].onclick = function(){
		if(this.value == 'pen'){
			canv.ctx.strokeStyle = 'black';
			canv.ctx.lineWidth = 1;
			document.getElementById('canvas').style.cursor = 'crosshair';
		} else {
			canv.ctx.strokeStyle = 'white';
			canv.ctx.lineWidth = 8;
			document.getElementById('canvas').style.cursor = 'url(/imagevault/interface/cursor/eraser.ico) 2 45, crosshair';
		}
	}
}

/*document.getElementById('test').onclick = function(){
	resizeh();
	console.log(document.getElementById('canvas').toDataURL());
	//console.log(document.getElementById('cc').toDataURL());
	// async.parallel([resizeh(), console.log(document.getElementById('canvas').toDataURL())], console.log(document.getElementById('cc').toDataURL()));
}*/

//http://stackoverflow.com/questions/18922880/html5-canvas-resize-downscale-image-high-quality - ViliusL's post
//After 10 months, All hail ViliusL... xD

resizeDataURL = function(){
	var newCanv = document.getElementById("cc");
	var newCtx = newCanv.getContext("2d");

	var img = new Image();
	img.crossOrigin = "Anonymous"; //cors support
	img.onload = function(){
		var W = img.width;
		var H = img.height;
		newCanv.width = W;
		newCanv.height = H;
		newCtx.drawImage(img, 0, 0); //draw image
	
	//resize by ratio
	//var ratio = 0.43895525; //from 0 to 1
	//resample_hermite(newCanv, W, H, Math.round(W*ratio), Math.round(H*ratio));

	//resize manually
		resample_hermite(newCanv, W, H, 300, 270);
	}
	img.src = canv.canvas.toDataURL();
}

function resample_hermite(newCanv, W, H, W2, H2){
	var time1 = Date.now();
	// alert(time1);
	W2 = Math.round(W2);
	H2 = Math.round(H2);
	var img = newCanv.getContext("2d").getImageData(0, 0, W, H);
	var img2 = newCanv.getContext("2d").getImageData(0, 0, W2, H2);
	var data = img.data;
	var data2 = img2.data;
	var ratio_w = W / W2;
	var ratio_h = H / H2;
	var ratio_w_half = Math.ceil(ratio_w/2);
	var ratio_h_half = Math.ceil(ratio_h/2);

	for(var j = 0; j < H2; j++){
		for(var i = 0; i < W2; i++){
			var x2 = (i + j*W2) * 4;
			var weight = 0;
			var weights = 0;
			var weights_alpha = 0;
			var gx_r = gx_g = gx_b = gx_a = 0;
			// var gx_r = 0;
			// var gx_g = 0;
			// var gx_b = 0;
			// var gx_a = 0;
			var center_y = (j + 0.5) * ratio_h;
			for(var yy = Math.floor(j * ratio_h); yy < (j + 1) * ratio_h; yy++){
				var dy = Math.abs(center_y - (yy + 0.5)) / ratio_h_half;
				var center_x = (i + 0.5) * ratio_w;
				var w0 = dy*dy; //pre-calc part of w
				for(var xx = Math.floor(i * ratio_w); xx < (i + 1) * ratio_w; xx++){
					var dx = Math.abs(center_x - (xx + 0.5)) / ratio_w_half;
					var w = Math.sqrt(w0 + dx*dx);
					if(w >= -1 && w <= 1){
						//hermite filter
						weight = 2 * w*w*w - 3*w*w + 1;
						if(weight > 0){
							dx = 4*(xx + yy*W);
							//alpha
							gx_a += weight * data[dx + 3];
							weights_alpha += weight;
							//colors
							if(data[dx + 3] < 255)
								weight = weight * data[dx + 3] / 250;
							gx_r += weight * data[dx];
							gx_g += weight * data[dx + 1];
							gx_b += weight * data[dx + 2];
							weights += weight;
							}
						}
					}
				}
			data2[x2]     = gx_r / weights;
			data2[x2 + 1] = gx_g / weights;
			data2[x2 + 2] = gx_b / weights;
			data2[x2 + 3] = gx_a / weights_alpha;
			}
		}
	console.log((Math.round(Date.now() - time1)/1000)+" s");
	newCanv.getContext("2d").clearRect(0, 0, Math.max(W, W2), Math.max(H, H2));
	newCanv.width = W2;
	newCanv.height = H2;
	newCanv.getContext("2d").putImageData(img2, 0, 0);
	$.post('/include/async/edit_manga_thumbnail.php', {thumbnail: document.getElementById('cc').toDataURL(), id: document.location.pathname.split('/')[3]}, function(data){
		if(!data || !window.saveCanvas){
			// console.log(data+'+'+window.saveCanvas);
			if(window.errorOnce){
				$.growl.error({title:'Manga save error', message:"Contact administrator..."});
			} else {
				$.growl.error({title:'', message:"Please save again..."});
				window.errorOnce = true;
			}
		} else {
			$.growl({ title: "Saved", message: 'Saved successfully...' });
		}
	});
}
// doAlert();

</script>
