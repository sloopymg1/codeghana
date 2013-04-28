var currentLiveVideo;
var timer;
var i =0;
var youtubediv = new Array();
var MyKEY = 'ADD_YOU_APPKEY_HERE';
var listComments;
var defaultid = 'YOUTUBE_CHANNEL_ID';  // Set the Default youtube channel to load
var did;
var vid = 'YOUTUBE_VIDEO_ID';   // Set the default video ID to play here'
var nextPage = 2;
var previousPage = 0;
var previousQueryType = 'hot';
var previousSearchTerm = '';
var divID;
var divIDR;
var NEXT_PAGE_BUTTON = 'nextPageButton';
var PREVIOUS_PAGE_BUTTON ='previousPageButton';
var MAX_RESULTS_LIST = 8;
var rFeatured ='recently_featured';
var jData;    // Stores the Json result for info call
var info = 'info';   // Sets the div id of the info for current video


function listVideos(json,divid, page) {
         jData = json;
         var ul = document.createElement('ul');
	ul.setAttribute('id', 'youtubelist');
	if(json.data.items){
       var lItems =  json.data.items.length;
		for (var i = 0; i < json.data.items.length; i++) {
            if(json.data.items[i].video){
            var entry = json.data.items[i].video;
            }else{
             var entry = json.data.items[i];
              }
            updateNavigation(page);
            appendOptionLast('<a href="javascript:playVideo(\''+entry.id+'\',false,\''+addslashes(entry.title)+'\',true)"><img src="'+entry.thumbnail.sqDefault+'" onmouseout="mouseOutImage(this)" onmouseover="mousOverImage(this,\''+entry.id+'\',1)"></a><br />'+entry.title.substr(0,30)+'',entry.id,'ul1');
        }
	}else{
		divid.innerHTML = 'No Results Found';
	}
	hideLightbox();
}




var l = 1;
var c = 2;
var youtubeInit = new Array();
function insertVideos(div,typ,q,results,start){
	start = start + 1;
	if(typ == "mostviewed")
		q = "Most Viewed";
	if(typ == "linked")
		q = "Most Linked";
	var script = document.createElement('script');
	if(typ == "search"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/videos?q='+q+'&v=2&start-index='+start+'&max-results='+MAX_RESULTS_LIST+'&format=5&alt=jsonc&callback=youtubeInit['+l+']');
	if(document.title)
 		document.title = "Search: "+q.replace("+"," ")+" - YouTube Fast Search";
	}
	if(typ == "hot"){
                script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/videos?q='+defaultid+'&v=2&start-index='+start+'&max-results='+MAX_RESULTS_LIST+'&format=5&alt=jsonc&callback=youtubeInit['+l+']');
	//	script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/standardfeeds/'+rFeatured+'?alt=jsonc&v=2&format=5&callback=youtubeInit['+l+']&start-index='+start+'&max-results=5');

	if(document.title)
 		document.title = "Recently Featured - YouTube Fast Search";
	}
	if(typ == "mostviewed"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/standardfeeds/most_viewed?time=this_month&v=2&format=5&alt=jsonc&callback=youtubeInit['+l+']&start-index='+start+'&max-results='+MAX_RESULTS_LIST);
	if(document.title)
 		document.title = "Most Viewed This Month - YouTube Fast Search";
	}
	if(typ == "linked"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/standardfeeds/most_linked?time=this_month&v=2&format=5&alt=jsonc&callback=youtubeInit['+l+']&start-index='+start+'&max-results='+MAX_RESULTS_LIST);
	if(document.title)
 		document.title = "Most Linked This Month - YouTube Fast Search";
	}
	if(typ == "user"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/videos?author='+q+'&v=2format=5&&max-results='+results+'&alt=jsonc&callback=youtubeInit['+l+']');
	}
	if(typ == "playlist"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/playlists/'+q+'/?&alt=jsonc&v=2&format=5&callback=youtubeInit['+l+']');
	}
    if(typ == "channels"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/users/'+defaultid+'/uploads?&alt=jsonc&v=2&format=5&callback=youtubeInit['+l+']');
	}
          youtubeInit[l] = function(root) {
          listVideos(root,div, start);
        }
	script.setAttribute('id', 'jsonScript');
	script.setAttribute('type', 'text/javascript');
	document.documentElement.firstChild.appendChild(script);

}




 function insertRVideos(div,typ,q,results, start){
	start = start + 1;
       	var script = document.createElement('script');
       if(typ == "responses"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/videos/'+q+'/responses?&alt=jsonc&v=2&format=5&callback=youtubeInit['+l+']');
	}
        if(typ == "related"){
          script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/videos/'+q+'/related?&alt=jsonc&v=2&format=5&callback=youtubeInit['+l+']');
	}
          youtubeInit[l] = function(root) {
          listRVideos(root,div);
        }
	script.setAttribute('id', 'jsonScript');
	script.setAttribute('type', 'text/javascript');
	document.documentElement.firstChild.appendChild(script);

}


