window.borderStyles = ['dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset', 'none', 'hidden'];
window.backgroundSizes = ['auto', 'cover', 'contain'];
$(document).ready(function(){
	window.forumCateg = ['introductions', 'discuss', 'manga', 'suggestions', 'report'];
	$("#contain_register, #contain_login").hide();
	$('#load_login').click(function(){
		$("#contain_login").show();
		$('#contain_login').html('<img src="/imagevault/loading.gif"/>');
		$('#contain_login').load('/include/pages/user/login_form.php');
		$('#contain_register').hide();
	});
	$("#contain_login, #load_login").click(function(event){
		event.stopPropagation();
	});
	$(document).click(function(){
		$("#contain_login").hide();
	});

	$('#load_register').click(function(){
		$("#contain_register").show();
		$('#contain_register').html('<img src="/imagevault/loading.gif"/>');
		$('#contain_register').load('/include/pages/user/register_form.php');
		$('#contain_login').hide();
	});
	$("#contain_register, #load_register").click(function(event){
		event.stopPropagation();
	});
	$(document).click(function(){
		$("#contain_register").hide();
		$('.error, .success').fadeOut('fast');
	});
	// alert('asd');
	if(window.location.href.indexOf('help') != -1){
		document.getElementById('how_to_create').onclick = function(){
		// $("#how_to_create").click(function(){
			/*$('#help_container').empty();
			$('#help_container').append('Text');*/
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/how_to_create.txt" border="0"></object>';
			//console.log('done');
		}
		document.getElementById('how_to_view').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/how_to_view.txt" border="0"></object>';
		}
		document.getElementById('how_to_edit_profile').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/how_to_edit_profile.txt" border="0"></object>';
		}
		document.getElementById('how_to_find_user').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/how_to_view_profile.txt" border="0"></object>';
		}
		document.getElementById('how_to_like').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/how_to_collect_like.txt" border="0"></object>';
		}
		document.getElementById('submit_ticket').onclick = function(){
			document.getElementById('help_container').innerHTML = '\
			<form action="/include/sync/submit_ticket.php" method="post" id="submit_ticket">\
			<table>\
				<tr>\
					<td>\
						<input type="text" name="ticket_title" placeholder="Ticket title...(max 64c)">\
					</td>\
				</tr>\
				<tr>\
					<td colspan="2">\
						<textarea name="ticket_body" style="width: 830px; height: 400px;" placeholder="Insert wonderful text here... (max 512c)"></textarea>\
					</td>\
				</tr>\
				<tr>\
					<td colspan="2" style="text-align: center;">\
						<input type="submit" value="Submit" class="button gray_">\
					</td>\
				</tr>\
			</table>\
			</div>';
		}
		document.getElementById('terms_of_service').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="2100px" type="text/plain" data="/../../text_files/terms_of_service.txt" border="0"></object>';
		}
		document.getElementById('privacy').onclick = function(){
			/*document.getElementById('help_container').innerHTML = '\
			We steal your data, life, belongings, kids and family.\
			';*/
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/privacy.txt" border="0"></object>';
		}
		document.getElementById('faq').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/faq.txt" border="0"></object>';
		}
		document.getElementById('partners').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/partners.txt" border="0"></object>';
		}
		document.getElementById('about_me').onclick = function(){
			document.getElementById('help_container').innerHTML = '<object width="830" height="750px" type="text/plain" data="/../../text_files/about_me.txt" border="0"></object>';
			//debug('asd');
		}
		// $('.post_user_title').flowtype({
		// 	minFont : 10,
		// 	maxFont : 14,
		// 	minimum : 100,
		// 	maximum : 110,
		// 	fontRatio : 10
		// });
		// $('.post_user_title').quickfit();
		/*$('.bwWrapper').BlackAndWhite({
			hoverEffect : true, // default true
			// set the path to BnWWorker.js for a superfast implementation
			webworkerPath : false,
			// to invert the hover effect
			invertHoverEffect: false,
			// this option works only on the modern browsers ( on IE lower than 9 it remains always 1)
			intensity:1,
			speed: { //this property could also be just speed: value for both fadeIn and fadeOut
			fadeIn: 200, // 200ms for fadeIn animations
			fadeOut: 800 // 800ms for fadeOut animations
			},
			onImageReady:function(img) {
		// this callback gets executed anytime an image is converted
			}
		});*/
	}
	$(".manga_view").hover(function() {
		$(this).siblings(".collect").addClass("visible");
	}, function() {
		$(this).siblings(".collect").removeClass("visible");
	});
});

// if(document.location.hash == '#add_post'){
// 	document.getElementById('add_post').focus();
// }

function nl2br (str, is_xhtml) {
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function nl1br (str, is_xhtml) {
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, breakTag);
}

function br2nl(str){
	return (str + '').replace(/<br\s*\/?>/mg,"\n");
}

function rgbToHex(R,G,B){
	return '#'+toHex(R)+toHex(G)+toHex(B)
}

function toHex(n) { //taken...
	n = parseInt(n,10);
	if (isNaN(n)) return "00";
	n = Math.max(0,Math.min(n,255));
	return "0123456789ABCDEF".charAt((n-n%16)/16)
		+ "0123456789ABCDEF".charAt(n%16);
}

