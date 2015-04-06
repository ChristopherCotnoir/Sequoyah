// start of file

//	-------------------------------
//	MAIN FILE OF CONTROLORIZATION
//	-------------------------------

	function GetQueryParam(Name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + Name + "=([^&#]*)"),
	        results = regex.exec(window.location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	window.onload = function() {
		//console.clear();
		console.log('%c\n       GG              GG\n       G               G\n GGGG  G GG   G  GGGG  GGGGG   GGGGG\nG    G G G    G G    G G    G G     G\nG    G G G    G G    G G    G G\n GGGGG G  GGGGG GGGGG  GG   G GG\nGG   G   GG   G G             STUDIO\n GGGG     GGGG  GG\n\n' + _UI.thisGlyphrStudioVersion + '\n\n', 'color:rgb(0,170,225)');
		debug('\n MAIN SETUP - START');

		// Initialize Stuff
		insertGlobalDOMElements();
		setupGhostCanvas();

		//INSERT HERE NAVIGATING TO EXISTING PROJECT
		if (window.location.search.length > 1)
		{
			debug('\t >>> Using existing project');

			//load project file (synchronously)
			var fetch = new XMLHttpRequest();
			fetch.open('get', GetQueryParam('p'), false);
			fetch.send();

			if (fetch.status < 400)
			{
				importGlyphrProjectFromText(fetch.responseText);
				_UI.loadsampleproject = false;
				_UI.sampleproject = false;
			}
			else
				newGlyphrProject();
		}
		else
		{
			// Navigate
			if(_UI.devnav){
				debug('\t >>> DEV NAV - to ' + _UI.devnav);

				if(_UI.loadsampleproject && _UI.sampleproject){
					debug('\t >>> Using sample project');
					importGlyphrProjectFromText(_UI.sampleproject);
					_UI.loadsampleproject = false;
					_UI.sampleproject = false;
				} else {
					newGlyphrProject();
				}

				_UI.navhere = _UI.devnav;
			}
		}
		navigate(_UI.devnavprimary);

		debug(' MAIN SETUP - END\n');
	};

	function insertGlobalDOMElements(){

		var dialogbox = '<div id="dialog_box">' +
		'<table cellpadding=0 cellspacing=0 border=0><tr>' +
		'<td id="dialogLeftBar"><button class="dialogCloseButton" onclick="closeDialog();">&times;</button></td>' +
		'<td id="dialogRightContent"></td>' +
		'</tr></table></div>' +
		'<div id="dialog_bg" onclick="closeDialog();"></div>';

		document.body.innerHTML = '<div id="primaryScreenLayout"></div>';
		document.body.innerHTML += '<canvas id="ishereghostcanvas" height=10 width=10 ></canvas>';
		document.body.innerHTML += dialogbox;


		window.onbeforeunload = function() {
			if(_GP.projectsettings.stoppagenavigation && !_UI.debug){
				return '\n\nOh Noes!\nUnless you specifically saved your Glyphr Project, all your progress will be lost.\n\n';
			} else {
				return;
			}
		};
	}


//-------------------
// Common Panel Title
//-------------------
	function makePanelSuperTitle() {
		// debug('\n makePanelSuperTitle - START');
		var content = "";
		if(!_UI.popout) {
			var sc = getSelectedChar();
			var name;

			content += "<h1 class='panelsupertitle'>"+_UI.navhere.toUpperCase();
			if(sc){
				name = (sc.charname || sc.charhtml || sc.shape.name || '[no shape outline yet]');
				if(sc.charname) name = name.replace(/latin /i, '');
				content += "<span class='supertitleseperator'>&#x276F;&#x276F;</span>";
				content += name;
			} else if (_UI.navhere === 'kerning'){
				name = getSelectedKern();
				content += name? "<span class='supertitleseperator'>&#x276F;&#x276F;</span>" + name.getName() : '';
			}
			content += "</h1>";
		}
		// debug(' makePanelSuperTitle - returning\n' + content + '\n');
		return content;
	}




//-------------------
// Debug
//-------------------

	function debug(message, force){
		if(_UI.debug || force){
			if(typeof message === 'string'){
				message = message.replace(/&lt;/gi, '<');
				message = message.replace(/&gt;/gi, '>');
			}
			console.log(message);
		}
	}

	function json(obj, raw) {
		if(raw) return JSON.stringify(obj);
		else {
			var j = JSON.stringify(obj, undefined, '\t');
			if(j) return j.replace(/\n/g, '\r\n');
			else return '';
		}
	}


//--------------------------------------
// Dialog Box, Error Box, Notation
//--------------------------------------
	function closeDialog(){
		document.getElementById('dialog_box').style.display='none';
		document.getElementById('dialog_bg').style.display='none';
		document.getElementById('dialogRightContent').innerHTML = "<b>Error: unspecified dialog box content.</b>";
		document.body.focus();
	}

	function openDialog(content){
		document.body.focus();
		var dc = document.getElementById('dialogRightContent');
		dc.innerHTML = content;

		if(dc.style.height > 800) dc.style.height = 800;
		else dc.style.width = 'auto';

		document.getElementById('dialog_box').style.display='block';
		document.getElementById('dialog_bg').style.display='block';
	}

	function openNotation(content, x, y){
		getEditDocument().body.focus();
		var n = getEditDocument().getElementById('notation');
		n.innerHTML = content;
		n.style.top = (round(y)+'px');
		n.style.left = (round(x+50)+'px');
		n.style.display='block';
	}

	function closeNotation(){
		getEditDocument().getElementById('notation').style.display='none';
		getEditDocument().getElementById('notation').innerHTML = " [ Loading... ] ";
		getEditDocument().body.focus();
	}

	function makeErrorMessageBox() {
		var con ='<div id="errormessagebox" style="display:none;">' +
		'<table cellpadding=0 cellspacing=0 border=0><tr>' +
		'<td class="errormessageleftbar">'+
		'<button class="errormessageclosebutton" onclick="closeErrorMessageBox();">&times;</button></td>' +
		'<td id="errormessagecontent"></td>' +
		'</tr></table></div>';

		return con;
	}

	function showErrorMessageBox(msg) {
		var msgcon = document.getElementById('errormessagecontent');
		var msgbox = document.getElementById('errormessagebox');
		msgcon.innerHTML = msg;
		msgbox.style.display = 'block';
		console.warn(msg);
	}

	function closeErrorMessageBox(){
		document.getElementById('errormessagecontent').innerHTML = "";
		document.getElementById('errormessagebox').style.display = 'none';
	}


//-------------------
// Project Saved Sate
//-------------------
	function setProjectAsSaved(){
		_UI.projectsaved = true;

		if(_UI.popout) {
			document.title = 'Glyphr Studio - Tools';
			_UI.popout.document.title = 'Glyphr Studio - Canvas';
		} else {
			document.title = 'Glyphr Studio';
		}

		updateSaveIcon();
	}

	function setProjectAsUnsaved(){
		_UI.projectsaved = false;

		if(_UI.popout) {
			document.title = ' ❖ Glyphr Studio - Tools';
			_UI.popout.document.title = ' ❖ Glyphr Studio - Canvas';
		} else {
			document.title = ' ❖ Glyphr Studio';
		}

		updateSaveIcon();
	}


//-------------------
// File Savr
//-------------------

function saveTextFile(fname, json) {
	var fblob = new Blob([json], {'type':'text/plain;charset=utf-8', 'endings':'native'});

	try {
		// IE
		window.navigator.msSaveBlob(fblob, fname);
		return;
	} catch (err) {
		// Others
		var link = document.createElement('a');
		window.URL = window.URL || window.webkitURL;
		link.href = window.URL.createObjectURL(fblob);
		//link.onclick = ("alert("+window.URL.createObjectURL(fblob)+");");
		link.download = fname;

		var event = document.createEvent('MouseEvents');
		event.initEvent('click', true, false);
		link.dispatchEvent(event);
		return;
	}

	console.error('File could not be saved: ' + fname);
}


//-------------------
// Common Functions
//-------------------
	// returns a full new copy of any object
	function clone(cobj){
		var newObj = (cobj instanceof Array) ? [] : {};
		for (var i in cobj) {
			if (cobj[i] && typeof cobj[i] === 'object') {
				newObj[i] = clone(cobj[i]);
			} else newObj[i] = cobj[i];
		} 
		return newObj;
	}

	// rounds a number to include a .5 so it draws nicely on canvas
	// true = +0.5, false = -0.5
	Number.prototype.makeCrisp = function(dir){
		var mul = dir? 1 : -1;
		return round(this) + (0.5 * mul);
	};

	// flip boolean var
	function toggle(val) {
		//debug("TOGGLE - typeof val = " + typeof val);
		if(typeof val === 'string') eval(val + ' = !' + val);
		else val = !val;
	}

	// better rounding than Math.round
	function round(num, dec){
		if(!num) return 0;
		dec = isval(dec)? dec : 0;
		return Number(Math.round(num+'e'+dec)+'e-'+dec) || 0;
	}

	// removes illegal file name chars
	function strSan(val){
		return val.replace(/[<>'"\\]/g,"");
	}

	// removes begining and trailing whitespace, and any breaking or tab chars
	function trim(text) {
		try {
			text = text.replace(/^\s+|\s+$/g, '');
			return text.replace(/(\r\n|\n|\r|\t)/gm, '');
		} catch(e) { return ''; }
	}

	// returns true for 0 and false
	function isval(val){
		if(val === 0) return true;
		else if (val === false) return true;
		else if (JSON.stringify(val) === '{}') return false;
		else return !!val;

		//return ((typeof val !== "undefined") && (val !== null));
	}



//-------------------
// Object ID Stuff
//-------------------
	// Returns the first ID from an object
	function getFirstID(obj) {
		for(var key in obj){
			if(obj.hasOwnProperty(key)){
				return key;
			}
		}

		return false;
	}

	// Generate a new ID for an object
	function generateNewID(obj, base) {
		var number = 1;
		base = base || 'id';
		var id = ('' + base + number);
		while (obj.hasOwnProperty(id)) id = ('' + base + (++number));

		return id;
	}

	// returns the length of an associative array
	function getLength(obj){
		var len = 0;
		for(var key in obj){ if( obj.hasOwnProperty(key)) len++; }
		return len;
	}

//-------------------
// BUG EMAIL
//-------------------

	function genEmailContent(){
		var con = 'Have a feature idea or ran into an issue%3F We%27d be happy to help!';
		con += '%0A%0A%0A%0A___________________________________________%0A';
		con += 'version %09Glyphr Studio ' + _UI.thisGlyphrStudioVersion + '%0A';
		//con += 'appCodeName %09' + navigator.appCodeName + '%0A';
		con += 'app name %09' + navigator.appName + '%0A';
		//con += 'appVersion %09' + navigator.appVersion + '%0A';
		con += 'language %09' + navigator.language + '%0A';
		con += 'platform %09' + navigator.platform + '%0A';
		// con += 'systemLanguage %09' + navigator.systemLanguage + '%0A';
		// con += 'userLanguage %09' + navigator.userLanguage + '%0A';
		con += 'user agent %09' + encodeURIComponent(navigator.userAgent) + '%0A';

		//debug(con);

		return con;
	}




//-------------------
// COLORS
//-------------------

	function shiftColor(c, percent, lighter){
		percent = Math.max(0,Math.min(percent,1));
		var val = {};

		if(c.charAt(0)==="#"){
			c = c.substring(1,7);
			val.r = parseInt(c.substring(0,2),16);
			val.g = parseInt(c.substring(2,4),16);
			val.b = parseInt(c.substring(4,6),16);
		} else if (c.substring(0,4) === 'rgb('){
			c = c.split('(')[1].split(')')[0].split(',');
			val.r = c[0];
			val.g = c[1];
			val.b = c[2];
		} else {
			val.r = 0;
			val.g = 0;
			val.b = 0;
		}

		val.r = Math.max(0,Math.min(val.r,255));
		val.g = Math.max(0,Math.min(val.g,255));
		val.b = Math.max(0,Math.min(val.b,255));

		if(lighter){
			val.r = round(((255-(val.r*1))*percent)+(val.r*1));
			val.g = round(((255-(val.g*1))*percent)+(val.g*1));
			val.b = round(((255-(val.b*1))*percent)+(val.b*1));
		} else {
			val.r = round((val.r*1)-(val.r*percent));
			val.g = round((val.g*1)-(val.g*percent));
			val.b = round((val.b*1)-(val.b*percent));
		}

		return 'rgb('+val.r+','+val.g+','+val.b+')';
	}

// end of file