function listRVideos(json,divid) {
       	var ul = document.createElement('ul');
	ul.setAttribute('id', 'youtubelist');
	if(json.data.items){
		for (var i = 0; i < json.data.items.length; i++) {
            if(json.data.items[i].video){
                var entry = json.data.items[i].video;
            }else{
                 var entry = json.data.items[i];
              }
            appendOptionLast('<a href="javascript:playRVideo(\''+entry.id+'\',false,\''+addslashes(entry.title)+'\',true)"><img src="'+entry.thumbnail.sqDefault+'" onmouseout="mouseOutImage(this)" onmouseover="mousOverImage(this,\''+entry.id+'\',1)"></a><br />'+entry.title.substr(0,30)+'',entry.id,'rl');
            appendOptionLast('<a href="javascript:playRVideo(\''+entry.id+'\',false,\''+addslashes(entry.title)+'\',true)"><img src="'+entry.thumbnail.sqDefault+'" onmouseout="mouseOutImage(this)" onmouseover="mousOverImage(this,\''+entry.id+'\',1)"></a><br />'+entry.title.substr(0,30)+'',entry.id,'res');
        }
	}else{
		divid.innerHTML = 'No Results Found';
	}
	hideLightbox();
}




   function insertComments(div,typ,q,results,start){
	start = start + 1;
       	var script = document.createElement('script');
        var MyKEY = 'AI39si4VFDZ0JHV-Ck2GhkHa1iDVtL3fF-YP40N883Xe0MUQ6SVsCUbOEsV0nZ12QOtSRdww2GIw4MEkfaRRD-wmtxP1Uv7oXA';


	if(typ == "comment"){
		script.setAttribute('src', 'http://gdata.youtube.com/feeds/api/videos/'+q+'/comments?&alt=json-in-script&v=2&key='+MyKEY+'&callback=listComments');
	}

          listComments = function(data) {
           if(data.feed.entry){
                var allComments = data.feed.entry.length;
                document.getElementById("allcom").innerHTML = 'All Coments ('+allComments+')';
	             	for (var i = 0; i < data.feed.entry.length; i++) {
                var entries = data.feed.entry[i];
                appendOptionLastComment('<p id="author">'+entries.author[0].name.$t+'</p><br /><p>  Title  : '+entries['title'].$t+'</p><br /><p id="content">'+entries['content'].$t+'</p><br />', i,'com');
          }
	}else{
		document.getElementById("com").innerHTML = 'no results found';

	}
	hideLightbox();
      }
        script.setAttribute('id', 'jsonScript');
	script.setAttribute('type', 'text/javascript');
	document.documentElement.firstChild.appendChild(script);
   }


    function listVideoInfo(json,divid, id) {
 	var ul = document.createElement('ul');
	ul.setAttribute('id', 'youtubelist');
	clearList(divid);
	if(json.data.items){

       var lItems =  json.data.items.length;
		for (var i = 0; i < json.data.items.length; i++) {
            if(json.data.items[i].video){
                var entry = json.data.items[i].video;
            }else{
                 var entry = json.data.items[i];
                 }
            if(id == entry.id){
            appendOptionLast('<table style="width: 100%; background-color: #232323;  border: 0px solid #131415;" border="1"><tbody><tr><td colspan="3"><span style="font-family: arial, helvetica, sans-serif; color: #D52A2A;">  CURRENT VIDEO TITEL   :'+entry.title+'</span></td></tr><tr><td><a href="javascript:playVideo(\''+entry.id+'\',false,\''+addslashes(entry.title)+'\',true)"><img src="'+entry.thumbnail.sqDefault+'" onmouseout="mouseOutImage(this)" onmouseover="mousOverImage(this,\''+entry.id+'\',1)"></a></td><td style="background-color: #232323;"><p><span style="font-size: xx-small; font-family: arial, helvetica, sans-serif; color: #00ff00;">  DURATION    :'+entry.duration+'</span></p><p><span style="font-size: xx-small; font-family: arial, helvetica, sans-serif; color: #00ff00;">  VIEW COUNT :'+entry.viewCount+'</span></p><p><span style="font-size: xx-small; font-family: arial, helvetica, sans-serif; color: #00ff00;">  RATING         :'+entry.rating+'</span></p></td><td><p><span style="font-size: xx-small; font-family: arial, helvetica, sans-serif; color: #00ff00;">  WATCH WITH FLASH  :</span></p><p><span style="font-size: xx-small; font-family: arial, helvetica, sans-serif; color: #00ff00;">  WATCH ON YOUTUBE :</span></p><p><span style="font-size: xx-small; font-family: arial, helvetica, sans-serif; color: #00ff00;">  CHANNEL OWNER      :</span></p></td></tr><tr><td colspan="3"><span style="font-size: xx-small; font-family: arial, helvetica, sans-serif; color: #888888;">DESCRIPTION   :'+entry.description+'</span></td></tr></tbody></table>' ,entry.id,'info');
            }
       }
	}else{
		divid.innerHTML = 'No Results Found';
	}
	hideLightbox();
}