function colorNameToHex(color){
// standard 147 HTML color names
	var colors  =  [];
	colors['aliceblue'] = 'F0F8FF';
	colors['antiquewhite'] = 'FAEBD7';
	colors['aqua'] = '00FFFF';
	colors['aquamarine'] = '7FFFD4';
	colors['azure'] = 'F0FFFF';
	colors['beige'] = 'F5F5DC';
	colors['bisque'] = 'FFE4C4';
	colors['black'] = '000000';
	colors['blanchedalmond'] = 'FFEBCD';
	colors['blue'] = '0000FF';
	colors['blueviolet'] = '8A2BE2';
	colors['brown'] = 'A52A2A';
	colors['burlywood'] = 'DEB887';
	colors['cadetblue'] = '5F9EA0';
	colors['chartreuse'] = '7FFF00';
	colors['chocolate'] = 'D2691E';
	colors['coral'] = 'FF7F50';
	colors['cornflowerblue'] = '6495ED';
	colors['cornsilk'] = 'FFF8DC';
	colors['crimson'] = 'DC143C';
	colors['cyan'] = '00FFFF';
	colors['darkblue'] = '00008B';
	colors['darkcyan'] = '008B8B';
	colors['darkgoldenrod'] = 'B8860B';
	colors['darkgray'] = 'A9A9A9';
	colors['darkgreen'] = '006400';
	colors['darkgrey'] = 'A9A9A9';
	colors['darkkhaki'] = 'BDB76B';
	colors['darkmagenta'] = '8B008B';
	colors['darkolivegreen'] = '556B2F';
	colors['darkorange'] = 'FF8C00';
	colors['darkorchid'] = '9932CC';
	colors['darkred'] = '8B0000';
	colors['darksalmon'] = 'E9967A';
	colors['darkseagreen'] = '8FBC8F';
	colors['darkslateblue'] = '483D8B';
	colors['darkslategray'] = '2F4F4F';
	colors['darkslategrey'] = '2F4F4F';
	colors['darkturquoise'] = '00CED1';
	colors['darkviolet'] = '9400D3';
	colors['deeppink'] = 'FF1493';
	colors['deepskyblue'] = '00BFFF';
	colors['dimgray'] = '696969';
	colors['dimgrey'] = '696969';
	colors['dodgerblue'] = '1E90FF';
	colors['firebrick'] = 'B22222';
	colors['floralwhite'] = 'FFFAF0';
	colors['forestgreen'] = '228B22';
	colors['fuchsia'] = 'FF00FF';
	colors['gainsboro'] = 'DCDCDC';
	colors['ghostwhite'] = 'F8F8FF';
	colors['gold'] = 'FFD700';
	colors['goldenrod'] = 'DAA520';
	colors['gray'] = '808080';
	colors['green'] = '008000';
	colors['greenyellow'] = 'ADFF2F';
	colors['grey'] = '808080';
	colors['honeydew'] = 'F0FFF0';
	colors['hotpink'] = 'FF69B4';
	colors['indianred'] = 'CD5C5C';
	colors['indigo'] = '4B0082';
	colors['ivory'] = 'FFFFF0';
	colors['khaki'] = 'F0E68C';
	colors['lavender'] = 'E6E6FA';
	colors['lavenderblush'] = 'FFF0F5';
	colors['lawngreen'] = '7CFC00';
	colors['lemonchiffon'] = 'FFFACD';
	colors['lightblue'] = 'ADD8E6';
	colors['lightcoral'] = 'F08080';
	colors['lightcyan'] = 'E0FFFF';
	colors['lightgoldenrodyellow'] = 'FAFAD2';
	colors['lightgray'] = 'D3D3D3';
	colors['lightgreen'] = '90EE90';
	colors['lightgrey'] = 'D3D3D3';
	colors['lightpink'] = 'FFB6C1';
	colors['lightsalmon'] = 'FFA07A';
	colors['lightseagreen'] = '20B2AA';
	colors['lightskyblue'] = '87CEFA';
	colors['lightslategray'] = '778899';
	colors['lightslategrey'] = '778899';
	colors['lightsteelblue'] = 'B0C4DE';
	colors['lightyellow'] = 'FFFFE0';
	colors['lime'] = '00FF00';
	colors['limegreen'] = '32CD32';
	colors['linen'] = 'FAF0E6';
	colors['magenta'] = 'FF00FF';
	colors['maroon'] = '800000';
	colors['mediumaquamarine'] = '66CDAA';
	colors['mediumblue'] = '0000CD';
	colors['mediumorchid'] = 'BA55D3';
	colors['mediumpurple'] = '9370D0';
	colors['mediumseagreen'] = '3CB371';
	colors['mediumslateblue'] = '7B68EE';
	colors['mediumspringgreen'] = '00FA9A';
	colors['mediumturquoise'] = '48D1CC';
	colors['mediumvioletred'] = 'C71585';
	colors['midnightblue'] = '191970';
	colors['mintcream'] = 'F5FFFA';
	colors['mistyrose'] = 'FFE4E1';
	colors['moccasin'] = 'FFE4B5';
	colors['navajowhite'] = 'FFDEAD';
	colors['navy'] = '000080';
	colors['oldlace'] = 'FDF5E6';
	colors['olive'] = '808000';
	colors['olivedrab'] = '6B8E23';
	colors['orange'] = 'FFA500';
	colors['orangered'] = 'FF4500';
	colors['orchid'] = 'DA70D6';
	colors['palegoldenrod'] = 'EEE8AA';
	colors['palegreen'] = '98FB98';
	colors['paleturquoise'] = 'AFEEEE';
	colors['palevioletred'] = 'DB7093';
	colors['papayawhip'] = 'FFEFD5';
	colors['peachpuff'] = 'FFDAB9';
	colors['peru'] = 'CD853F';
	colors['pink'] = 'FFC0CB';
	colors['plum'] = 'DDA0DD';
	colors['powderblue'] = 'B0E0E6';
	colors['purple'] = '800080';
	colors['red'] = 'FF0000';
	colors['rosybrown'] = 'BC8F8F';
	colors['royalblue'] = '4169E1';
	colors['saddlebrown'] = '8B4513';
	colors['salmon'] = 'FA8072';
	colors['sandybrown'] = 'F4A460';
	colors['seagreen'] = '2E8B57';
	colors['seashell'] = 'FFF5EE';
	colors['sienna'] = 'A0522D';
	colors['silver'] = 'C0C0C0';
	colors['skyblue'] = '87CEEB';
	colors['slateblue'] = '6A5ACD';
	colors['slategray'] = '708090';
	colors['slategrey'] = '708090';
	colors['snow'] = 'FFFAFA';
	colors['springgreen'] = '00FF7F';
	colors['steelblue'] = '4682B4';
	colors['tan'] = 'D2B48C';
	colors['teal'] = '008080';
	colors['thistle'] = 'D8BFD8';
	colors['tomato'] = 'FF6347';
	colors['turquoise'] = '40E0D0';
	colors['violet'] = 'EE82EE';
	colors['wheat'] = 'F5DEB3';
	colors['white'] = 'FFFFFF';
	colors['whitesmoke'] = 'F5F5F5';
	colors['yellow'] = 'FFFF00';
	colors['yellowgreen'] = '9ACD32';
	color = color.toLowerCase();
	if (typeof colors[color] != 'undefined'){
		return ('#' + colors[color]);
	} else {
		return (color);
	}
}