var normalplayer = false;
var currentid = 0;
var size = 1;

function getPageSize(){

	var xScroll, yScroll;

	if (window.innerHeight && window.scrollMaxY) {
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else {
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}
	
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}
	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight)
	return arrayPageSize;
}

function addslashes(str) {
	if(str){
		str=str.replace(/\'/g,'\\\'');
		str=str.replace(/\"/g,'');
	}
	return str;
}

function stripslashes(str) {
	str=str.replace(/\\'/g,'\'');
	return str;
}

function setCookie(name, value, expires, path, domain, secure){
	document.cookie = name + "=" + escape(value) +
		((expires) ? "; expires=" + expires.toGMTString() : "") +
		((path) ? "; path=" + path : "") +
		((domain) ? "; domain=" + domain : "") +
		((secure) ? "; secure" : "");
}


function getCookie(name){
	var dc = document.cookie;
	var prefix = name + "=";
	var begin = dc.indexOf("; " + prefix);
	if (begin == -1)
	{
		begin = dc.indexOf(prefix);
		if (begin != 0) return null;
	}
	else
	{
		begin += 2;
	}
	var end = document.cookie.indexOf(";", begin);
	if (end == -1)
	{
		end = dc.length;
	}
	return unescape(dc.substring(begin + prefix.length, end));
}
function deleteCookie(name, path, domain)
{
	if (getCookie(name))
	{
		document.cookie = name + "=" + 
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			"; expires=Thu, 01-Jan-70 00:00:01 GMT";
	}
}

//slider



//drag and drop
(function() {
var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;


YAHOO.example.DDApp = {
	init: function() {
		var rows=1,cols=3,i,j;
		for (i=1;i<cols+1;i=i+1) {
			new YAHOO.util.DDTarget("ul"+i);
		}
		for (i=1;i<cols+1;i=i+1) {
			for (j=1;j<rows+1;j=j+1) {
				new YAHOO.example.DDList("li" + i + "_" + j);
			}
		}


	},
	showOrder: function() {
		var parseList = function(ul, title) {
			var items = ul.getElementsByTagName("li");
			var out = title + ": ";
			for (i=0;i<items.length;i=i+1) {
				out += items[i].id + " ";
			}
			return out;
		};

		var ul1=Dom.get("ul1"), ul2=Dom.get("ul2"), ul3=Dom.get("ul3");
		//alert(parseList(ul1, "List 1") + "\n" + parseList(ul2, "List 2"));

	},

	switchStyles: function() {
		Dom.get("ul1").className = "draglist_alt";
		//Dom.get("ul2").className = "draglist_alt";
		Dom.get("ul3").className = "draglist_alt";
	}
};


YAHOO.example.DDList = function(id, sGroup, config) {
	YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config);
	this.logger = this.logger || YAHOO;
	var el = this.getDragEl();
	Dom.setStyle(el, "opacity", 0.67); // The proxy is slightly transparent
	this.goingUp = false;
	this.lastY = 0;
};

YAHOO.extend(YAHOO.example.DDList, YAHOO.util.DDProxy, {
	startDrag: function(x, y) {
		// make the proxy look like the source element
		var dragEl = this.getDragEl();
		var clickEl = this.getEl();
		Dom.setStyle(clickEl, "visibility", "hidden");
		dragEl.innerHTML = clickEl.innerHTML;
		Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
		Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor"));
		Dom.setStyle(dragEl, "border", "2px solid gray");
	},

	endDrag: function(e) {
		var srcEl = this.getEl();
		var proxy = this.getDragEl();
		// Show the proxy element and animate it to the src element's location
		Dom.setStyle(proxy, "visibility", "");
		var a = new YAHOO.util.Motion( 
			proxy, { 
				points: { 
					to: Dom.getXY(srcEl)
				}
			}, 
			0.2, 
			YAHOO.util.Easing.easeOut 
		)
		var proxyid = proxy.id;
		var thisid = this.id;

		// Hide the proxy and show the source element when finished with the animation
		a.onComplete.subscribe(function() {
				Dom.setStyle(proxyid, "visibility", "hidden");
				Dom.setStyle(thisid, "visibility", "");
			});
		a.animate();
	},

	onDragDrop: function(e, id) {
		// If there is one drop interaction, the li was dropped either on the list,
		// or it was dropped on the current location of the source element.
		if (DDM.interactionInfo.drop.length === 1) {
			// The position of the cursor at the time of the drop (YAHOO.util.Point)
			var pt = DDM.interactionInfo.point; 
			// The region occupied by the source element at the time of the drop
			var region = DDM.interactionInfo.sourceRegion; 
			var srcEl = this.getEl();
			var destEl = Dom.get(id);
			if(destEl.id == "ul2"){
				//hack for playlist
				var videoid = srcEl.id.replace("$", "");
				loadNewVideo(videoid);
				listVideoInfo(jData,info, videoid)
			}
			if(destEl.id == "ul3"){
				var destDD = DDM.getDDById(id);
				destEl.appendChild(this.getEl());
				destDD.isEmpty = false;
				DDM.refreshCache();
				savePlaylist(destEl.id);
			}
		}
	},

	onDrag: function(e) {
		// Keep track of the direction of the drag for use during onDragOver
		var y = Event.getPageY(e);
		if (y < this.lastY) {
			this.goingUp = true;
		} else if (y > this.lastY) {
			this.goingUp = false;
		}
		this.lastY = y;
	},

	onDragOver: function(e, id) {
		var srcEl = this.getEl();
		var destEl = Dom.get(id);
		// We are only concerned with list items, we ignore the dragover
		// notifications for the list.
		if (destEl.nodeName.toLowerCase() == "li") {
			var orig_p = srcEl.parentNode;
			var p = destEl.parentNode;
			if (this.goingUp) {
				p.insertBefore(srcEl, destEl); // insert above
			} else {
				p.insertBefore(srcEl, destEl.nextSibling); // insert below
			}
			DDM.refreshCache();
		}
	}
});

Event.onDOMReady(YAHOO.example.DDApp.init, YAHOO.example.DDApp, true);
})();
	function hideLightbox(){
		//Not needed
	}
	function onPlayerStateChange(event) {
		//normalplayer = document.getElementById("ytapiplayer");
                if (event.data == YT.PlayerState.ENDED) {
           setInterval(updateNormalPlayerInfo, 100);
          done = true;
        }
                
		/*
		slideit = YAHOO.widget.Slider.getHorizSlider("slider-bg","slider-thumb", 0, 200);
		slideit.subscribe("change", function(offsetFromStart) {
			var actualValue =this.getValue();
			seekTo(actualValue);
		});
		*/
	}

	function cueNewVideo(id) {
		if (normalplayer) {
			normalplayer.cueVideoById(id);
		}
	}


	function updateNormalPlayerInfo() {
		time = getCurrentTime();
		dur = getDuration();
		//a hack is needed due to difference in dur and time value
		dur = dur - 1;
		if((time > dur) && dur> 1 && time > 1){
			stop();
			getNextPlaylist();
			if(document.title)
				document.title = "Next in playlist...";
		}
	}
	