colorToHex = function(color){
	var rgb = color.trim().match(/^rgb\(([0-9]{1,3}),([0-9]{1,3}),([0-9]{1,3})\);?/);
	if(rgb != null && rgb[1]<=255 && rgb[2]<=255 && rgb[3]<=255)
		return rgbToHex(rgb[1],rgb[2],rgb[3]);
	else
		return colorNameToHex(color);
}

objColorToHex = function(elementID){
	color = document.getElementById(elementID).value.trim();
	return colorToHex(color);
}

isValidColor = function(color){
	return /^#(?:[\da-f]{3}$)|^#(?:[\da-f]{6}$)/gi.test(color);
}

isValidURL = function(url){
	return /^(?:url\()(?:(?:(?:http)|(?:https)|(?:ftp)):\/\/)?(?:www)?[\w\-]+\.[\w\-]+(?:\.[\w\-]+){0,2}\/[\w\-]+(?:\/[\w\-]+){0,16}\.(?:jpg|png|jpeg|gif)\)$/i.test(url);
}

isValidBorder = function(border){
	// var check = true;
	if(typeof border != 'undefined' && border != ''){
		var reg = border.match(/^(\d{1,3})(?:px) ([a-z]{4,10}) (#?\w{3,10})$/i);
		if(reg == null){
			return false;
		} else {
		 	if(reg[1]>30){
				alert('Seriously? A border bigger than 30px?');
				return false;
			}
			if(window.borderStyles.indexOf(reg[2]) == -1){
				return false;
			}
			if(!isValidColor(colorToHex(reg[3]))){
				return false;
			}
		}
	}else{
		// alert(border+'good');
		return true;
	}
	return true;
}

isValidSize = function(size){
	if(window.backgroundSizes.indexOf(size) != -1){
		// alert('here');
		return true;
	} else {
		// alert('not here');
		return /^(?:\d{1,4}(?:(?:px)|(?:%)) \d{1,4}(?:(?:px)|(?:%)))$/i.test(size);
	}
}

isValid = function(obj){
		// alert('Seriously, over 40px border?');
	// console.log(typeof obj['outline']);
	if((isValidColor(obj['color']) || obj['color'] == '') && (obj['background']['valid'] || obj['background']['value'] == '') && (isValidBorder(obj['border'])) && (typeof obj['size'] == 'undefined' || obj['size'] == '' || isValidSize(obj['background']['size'])) && (typeof obj['outline'] != 'undefined')){
		return true;
	} else {
		// console.log(obj);
		return false;
	}
}

getBackgroundSize = function(elementID){
	var size = '';
	for(var i=0; i<document.getElementsByName(elementID+'_size').length; i++){
		// console.log(document.getElementsByName(elementID+'_size')[i].value);
		if(document.getElementsByName(elementID+'_size')[i].checked){
			size = document.getElementsByName(elementID+'_size')[i].value;
			if(size == 'custom'){
				size = document.getElementById(elementID+'_size').value;
			}
			// console.log(size);

		}
	}
	return size.toLowerCase();
}

colorOrURL = function(val, type, elementID){
	// console.log(val+' '+type);
	if(type == 'color'){
		val = colorToHex(val);
		// console.log(val);
		return {"value": val, "valid": isValidColor(val)};
	} else {
		val = 'url(' + val + ')';
		var size = getBackgroundSize(elementID);
		// console.log(size);
		return {"value": val, "size": size,"valid": isValidURL(val)};
	}
}

objColorOrURL = function(elementID){
	var val = document.getElementById(elementID).value.trim();
	var type = document.getElementsByName(elementID+'_type')[0].checked ? 'color' : 'url';
	// console.log(val);
	if(val != '')
		return colorOrURL(val, type, elementID);
	else{
		// console.log('!colorOrURL');
		return {"value": '', "valid": true};
	}
}

correctFont = function(font){
	font = font.replace(/"/g, "'");
	if(/\s/g.test(font) && !/'/.test(font)){
		return "'"+font+"'";
	} else {
		return font;
	}
}

objCorrectFont = function(elementID){
	var font = document.getElementById(elementID).value.trim();
	return correctFont(font);
}

objOutlineYN = function(elementID){
	var checked = '';
	for(var i=0; i<document.getElementsByName(elementID+'_outline_check').length; i++){
		// console.log('Out');
		if(document.getElementsByName(elementID+'_outline_check')[i].checked){
			// console.log('In');
			checked = document.getElementsByName(elementID+'_outline_check')[i].value;
			// console.log(document.getElementsByName(elementID+'_outline_check')[i].value);
			// 0px 0 0 #fff, 0 0px 0 #fff, 0 0px 0 #fff, 0px 0 0 #fff
		}
	}
	if(checked == 'on'){
		var color = objColorToHex(elementID+'_outline');
		if(isValidColor(color)){
			return '1px 0 0 '+color+', 0 -1px 0 '+color+', 0 1px 0 '+color+', -1px 0 0 '+color;
		} else {

		}
	} else if(checked == 'off'){
		return 'none';
	} else {
		return '';
	}
}

getSettings = function(part){
	var color = objColorToHex(part+'_color');
	var font = objCorrectFont(part+'_font-family');
	var background = objColorOrURL(part+'_background');
	// var outline = objColorToHex(part+'_outline');
	var outline = objOutlineYN(part);
	// console.log(outline+'-outline');
	if(document.getElementById(part+'_border') != null){
		var border = document.getElementById(part+'_border').value;
		return {"color":color, "font":font, "background":background, "border":border, "outline":outline}//, "outline":outline};
	}else{
		// var border = '';
		return {"color":color, "font":font, "background":background, "outline":outline};
	}
}

changeSettings = function(){
	var background = objColorOrURL('top_part_background');
	console.log(background);
	var title = getSettings('title');
	var description = getSettings('description');
	var stats = getSettings('stats');
	// console.log(title['background']['size']);
	if(isValid(title) && isValid(description) && isValid(stats) && background['valid'] == true)
		$.post('/include/async/profile_settings.php', {title_color:title['color'], title_background:title['background']['value'], title_background_size:title['background']['size'], title_font:title['font'], description_color:description['color'], description_background:description['background']['value'], description_background_size:description['background']['size'], description_font:description['font'], stats_color:stats['color'], stats_background:stats['background']['value'], stats_background_size:stats['background']['size'], stats_font:stats['font'], stats_border:stats['border'], title_outline:title['outline'], description_outline:description['outline'], stats_outline:stats['outline'], background:background['value'], background_size:background['size']}, function(data){
			// alert(data);
			document.location.pathname = 'profile';
		});
	else
		alert('Please insert valid data...');
}

quotePost = function(text, user){
	// console.log('asd');
	// console.log(text);
	// window.scrollTo(0, document.body.scrollHeight);
	// var loc = document.location.pathname.split('/').slice(0,4);
	// console.log(loc);
	scrollDown();
	// scrollDown();
	// text = br2nl(text.replace(/(&#39;)/g,"'").replace(/(&#34;)/g,'"').replace("\n",''));
	text = br2nl(text.replace(/(&#39;)/g,"'").replace(/(&#34;)/g,'"'));
	// console.log(text);
	document.getElementById('add_post').value += user+' said: "'+text+'"; \n';
	document.getElementById('add_post').focus();

}

submitPost = function(){
	// var text = nl1br(document.getElementById('add_post').value.replace(/'/g,"&#39;").replace(/"/g,'&#34;'));
	//.replace(/<br\s*\/?>/mg,"\n");
	var text = document.getElementById('add_post').value;
	// .replace(/'/g,"&#39;").replace(/"/g,'&#34;');
	var topic = document.location.pathname.split('/')[3];
	var categ = forumCateg.indexOf(document.location.pathname.split('/')[2]) != -1 ? document.location.pathname.split('/')[2] : 'trash_can';
	var posts_page = document.getElementsByClassName('post').length;
	// console.log(text);
	var minLen = 5;
	if(categ != 'trash_can' && text.length >= minLen){
		document.getElementById('submit_post').disabled = true;
		setTimeout(function() {
			document.getElementById('submit_post').disabled = false;
		}, 5000);
		$.post('/include/async/create_post.php', { text:text, topic:topic, categ:categ }, function(data) {
			// console.log( data );
			// alert(data);
			// location.reload();
			window.id = data.replace(/^\D+/g, '');
			// alert(window.id);
			if(posts_page % 15 == 0){
				var path = document.location.pathname.split('/');
				var page = path.pop();
				page = parseInt(page) + 1;
				path.push(page);
				document.location.pathname = path.join('/');
				$.post('/include/async/load_post.php', {id:id}, function(data){
					$('.post').fadeIn('slow');
				});
			} else {
				$.post('/include/async/load_post.php', {id:id}, function(data){
					// alert(data);
					// document.getElementsByClassName('post')[getElementsByClassName.length]
					$('.post').last().after(data);
					$('.post').last().hide().fadeIn('slow').slideDown('slow');
				});
			}
		});
		document.getElementById('add_post').value = "";
	} else {
		$.growl.error({title:'', message:'Minimum '+minLen+' characters...＿〆(。。)'})
	}

	//alert(window.id);
}

deletePost = function(id){
	// alert('asd');
	$.post('/include/async/delete_post.php', {id:id}, function(data){
		$('#'+id).fadeOut('slow');
		// alert(data);
	});
}

editPostButton = function(id){
	var text = document.getElementById('editPost').value;
	//.replace(/'/gm,"&#39;").replace(/"/gm,'&#34;').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,'<br />')
	// alert(text);
	$.post('/include/async/edit_post.php', {id:id, text:text}, function(data){
		// alert(data);
	});
	// console.log(text);
	document.getElementById('post_text'+id).innerHTML = nl2br(text);
	document.getElementById(id).removeChild(document.getElementsByClassName('edit_button')[0]);
	document.getElementById(id).removeChild(document.getElementsByClassName('edit_button')[0]);
	// document.getElementById('options'+id).style.visibility = 'visible';
	$('.post_options').css('visibility', 'visible');
}

cancelPostButton = function(id){
	var text = document.getElementById('editPost').innerHTML;
	document.getElementById('post_text'+id).innerHTML = window.textEdit;
	document.getElementById(id).removeChild(document.getElementsByClassName('edit_button')[0]);
	document.getElementById(id).removeChild(document.getElementsByClassName('edit_button')[0]);
	// document.getElementById('options'+id).style.visibility = 'visible';
	$('.post_options').css('visibility', 'visible');
}

editPost = function(id){
	var text = document.getElementById('post_text'+id).innerHTML.replace(/([\r\n]?)(\r\n|\n\r|\r|\n)/g, '');
	//.replace(/'/g,"&#39;").replace(/"/g,'&#34;') regex ^>
	// console.log(text);
	window.textEdit = text;
	document.getElementById('post_text'+id).innerHTML = '<textarea id="editPost">'+br2nl(text)+'</textarea>';
	// document.getElementById('options'+id).style.visibility = 'hidden';
	$('.post_options').css('visibility', 'hidden');
	document.getElementById(id).innerHTML += '<button class="edit_button button gray_" onclick="editPostButton('+id+');">Edit</button> <button class="edit_button button gray_" onclick="cancelPostButton('+id+');">Cancel</button>';

	// $.post('/include/async/edit_post.php', {id:id}, function(data){
	// 	alert(data);
	// });
}

//change..
createTopic = function(user, lastPage){
	// alert(lastPage);
	var text = nl2br(document.getElementById('create_topic_text').value);
	// .replace(/([\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br />');
	var title = document.getElementById('create_topic_title').value.replace(' ','_');
	// document.getElementById('create_topic_text').value = '';
	var path = document.location.pathname;
	var categ = forumCateg.indexOf(path.split('/')[2]) != -1 ? path.split('/')[2] : 'trash_can';
	// alert(text+' '+title+' '+categ+' '+user);
	if(categ != 'trash_can'){
		if(title == ''){
			alert('You found out the secret topic!!! Not.');
		} else if(text == ''){
			alert('I know that human communication is not only comprised of words... But... Really? Go and write something.');
		} else {
			$.post('/include/async/existence.php', {text:text, title:title, categ:categ}, function(data){
				// alert(data);
				if(data == 'exists'){
					var append = window.confirm('Topic exists, append?');
					if(append){
						$.post('/include/async/create_topic.php', {user:user, text:text, title:title, categ:categ}, function(data){
					 		document.location.href = document.location.href.substring(0, document.location.href.length - 12) + title + '/' + lastPage + '#add_post';
						});
					} else {
						//document.location.pathname = path.split('/').splice(0,3).join('/');
					}
				} else {
					$.post('/include/async/create_topic.php', {user:user, text:text, title:title, categ:categ}, function(data){
						document.location.pathname = path.split('/').splice(0,3).join('/');
					});
				}
			});
		}
	}
}

cancelTopic = function(){
	document.location.pathname = document.location.pathname.split('/').splice(0,3).join('/');
}

checkForEnter = function(e, textarea){
	var code = (e.which ? e.which : e.keyCode);
	// console.log(code);
	document.getElementById('character_count').innerHTML = 255 - textarea.innerHTML.length;
	$('#editDescription').keyup(function() {
		var postLength = $(this).val().length;
		var charactersLeft = 256 - postLength;
		$('#character_count').text(charactersLeft);
		if(charactersLeft < 0){
			document.getElementById('character_count').style.color = 'red';
		} else {
			document.getElementById('character_count').style.color = '#10b4cd';
		}
	});
	if(code == 27){
		document.getElementById('profile_description').innerHTML = '<span id="profile_description_text">' + window.descriptionText + '</span><span id="edit_profile_description" onclick="editDescription();" class="noselect">✎</span>';
	} else if(code == 13) {
 	// 	alert(textarea.value);
		$.post('/include/async/edit_description.php', {text: textarea.value.replace(/<br\s*\/?>/g, '').replace(/([\r\n]?)(\r\n|\n\r|\r|\n)/g,'')}, function(data){
			// alert(data); Works like butter...
		});
		var font = document.getElementById('profile_description').style.fontFamily;
		// alert(document.getElementById('profile_description').style.fontFamily);
		if(/'/.test(font)){
			document.getElementById('profile_description').innerHTML = '<span id="profile_description_text">' + textarea.value.replace(/<br\s*\/?>/g, '').replace(/([\r\n]?)(\r\n|\n\r|\r|\n)/g,'').substring(0, 256) + '</span><span id="edit_profile_description" onclick="editDescription('+font+');" class="noselect" title="edit">✎</span>';
		} else {
			document.getElementById('profile_description').innerHTML = '<span id="profile_description_text">' + textarea.value.replace(/<br\s*\/?>/g, '').replace(/([\r\n]?)(\r\n|\n\r|\r|\n)/g,'').substring(0, 256) + '</span><span id="edit_profile_description" onclick="editDescription(\''+font+'\');" class="noselect" title="edit">✎</span>';
		}
	}
}

editDescription = function(font){
	// console.log('asd');
	var text = document.getElementById('profile_description_text').innerText;//.replace(/<br\s*\/?>/g, '');
	window.descriptionText = text;
	// alert(text);
	var count = 256 - text.length;
	document.getElementById('profile_description').innerHTML = '<textarea id="editDescription" placeholder="One line text... Enter will save it. Esc will cancel." onKeyUp="checkForEnter(event, this)" style="font-family: '+font+'">'+text+'</textarea><span id="character_count">'+count+'</span>';
}

doAlert = function(){
	alert('asd');
}

testGrowl = function(){
	$.growl({ title: "Growl", message: "The kitten is awake!" });
}

collectManga = function(id, growl){
	growl = typeof growl !== 'undefined' ? growl : true;
	// alert('asd');
	$.post('/include/async/is_collected.php', {id:id}, function(data){
		// console.log(data);
		if(!data){
			// alert(id);
			$.post('/include/async/collect_manga.php', {id:id}, function(data){
				if(growl){
					if(data){
						$.growl({ title: "Collected", message: 'Collect successful...' });
					} else {
						$.growl.error({ title: "", message: 'Collect failed...' });
					}
				}
			});
		} else {
			$.growl.error({ title: "", message: 'Already collected... (⊙ヮ⊙)' });
		}
	})
}

postCommentNewPage = function(){

}

postComment = function(type, toId){
	var text = document.getElementById('post_comment').value.replace(/(\r\n|\n\r|\r|\n)/g,'<br />');
	// var toId = document.location.pathname.split('/')[3];
	// var type = document.location.pathname.split('/')[1];
	// console.log(avatar);
	console.log(text+' '+toId+' '+type);
	if(text.length < 2){
		$.growl.error({title:'', message:'Please do write something ヽ(｡ゝω・｡)ﾉ'});
	} else {
		var pagePosts = Math.floor(document.getElementsByClassName('comments')[0].children[0].children.length / 2);
		// alert(pagePosts+' '+window.commentsPerPage);

		document.getElementById('post_comment_button').disabled = true;
		setTimeout(function() {
			document.getElementById('post_comment_button').disabled = false;
		}, 3000);


		if(pagePosts == window.commentsPerPage){
			$.post('/include/async/check_comment_last_page.php', {type:type, id:toId, comments_per_page:window.commentsPerPage, type:window.commentsType}, function(data){
				if(data == 0){
					// alert('not here');
					$(".comments").find("tr:gt(0)").remove();
					window.currentCommentPage = +window.commentsNumPages + +1;
					window.commentsNumPages = window.currentCommentPage;
					console.log(window.currentCommentPage);
					document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right disabled_button';
					document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
					document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+toId+');">'+window.currentCommentPage+'</span>';
					if (history.pushState) {
						var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
						window.history.pushState({path:newurl},'',newurl);
					}
				} else {
					// alert('here');
					$(".comments").find("tr:gt(0)").remove();
					window.currentCommentPage = window.commentsNumPages;
					document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+toId+');">'+window.currentCommentPage+'</span>';
					document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
					document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right disabled_button';
					$.post('/include/async/display_comment_page.php', {id:toId, page:window.currentCommentPage, comments_per_page:window.commentsPerPage, type:window.commentsType},function(data){
						// alert(data+'asd');
						document.getElementsByClassName('comments')[0].innerHTML = data;
						if (history.pushState) {
							var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
							window.history.pushState({path:newurl},'',newurl);
						}

						$('.comments tr:last').remove();
						$('.comments tr:last').remove();

					})
					//NOT DONE!

				}
			});
			// commentsPageForward(toId, window.commentsPerPage); WOAH!!! freaking HARD!
		}
		$.post('/include/async/create_comment.php', {to_id:toId, text:text, type:type}, function(data){
		// console.log(data);
			if(data != ''){
				//$(".comments").find("tr:gt(0)").remove();
				$.post('/include/async/load_comment.php', {id:data}, function(data){
					// alert(data);
					document.getElementById('post_comment').value = '';
					$('.comments tr:last').after(data);
					$('.comments tr').last().hide().fadeIn('slow').slideDown('slow');
				});
				scrollDown();
			} else
				alert('Non-existent... ٩(ఠ༬ఠ)و');
		})
	}
}

scrollDown = function(){
	//window.scrollTo(0, document.body.scrollHeight);
	$("html, body").animate({scrollTop:$(document).height()}, 750);
}

scrollDownFast = function(){
	$("html, body").animate({scrollTop:$(document).height()}, 300);
}

scrollUp = function(){
	//window.scrollTo(0, 0);
	$("html, body").animate({scrollTop:0}, 750);
}

scrollUpFast = function(){
	$("html, body").animate({scrollTop:0}, 300);
}

scrollStop = function(){
	//window.scrollTo(0, document.body.scrollHeight);
	$("html, body").stop();
}

deleteComment = function(id, toId){
	$.post('/include/async/delete_comment.php', {id:id}, function(data){
		// alert(data);
		if(!data){
			$.growl.error({title:'', message:'Could not delete comment...'})
		} else {
			$('#comment_title'+id).fadeOut('slow', function(){
				$('#comment_title'+id).remove();
			})
			$('#comment_body'+id).fadeOut('slow', function(){
				$('#comment_body'+id).remove();
			});
		}
	});
	//edits
	var lastId = $('.comments tr:last').attr('id').replace(/\D+/g, '');
	window.onPage = document.getElementsByClassName('comment_body').length+1;
	// alert(window.onPage+'-OP');
	window.onPage -= 1;
	$.post('/include/async/load_comment_after_delete.php', {id:lastId}, function(data){
		// alert(data);
		if(data != ''){
			$('.comments tr:last').after(data);
			$('.comments tr:last').last().hide().fadeIn('fast').slideDown('xslow');
			$.post('/include/async/check_comment_last_page.php', {id:toId, type:window.commentsType, comments_per_page:window.commentsPerPage}, function(data){
				if(data == 0){
					window.commentsNumPages -= 1;
					if(window.currentCommentPage == window.commentsNumPages)
						document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right disabled_button';
				}

			})
		} else {
			// alert(window.onPage+'-onpage');
			if(window.onPage == 1 && window.currentCommentPage > 1){
				// alert('will');
				window.commentsNumPages -= 1;
				window.currentCommentPage -= 1;
				// document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right disabled_button';
				// document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+id+');">'+window.currentCommentPage+'</span>';
				$.post('/include/async/display_comment_page.php', {id:toId, page:window.currentCommentPage, comments_per_page:window.commentsPerPage, type:window.commentsType}, function(data){
					// alert(data);
					document.getElementsByClassName('comments')[0].innerHTML = data;
					document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+id+');">'+window.currentCommentPage+'</span>';
					document.getElementById('show_page_num').innerHTML = window.currentCommentPage;
					// document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
					document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right disabled_button';
					if(window.currentCommentPage == 1){
						document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left disabled_button';
					}
					if (history.pushState) {
						var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
						window.history.pushState({path:newurl},'',newurl);
					}

				})
			}
			// window.onPage -= 1;
		}
	})
}

editComment = function(id){
	window.textEdit = document.getElementById('comment_body'+id).children[1].innerHTML.replace(/([\r\n]?)(\r\n|\n\r|\r|\n)/g, "").trim();
	console.log(window.textEdit);
	document.getElementById('comment_body'+id).children[1].innerHTML = '<textarea id="edit_comment" style="width: 100%; height: 95px;" placeholder="Ahm... where is that text gone?">'+window.textEdit.replace(/<br\s*\/?>/gi, "\n")+'</textarea>\
	<div style="text-align:center;"><button class="button gray_ spaced" onclick="editCommentButton('+id+');">Save</button><button class="button gray_ spaced" onclick="cancelCommentButton('+id+');">Cancel</button></div>';
	$('.comment_buttons').css('visibility', 'hidden');
}

cancelCommentButton = function(id){
	document.getElementById('comment_body'+id).children[1].innerHTML = window.textEdit;
	$('.comment_buttons').css('visibility', 'visible');
}

editCommentButton = function(id){
	var text = document.getElementById('edit_comment').value.replace(/(\r\n|\n\r|\r|\n)/g,'<br>');
	// console.log(text);
	$.post('/include/async/edit_comment.php', {id:id, text:text}, function(data){
		if(!data){
			$.growl.error({title:'', message:'Edit error...'})
		} else {
			document.getElementById('comment_body'+id).children[1].innerHTML = text;
			$('.comment_buttons').css('visibility', 'visible');
		}
	});
}

quoteComment = function(id){
	var text = document.getElementById('comment_body'+id).children[1].innerHTML.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,'').trim().replace(/<br\s*\/?>/gi,"\n");
	// console.log(text);
	document.getElementById('post_comment').value += document.getElementById('comment_title'+id).children[0].innerText+' said: "'+ text+'";'+"\n";
	document.getElementById('post_comment').focus();
}

voteStatus = function(id, status, updatable){
	updatable = typeof updatable !== 'undefined' ? updatable : false;
	$.post('/include/async/update_vote.php', {id:id, status:status}, function(data){
		// alert(data);
		if(data){
			if(status == 1){
				if(/-o-/i.test(document.getElementById('dislike'+id).children[0].className)){
					if(/-o-/i.test(document.getElementById('like'+id).children[0].className)){
						document.getElementById('like'+id).children[0].className = 'fa fa-thumbs-up liked';
						if(updatable){
							document.getElementById('vote_count').innerHTML = parseInt(document.getElementById('vote_count').innerHTML) + 1;
						}
					} else {
						document.getElementById('like'+id).children[0].className = 'fa fa-thumbs-o-up';
						if(updatable)
							document.getElementById('vote_count').innerHTML = parseInt(document.getElementById('vote_count').innerHTML) - 1;
					}
				} else {
					document.getElementById('dislike'+id).children[0].className = 'fa fa-thumbs-o-down';
					document.getElementById('like'+id).children[0].className = 'fa fa-thumbs-up liked';
					if(updatable){
						document.getElementById('vote_count').innerHTML = parseInt(document.getElementById('vote_count').innerHTML) + 2;
					}
				}
			} else {
				if(/-o-/i.test(document.getElementById('like'+id).children[0].className)){
					if(/-o-/i.test(document.getElementById('dislike'+id).children[0].className)){
						document.getElementById('dislike'+id).children[0].className = 'fa fa-thumbs-down disliked';
						if(updatable){
							document.getElementById('vote_count').innerHTML = parseInt(document.getElementById('vote_count').innerHTML) - 1;
						}
					} else {
						document.getElementById('dislike'+id).children[0].className = 'fa fa-thumbs-o-down';
						if(updatable)
							document.getElementById('vote_count').innerHTML = parseInt(document.getElementById('vote_count').innerHTML) + 1;
					}
				} else {
					document.getElementById('like'+id).children[0].className = 'fa fa-thumbs-o-up';
					document.getElementById('dislike'+id).children[0].className = 'fa fa-thumbs-down disliked';
					if(updatable){
						document.getElementById('vote_count').innerHTML = parseInt(document.getElementById('vote_count').innerHTML) - 2;
					}
				}
			}
		}
	});
}

/* function resizeImage(url, width, height, callback) {
    var sourceImage = new Image();

    sourceImage.onload = function() {
        // Create a canvas with the desired dimensions
        var canvas = document.createElement("canvas");
        canvas.width = width;
        canvas.height = height;

        // Scale and draw the source image to the canvas
        canvas.getContext("2d").drawImage(sourceImage, 0, 0, width, height);

        // Convert the canvas to a data URL in PNG format
        callback(canvas.toDataURL());
    }

    sourceImage.src = url;
} */

uncollectManga = function(id, growl){
	growl = typeof growl !== 'undefined' ? growl : true;
	$.post('/include/async/uncollect_manga.php',{id:id}, function(data){
		if(growl){
			if(data){
				$('#manga_obj'+id).fadeOut('slow');
				$.growl({title:'', message:'Remove successful...'});
			} else {
				$.growl.error({title:'', message:'Error...'});
			}
		}
	})
}

deleteManga = function(id, user){
	// var delete = confirm()... Should I???
	$.post('/include/async/delete_manga.php', {id:id, user:user}, function(data){
		if(data){
			$.growl({title:'', message:'Delete successful...'});
			$('#manga_obj'+id).fadeOut('slow');
		} else {
			$.growl.error({title:'', message:'Error in deletion...'})
		}
	})
}

changeCollectButton = function(status, id){
	if(status == 0){
		document.getElementById('add_to_collection').children[0].innerHTML = '<i class="fa fa-star"></i>';
		document.getElementById('add_to_collection').children[1].innerHTML = 'Remove...';
		document.getElementById('add_to_collection').onclick = function(){
			uncollectManga(id, false);
			changeCollectButton(1, id);
		}
		document.getElementById('add_to_collection').id = 'remove_from_collection';
	} else {
		document.getElementById('remove_from_collection').children[0].innerHTML = '<i class="fa fa-star-o"></i>';
		document.getElementById('remove_from_collection').children[1].innerHTML = 'Add...';
		document.getElementById('remove_from_collection').onclick = function(){
			collectManga(id, false);
			changeCollectButton(0, id);
		}
		document.getElementById('remove_from_collection').id = 'add_to_collection';
	}
}

startPostingTextarea = function(lastPage){
	// alert(lastPage);
	var loc = document.location.pathname.split('/').slice(0,4);
	loc.push(lastPage);
	window.lastPage = lastPage;
	// console.log(loc.join('/'));
	var text = document.getElementById('add_post').value.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,'').trim().replace(/<br\s*\/?>/gi,"\n");
	console.log(text);
	// $.post('/include/async/') //HAW THA HELL!!!
	localStorage.setItem("quoteFromAnotherPage", text);
	// document.location.pathname = loc.join('/');
	console.log(loc.join('/')+'#add_post');
	// document.location.hash = 'add_post';
	document.location.href = document.location.origin + loc.join('/') + '#add_post';


	// // changeLocPost(loc);
	// setTimeout(function(){
	// 	document.getElementById('add_post').value = localStorage.getItem('quoteFromAnotherPage');
	//
	// },5000);

	// function1(loc, function() {
	// 	changeValueText(text);
	// });


	// changeLocPost(loc).done(changeValueText(text));
	// alert(localStorage.getItem('quoteFromAnotherPage'));

}

if(document.location.hash == '#add_post'){
	$(document).ready(function(){
		document.getElementById('add_post').value = typeof localStorage.getItem('quoteFromAnotherPage') != 'undefined' && localStorage.getItem('quoteFromAnotherPage');
		localStorage.clear("quoteFromAnotherPage");
	})
}

// window.currentCommentPage = 1;

commentsPageForward = function(id){
	// alert('tolo');
	// console.log(window.currentCommentPage+' '+window.commentsNumPages);
	// alert(window.currentCommentPage+' '+window.commentsNumPages);
	if(+window.currentCommentPage < +window.commentsNumPages){
		// alert('yolo');
		window.currentCommentPage ++;
		$.post('/include/async/display_comment_page.php', {id:id, page:window.currentCommentPage, comments_per_page:window.commentsPerPage, type:window.commentsType}, function(data){
			document.getElementsByClassName('comments')[0].innerHTML = data;
			document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+id+');">'+window.currentCommentPage+'</span>';
			document.getElementById('show_page_num').innerHTML = window.currentCommentPage;
			document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
		})
		if(window.currentCommentPage == window.commentsNumPages){
			document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right disabled_button';
		} else {
			document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right';
		}
	}
	if (history.pushState) {
		var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
		window.history.pushState({path:newurl},'',newurl);
	}
	scrollStop();
	// scrollDownFast();
	console.log(window.currentCommentPage+' '+window.commentsNumPages);

}

commentsPageBack = function(id){
	if(window.currentCommentPage - 1 == 1 || window.currentCommentPage == 1){
		document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left disabled_button';
	} else {
		document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
	}
	if(+window.currentCommentPage > 1){
		window.currentCommentPage --;
		$.post('/include/async/display_comment_page.php', {id:id, page:window.currentCommentPage, comments_per_page:window.commentsPerPage, type:window.commentsType}, function(data){
			document.getElementsByClassName('comments')[0].innerHTML = data;
			document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right';
			document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+id+');">'+window.currentCommentPage+'</span>';
			document.getElementById('show_page_num').innerHTML = window.currentCommentPage;
			scrollDownFast();
		});
		if(window.currentCommentPage == 1){
			document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left disabled_button';
		} else {
			document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
		}
	}
	// document.location.search = '?comment_page='+window.currentCommentPage;
	// history.pushState('', '?comment_page', '');
	if (history.pushState) {
		var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
		window.history.pushState({path:newurl},'',newurl);
	}
	scrollStop();
	// console.log(window.currentCommentPage+' '+window.commentsNumPages);

}

// function function1(loc, callback) {
// 	document.location.pathname = loc.join('/');
// 	callback();
// }

checkEnterSimple = function(e, input, id){
	var code = (e.which ? e.which : e.keyCode);
	if(code == 27){
		 document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+id+');">'+window.replacedPage+'</span>';
	} else if(code == 13) {
		console.log(input.value+' '+id+' '+window.commentsNumPages);
		if(+input.value <= +window.commentsNumPages && +input.value > 0 && /^(\d+)$/.test(+input.value)){
			// alert('gawd');
			$.post('/include/async/display_comment_page.php', {id:id, page:input.value, comments_per_page:window.commentsPerPage, type:window.commentsType}, function(data){
				document.getElementsByClassName('comments')[0].innerHTML = data;
				window.currentCommentPage = input.value;
				if(window.currentCommentPage == 1){
					document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left disabled_button';
					document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right';
				} else
				if(window.currentCommentPage == window.commentsNumPages){
					document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right disabled_button';
					document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
				} else {
					document.getElementsByClassName('fa-arrow-right')[0].className = 'fa fa-arrow-right';
					document.getElementsByClassName('fa-arrow-left')[0].className = 'fa fa-arrow-left';
				}
				document.getElementById('comments_page_container').innerHTML = '<span id="show_page_num" onclick="changeCommentPage('+id+','+window.commentsPerPage+','+window.commentsNumPages+');">'+window.currentCommentPage+'</span>';
				if (history.pushState) {
					var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
					window.history.pushState({path:newurl},'',newurl);
				}
			})
		} else {
			$.growl.error({title:'', message: 'Page does not exist... Last page is '+window.commentsNumPages});
		}
	}
}

changeCommentPage = function(id){
	if(document.getElementById('comments_page_container').children[0].tagName.toLowerCase() == 'span'){
		// alert('asd');
		window.replacedPage = document.getElementById('comments_page_container').children[0].innerHTML;
		document.getElementById('comments_page_container').innerHTML = '<input type="number" id="comment_page_num" onKeyUp="checkEnterSimple(event, this, '+id+')">';
		// console.log(window.replacedPage);
	}
}

// window.commentPageRegex = document.location.search.match(/^\?comment_page=(\d+)$/i);
// console.log(window.commentPageRegex);

// if(!!window.commentPageRegex){
// 	window.currentCommentPage = window.commentPageRegex[1];
// }

function processAjaxData(response, urlPath){
	document.getElementById("content").innerHTML = response.html;
	document.title = response.pageTitle;
	window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
}

searchForManga = function(inWhat){
	inWhat = typeof inWhat != 'undefined' ? inWhat : 'all';
	// alert(inWhat);
	var text = document.getElementById('search_bar').value.trim();
	// alert(text);
	if(!/\W+/i.test(text)){
		$.post('/include/async/search_manga.php', {text:text, in_what:inWhat}, function(data){
			// alert(data);
			document.getElementById('manga_content').innerHTML = data;
			if(!window.hideButtons){
				$('.like_buttons').css('visibility', 'visible');
			}
			if (history.pushState) {
				if(text != ''){
					var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + text;
					window.history.pushState({path:newurl},'',newurl);
				} else {
					var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
					window.history.pushState({path:newurl},'',newurl);
				}
			}
		})
	} else {
		$.growl.error({title:'', message: 'Please insert only alphanumerical characters. †=”Ⴛ̸ ♡(˃͈ દ ˂͈ ༶ )'});
	}
}

submitTicket = function(){

}