//var slideit;
function loadNewVideo(id) {
	if (normalplayer) {
		currentid = id;
		normalplayer.loadVideoById(id);
                getResponses(id);
                getComments(id);
                getRelated(id);
                listVideoInfo(jData, info, id);
	}
}



function loadNewRVideo(id) {
	if (normalplayer) {
		currentid = id;
		normalplayer.loadVideoById(id);
		listVideoInfo(jData, info, id);
         }
}


function getNextPlaylist(){
	var playlistplay = 0;
	var ul = document.getElementById("ul3");
	var items = ul.getElementsByTagName("li");
	for (i=0;i<items.length;i=i+1) {
		if(items[i].id == currentid){
			var p=i+1;
			if(items[p]){
				playlistplay = 1;
				loadNewVideo(items[p].id);
				break;
			}
		}
	}

	//get playlist if its filled
	if(playlistplay == 0 && items.length > 0)
		loadNewVideo(items[0].id);
}
   
function play() {
	if(!normalplayer) {
          livestream(itvghana);
 }else{
		normalplayer.playVideo();
    
	}
}

function pause() {
	if (normalplayer) {
		normalplayer.pauseVideo();
	}
}

function stop() {
	if (normalplayer) {
		normalplayer.stopVideo();
	}
}

function getDuration() {
	if (normalplayer) {
		return normalplayer.getDuration();
	}
}

function getCurrentTime() {
	if (normalplayer) {
	return normalplayer.getCurrentTime();
	}
}

function seekTo(seconds) {
	if (normalplayer) {
		normalplayer.seekTo(seconds, true);
	}
}
function fullscreen() {
	if (normalplayer) {
 		normalplayer.fullscreen();
	}
	alert('Click on the video player');
}

function appendOptionLast(text,id,ul){
	try{
		if(text && id && ul){
			var list = document.getElementById(ul);
			var newNode = document.createElement("li");
			newNode.setAttribute('id',id);
			newNode.innerHTML = text;
			list.appendChild(newNode);
			if(YAHOO.example && newNode != 'null')
				new YAHOO.example.DDList(newNode);
		}
	}catch(err){
		//Handle errors here
	}

}


function appendOptionLastComment(text,id,ul){
	try{
		if(text && id && ul){
			var list = document.getElementById(ul);
			var newNode = document.createElement("li");
			newNode.setAttribute('id',id);
			newNode.innerHTML = text;
			list.appendChild(newNode);

		}
	}catch(err){
		//Handle errors here
	}

}



 function appendOptionLastInfo(text,id,ul){
	try{
		if(text && id && ul){
			var list = document.getElementById(ul);
			var newNode = document.createElement("li");
			newNode.setAttribute('id',id);
			newNode.innerHTML = text;
			list.appendChild(newNode);

		}
	}catch(err){
		//Handle errors here
	}

}





function clearList(ul){

	var list = document.getElementById(ul);
	while (list.firstChild) 
	 {
		list.removeChild(list.firstChild);
	 }		
}




function mostViewed(){
	clearList('ul1');
	insertVideos('ul1','mostviewed','','5','0');
	previousQueryType = 'mostviewed';
	previousSearchTerm = '';
	divID = 'ul1';
}



function channel(){
	clearList('ul1');
	insertVideos('ul1','channels','','5','0');
	previousQueryType = 'channels';
	previousSearchTerm = '';
	divID = 'ul1';
}



function mostLinked(){
	clearList('ul1');
	insertVideos('ul1','linked','','5','0');
	previousQueryType = 'linked';
	previousSearchTerm = '';
	divID = 'ul1';
}

function getHot(){
	clearList('ul1');
       	insertVideos('ul1','hot','','5','0');
       	previousQueryType = 'hot';
       	previousSearchTerm = '';
       	divID = 'ul1';
}

function makeRequest(page){
	clearList('ul1');
	var tags = encodeURI(document.getElementById('searchinput').value);
	insertVideos('ul1','search',tags,'5','0');
	previousQueryType = 'search';
	previousSearchTerm = tags;
	divID = 'ul1';
}

function getSearch(tags){
	clearList('ul1');
	insertVideos('ul1','search',encodeURI(tags),'5','0');
        previousQueryType = 'search';
        previousSearchTerm = encodeURI(tags);
        divID = 'ul1';
}

function getResponses(id){
	clearList('res');
       	insertRVideos('res','responses',id,'5','0');
       	previousRQueryType = 'responses';
        previousRSearchTerm = id;
        divIDR = 'res';
}


function getRelated(id){
	clearList('rl');
       	insertRVideos('rl','related',id,'5','0');
       	previousRelQueryType = 'related';
        previousRelSearchTerm = id;
        divIDR = 'rl';
}

function getComments(id){
 clearList('com');
       	insertComments('com','comment',id,'15','0');
        previousComQueryType = 'comment';
        previousComSearchTerm = id;
        divID = 'com';
}



function paginate(div, pQueryType, pSearchTerm, page){
 clearList(div);
        Mresult =  MAX_RESULTS_LIST;
       	insertVideos(div, pQueryType, pSearchTerm, Mresult, page);
        previousQueryType = pQueryType;
        previousSearchTerm = pSearchTerm;
        divID = div;

}



var imname;
var timer;

function mousOverImage(name,id,nr){
	if(name)
		imname = name;
	imname.src = "http://img.youtube.com/vi/"+id+"/"+nr+".jpg";
	imname.style.border = 	'3px solid orange';
	nr++;
	if(nr > 3)
		nr = 1;
	timer = setTimeout("mousOverImage(false,'"+id+"',"+nr+");",1000);

}

function mouseOutImage(name){

	if(name)
		imname = name;
	//make border back to greyish
	imname.style.border = 	'3px solid #333';
	if(timer)
		clearTimeout(timer);

}

function savePlaylist(id){
	//console.log('save: '+id);
	ul=YAHOO.util.Dom.get(id);
	var items = ul.getElementsByTagName("li");
	var new_playlist = "";
	for (i=0;i<items.length;i=i+1) {
		 new_playlist += ""+items[i].id + "|";
	}
	var time = new Date("July 21, 2015 01:00:00")
	
	//console.log('data: '+new_playlist);
	setCookie('playlist',new_playlist,time);
}

function createPlaylist(){
	//console.log('load');
	var playlist = getCookie('playlist');
	if (playlist=="" || playlist==null){		
		//console.log('no playlist');
	}else{
		//console.log('playlist');
		var col_array=playlist.split('|');
		var part_num=0;
		while (part_num < col_array.length){
 			if (col_array[part_num]=='null' || col_array[part_num]==''){

			}else{
				appendOptionLast('<a href="javascript:playVideo(\''+col_array[part_num]+'\',false,\'drag and drop video\')"><img src="http://img.youtube.com/vi/'+col_array[part_num]+'/2.jpg" onmouseout="mouseOutImage(this)" onmouseover="mousOverImage(this,\''+col_array[part_num]+'\',1)"></a>',col_array[part_num],'ul3');
			}	
 		part_num+=1;
			}
	}
}

function clearPlaylist(){
	//console.log('clear: '+id);
	deleteCookie('playlist');
	clearList('ul3');
}
var firsttime = true;
var setter;    // Sets if youtube or livestream to be played
function playVideo(id,loader,title,clearer){
	if(document.title)
	document.title = title;
	if(setter =='off'){
              setYoutubePlayer();
              setter ='on' ;
              vid = id;
               } else{
               loadNewVideo(id);
               vid = id;
              }
    }



function playRVideo(id,loader,title,clearer){
	if(document.title)
	setYoutubePlayer();
		document.title = title;
                loadNewRVideo(id);
    }


 //Loads the default start up videos
YAHOO.util.Event.onDOMReady(channel);
YAHOO.util.Event.onDOMReady(createPlaylist);


       // This code reloads the Livestream
   function livestream(stream){
     currentLiveVideo = stream;  // Sets the current playing live stream
      vid = currentid;
     stop();
     var frm_element = document.getElementById("ytapiplayer");
        var vis = frm_element.style;
        vis.display = 'none';

        setter ='off';
       //string_allDone : "LIVE TV",
       document.getElementById('videoPlayer').innerHTML = stream;
   }




  function setYoutubePlayer(){
      var frm_element = document.getElementById('ytapiplayer');
       var vis = frm_element.style;
       if (vis.display=='' || vis.display=='none')
      {
           vis.display = 'block';
           document.getElementById('videoPlayer').innerHTML = "";
      }
   }


    function open(div){
      var frm_element = document.getElementById(div);
       var vis = frm_element.style;
       vis.display = 'block';
   }

     function close(div){
      var frm_element = document.getElementById(div);
       var vis = frm_element.style;
       vis.display = 'none';
   }



  function  buttonToggle(where, pval, nval ) {
    var newValp1 = (where.value == pval) ? close('top'):open('top');
    where.value = (where.value == pval) ? nval : pval;

}


    // Uploading a video Browser Uploading
   function checkForFile() {
    if (document.getElementById('file').value) {
      return true;
    }
    document.getElementById('errMsg').style.display = '';
    return false;
    
   }
    
 
  function   findLinkHref(entry, rel) {
  for (var i = 0, link; link = entry.link[i]; i++) {
    if (link.rel == rel) {
      return link.href;
    }
  }
  // a link with the specified rel was not found
  return null;
};
  
  
  function  findMediaContentHref(entry, type) {
  for (var i = 0, content; content = entry.media$group.media$content[i]; i++) {
    if (content.type == type) {
      return content.url;
    }
  }
  // a media:content element with the specified MIME type was not found
  return null;
};
   

   function updateNavigation(page) {
        nextPage = page + 5;
        previousPage = page - 5;
        document.getElementById(NEXT_PAGE_BUTTON).style.display = 'inline';
        document.getElementById(PREVIOUS_PAGE_BUTTON).style.display = 'inline';
        if (previousPage < 5) {
          document.getElementById(PREVIOUS_PAGE_BUTTON).disabled = true;
        } else {
          document.getElementById(PREVIOUS_PAGE_BUTTON).disabled = false;
        }
        document.getElementById(NEXT_PAGE_BUTTON).disabled = false;
      };
      

     // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var normalplayer;
      function onYouTubeIframeAPIReady() {
        normalplayer = new YT.Player('ytapiplayer', {
          height: '70%',
          width: '100%',
          videoId: vid,
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange   // This function is called to play the playlist videos
          }
        });
      }
      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }


// Could also use this to embed a youtube player optional.
/*
  var flashvars = {};
	var params = {};
	params.wmode = "transparent";
	params.AllowScriptAccess = "always";
	params.allowfullscreen = "true";
	var attributes = { id: "playerid" };
	swfobject.embedSWF("http://www.youtube.com/v/"+vid+"?fs=1&playerapiid=playerid&enablejsapi=1&rel=0&modestbranding=1", "ytapiplayer", "100%", "540", "8", "false", flashvars, params, attributes);
       */


new YAHOO.util.DD("video");
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-325506-4']);
	_gaq.push(['_trackPageview']);
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();



//-->
