// start of file

//-------------------------------------------------------
// SHAPE OBJECT
//-------------------------------------------------------

	function Shape(oa){
		this.objtype = 'shape';

		// common settings
		this.name = oa.name || 'Shape';
		this.xpos = isval(oa.xpos)? oa.xpos : 0;		// these are used for stroke-independend position & size
		this.ypos = isval(oa.ypos)? oa.ypos : 400;
		this.path = isval(oa.path)? new Path(oa.path) : rectPathFromMaxes(false);
		this.visible = isval(oa.visible)? oa.visible : true;
		this.xlock = oa.xlock || false;
		this.ylock = oa.ylock || false;
		this.wlock = oa.wlock || false;
		this.hlock = oa.hlock || false;
		this.ratiolock = oa.ratiolock || false;

		// not settable defaults
		this.link = false;
		this.uselinkedshapexy = false;

		//debug('Just created a SHAPE: ' + JSON.stringify(this));
	}





//-------------------------------------------------------
// SHAPE METHODS
//-------------------------------------------------------


//	-----`
//	Draw
//	-----

	Shape.prototype.drawShape_Single = function(lctx){
		//debug('DRAWSHAPE_SINGLE');
		//this.checkPath();

		if(this.visible){
			lctx.fillStyle = _GP.projectsettings.colors.glyphfill;
			if(lctx === _UI.ishereghostctx) { lctx.fillStyle = 'rgba(0,0,255,0.2)'; }

			// Draw the appropriate stuff for each shape's fill & border
			lctx.beginPath();
			this.path.drawPath(lctx);
			lctx.closePath();
			lctx.fill();
		}
	};


	Shape.prototype.drawShape_Stack = function(lctx){
		//debug('DRAWSHAPE_STACK');
		if(this.visible){
			if(this.link){
				_GP.linkedshapes[this.link].shape.drawShape_Stack(lctx);
				return;
			}

			if((this.path.maxes.xmax === -1) && (lctx === _UI.chareditctx) && (_UI.selectedtool !== 'newpath')) this.path.calcMaxes();

			this.path.drawPath(lctx);
		}
	};

	Shape.prototype.drawShapeToArea = function(lctx, view){
		//debug('DRAWSHAPETOAREA');
		if(this.visible){
			//debug('drawShapeToArea for shape: ' + this.name + ' view=' + JSON.stringify(view));
			lctx.fillStyle = _GP.projectsettings.colors.glyphfill;
			lctx.beginPath();
			this.path.drawPathToArea(lctx, view);
			lctx.closePath();
			lctx.fill();
		}
	};

	Shape.prototype.makeSVG = function(size, gutter) {
		size = size || _UI.thumbsize;
		gutter = gutter || _UI.thumbgutter;
		var upm = _GP.projectsettings.upm;
		var desc = upm - _GP.projectsettings.ascent;
		var charscale = (size-(gutter*2)) / size;
		var gutterscale = (gutter / size) * upm;
		var vbsize = upm - (gutter*2);

		var re = '<svg version="1.1" ';
		re += 'xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" ';
		re += 'width="'+size+'" height="'+size+'" viewBox="0,0,'+vbsize+','+vbsize+'">';
		re += '<g transform="translate('+(gutterscale)+','+(upm-desc-(gutterscale/2))+') scale('+charscale+',-'+charscale+')">';
		// re += '<rect x="0" y="-'+desc+'" height="'+desc+'" width="1000" fill="lime"/>';
		// re += '<rect x="0" y="0" height="'+(upm-desc)+'" width="1000" fill="cyan"/>';
		re += '<path d="';
		re += this.path.makeSVGpathData();
		re += '"/>';
		re += '</g>';
		re += '</svg>';

		return re;
	};

	Shape.prototype.checkPath = function() {
		// debug('CHECKPATH - checking ' + this.name + '\n' + JSON.stringify(this.path));

		for(var pp = 0; pp < this.path.pathpoints.length; pp++){
			var tp = this.path.pathpoints[pp];
			if(!(tp.P.x)) debug(this.name + ' p' + pp + '.P.x is ' + tp.P.x);
			if(!(tp.P.y)) debug(this.name + ' p' + pp + '.P.y is ' + tp.P.y);

			if(!(tp.H1.x)) debug(this.name + ' p' + pp + '.H1.x is ' + tp.H1.x);
			if(!(tp.H1.y)) debug(this.name + ' p' + pp + '.H1.y is ' + tp.H1.y);

			if(!(tp.H2.x)) debug(this.name + ' p' + pp + '.H2.x is ' + tp.H2.x);
			if(!(tp.H2.y)) debug(this.name + ' p' + pp + '.H2.y is ' + tp.H2.y);
		}
	};

	Shape.prototype.drawSelectOutline = function(onlycenter, accent){
		// debug('\n Shape.drawSelectOutline - START');
		accent = accent || _UI.colors.blue.l65;
		// debug('\t accent = ' + json(accent));
		
		var hp = (_GP.projectsettings.pointsize/2);
		_UI.chareditctx.lineWidth = 1;
		_UI.chareditctx.strokeStyle = accent;

		if((_UI.selectedtool==='newrect')||(_UI.selectedtool==='shaperesize')){
			_UI.chareditctx.fillStyle = 'transparent';

			//draw bounding box and 8points
			var lx = _UI.eventhandlers.tempnewbasicshape? sx_cx(_UI.eventhandlers.tempnewbasicshape.xmin) : sx_cx(this.path.maxes.xmin);
			var rx = _UI.eventhandlers.tempnewbasicshape? sx_cx(_UI.eventhandlers.tempnewbasicshape.xmax) : sx_cx(this.path.maxes.xmax);
			var ty = _UI.eventhandlers.tempnewbasicshape? sy_cy(_UI.eventhandlers.tempnewbasicshape.ymax) : sy_cy(this.path.maxes.ymax);
			var by = _UI.eventhandlers.tempnewbasicshape? sy_cy(_UI.eventhandlers.tempnewbasicshape.ymin) : sy_cy(this.path.maxes.ymin);
			var w = (rx-lx);
			var h = (by-ty);

			_UI.chareditctx.strokeStyle = accent;
			_UI.chareditctx.strokeRect(lx,ty,w,h);
			if(_UI.selectedtool==='shaperesize'){ this.draw8points(onlycenter, accent);}

		} else if ((_UI.selectedtool === 'pathedit')||(_UI.selectedtool==='newpath')||(_UI.selectedtool==='pathaddpoint')){
			// Draw Path Points
			var sep = this.path.sp(true, 'DRAWSELECTOUTLINE');
			var pp = this.path.pathpoints;

			// Draw path selection outline
			_UI.chareditctx.lineWidth = 1;
			_UI.chareditctx.strokeStyle = accent;

			_UI.chareditctx.beginPath();
			this.path.drawPath(_UI.chareditctx);
			_UI.chareditctx.closePath();
			_UI.chareditctx.stroke();

			if(sep !== false){
				// Draw Handles
				//debug('DRAWSELECTOUTLINE - new path added, sep=' + sep + ' pathpoints: ' + JSON.stringify(this.path.pathpoints))
				pp[sep].drawHandles(true, true, accent);

				// Draw prev/next handles
				var prev = sep-1;
				if (prev === -1) prev = pp.length-1;
				pp[prev].drawHandles(false, true, accent);

				// debugging SVG Import
				//pp[sep].drawQuadraticHandle(pp[prev].P);

				pp[(sep+1) % pp.length].drawHandles(true, false, accent);
			}

			// Draw points
			for(var s=0; s<pp.length; s++){
				// debug('\n\t draw point ' + s + ' path.sp=' + this.path.sp(false) + ' pp.selected=' + pp[s].selected);
				var sel = (this.path.sp(false) && pp[s].selected);

				if(s===0) pp[s].drawDirectionalityPoint(sel, pp[(s+1)%pp.length], accent);
				else pp[s].drawPoint(sel, accent);
			}

		} else if ((_UI.selectedtool==='newoval')){
			_UI.chareditctx.strokeStyle = _UI.colors.blue.l65;
			var tpdso = ovalPathFromMaxes(_UI.eventhandlers.tempnewbasicshape);

			_UI.chareditctx.lineWidth = 1;
			_UI.chareditctx.strokeStyle = _UI.colors.blue.l65;

			_UI.chareditctx.beginPath();
			tpdso.drawPath(_UI.chareditctx);
			_UI.chareditctx.closePath();
			_UI.chareditctx.stroke();
		}
		// debug(' Shape.drawSelectOutline - END\n');
	};

	function rectPathFromMaxes(maxes){
		//Default Shape size
		var lx = 0;
		var ty = _GP.projectsettings.ascent;
		var rx = (_GP.projectsettings.upm / _GP.projectsettings.griddivisions);
		var by = 0;

		if(maxes){
			lx = maxes.xmin;
			ty = maxes.ymax;
			rx = maxes.xmax;
			by = maxes.ymin;
		}

		var qw = round((rx-lx)/4);
		var qh = round((ty-by)/4);

		// First Point
		var Pul = new Coord({'x':lx, 'y':ty});
		var H1ul = new Coord({'x':lx, 'y':(ty-qh)});
		var H2ul = new Coord({'x':(lx+qw), 'y':ty});

		// Second Point
		var Pur = new Coord({'x':rx, 'y':ty});
		var H1ur = new Coord({'x':(rx-qw), 'y':ty});
		var H2ur = new Coord({'x':rx, 'y':(ty-qh)});

		// Third Point
		var Plr = new Coord({'x':rx, 'y':by});
		var H1lr = new Coord({'x':rx, 'y':(by+qh)});
		var H2lr = new Coord({'x':(rx-qw), 'y':by});

		// Fourth Point
		var Pll = new Coord({'x':lx, 'y':by});
		var H1ll = new Coord({'x':(lx+qw), 'y':by});
		var H2ll = new Coord({'x':lx, 'y':(by+qh)});

		var patharr = [];
		patharr[0] = new PathPoint({'P':Pul, 'H1':H1ul, 'H2':H2ul});
		patharr[1] = new PathPoint({'P':Pur, 'H1':H1ur, 'H2':H2ur});
		patharr[2] = new PathPoint({'P':Plr, 'H1':H1lr, 'H2':H2lr});
		patharr[3] = new PathPoint({'P':Pll, 'H1':H1ll, 'H2':H2ll});

		var rp = new Path({'pathpoints':patharr, 'leftx':lx, 'rightx':rx, 'topy':ty, 'bottomy':by});
		//debug('RETURNING PATH: ' + JSON.stringify(rp));

		return rp;
	}

	function ovalPathFromMaxes(maxes){
		//Default Circle size
		var lx = 0;
		var ty = _GP.projectsettings.xheight;
		var rx = _GP.projectsettings.xheight;
		var by = 0;

		if(maxes){
			lx = maxes.xmin;
			ty = maxes.ymax;
			rx = maxes.xmax;
			by = maxes.ymin;
		}

		var hw = round((rx-lx)/2);
		var hh = round((ty-by)/2);
		var hwd = round(hw*0.448);
		var hhd = round(hh*0.448);

		// First Point - Top
		var Pt = new Coord({'x':(lx+hw), 'y':ty});
		var H1t = new Coord({'x':(lx+hwd), 'y':ty});
		var H2t = new Coord({'x':(rx-hwd), 'y':ty});

		// Second Point - Right
		var Pr = new Coord({'x':rx, 'y':(by+hh)});
		var H1r = new Coord({'x':rx, 'y':(ty-hhd)});
		var H2r = new Coord({'x':rx, 'y':(by-hhd)});

		// Third Point - Bottom
		var Pb = new Coord({'x':(lx+hw), 'y':by});
		var H1b = new Coord({'x':(rx-hwd), 'y':by});
		var H2b = new Coord({'x':(lx+hwd), 'y':by});

		// Fourth Point - Left
		var Pl = new Coord({'x':lx, 'y':(by+hh)});
		var H1l = new Coord({'x':lx, 'y':(by+hhd)});
		var H2l = new Coord({'x':lx, 'y':(ty-hhd)});

		var patharr = [];
		patharr[0] = new PathPoint({'P':Pt, 'H1':H1t, 'H2':H2t, 'type':'symmetric'});
		patharr[1] = new PathPoint({'P':Pr, 'H1':H1r, 'H2':H2r, 'type':'symmetric'});
		patharr[2] = new PathPoint({'P':Pb, 'H1':H1b, 'H2':H2b, 'type':'symmetric'});
		patharr[3] = new PathPoint({'P':Pl, 'H1':H1l, 'H2':H2l, 'type':'symmetric'});

		return new Path({'pathpoints':patharr});
	}

	Shape.prototype.draw8points = function(onlycenter, accent){
		//if(this.link) { return; }
		//debug('DRAW8POINTS - onlycenter: ' + onlycenter);
		accent = accent || _UI.colors.blue.l65;
		var ps = _GP.projectsettings.pointsize;
		var hp = ps/2;

		var lx = _UI.eventhandlers.tempnewbasicshape? sx_cx(_UI.eventhandlers.tempnewbasicshape.maxes.xmin)		: sx_cx(this.path.maxes.xmin);
		var rx = _UI.eventhandlers.tempnewbasicshape? sx_cx(_UI.eventhandlers.tempnewbasicshape.maxes.xmax)		: sx_cx(this.path.maxes.xmax);
		var ty = _UI.eventhandlers.tempnewbasicshape? sy_cy(_UI.eventhandlers.tempnewbasicshape.maxes.ymax)		: sy_cy(this.path.maxes.ymax);
		var by = _UI.eventhandlers.tempnewbasicshape? sy_cy(_UI.eventhandlers.tempnewbasicshape.maxes.ymin)	: sy_cy(this.path.maxes.ymin);

		var bleftx = (lx-hp).makeCrisp(true);
		var bmidx = (lx+((rx-lx)/2)-hp).makeCrisp(true);
		var brightx = (rx-hp).makeCrisp(true);
		var btopy = (ty-hp).makeCrisp(true);
		var bmidy = (ty+((by-ty)/2)-hp).makeCrisp(true);
		var bbottomy = (by-hp).makeCrisp(true);

		_UI.chareditctx.fillStyle = onlycenter? accent : 'white';
		_UI.chareditctx.strokeStyle = accent;

		if(!onlycenter){
			//upper left
			if(canResize('nw')){
				_UI.chareditctx.fillRect(bleftx, btopy, ps, ps);
				_UI.chareditctx.strokeRect(bleftx, btopy, ps, ps);
			}

			//top
			if(canResize('n')){
				_UI.chareditctx.fillRect(bmidx, btopy, ps, ps);
				_UI.chareditctx.strokeRect(bmidx, btopy, ps, ps);
			}

			//upper right
			if(canResize('ne')){
				_UI.chareditctx.fillRect(brightx, btopy, ps, ps);
				_UI.chareditctx.strokeRect(brightx, btopy, ps, ps);
			}

			// right
			if(canResize('e')){
				_UI.chareditctx.fillRect(brightx, bmidy, ps, ps);
				_UI.chareditctx.strokeRect(brightx, bmidy, ps, ps);
			}

			//lower right
			if(canResize('se')){
				_UI.chareditctx.fillRect(brightx, bbottomy, ps, ps);
				_UI.chareditctx.strokeRect(brightx, bbottomy, ps, ps);
			}

			//bottom
			if(canResize('s')){
				_UI.chareditctx.fillRect(bmidx, bbottomy, ps, ps);
				_UI.chareditctx.strokeRect(bmidx, bbottomy, ps, ps);
			}

			//lower left
			if(canResize('sw')){
				_UI.chareditctx.fillRect(bleftx, bbottomy, ps, ps);
				_UI.chareditctx.strokeRect(bleftx, bbottomy, ps, ps);
			}

			//left
			if(canResize('w')){
				_UI.chareditctx.fillRect(bleftx, bmidy, ps, ps);
				_UI.chareditctx.strokeRect(bleftx, bmidy, ps, ps);
			}

		}

		//Center Dot
		_UI.chareditctx.fillRect(bmidx, bmidy, ps, ps);
		_UI.chareditctx.strokeRect(bmidx, bmidy, ps, ps);
	};

	Shape.prototype.genPostScript = function(lastx, lasty){
		return this.path? this.path.genPathPostScript(lastx, lasty) : {'re':'', 'lastx':lastx, 'lasty':lasty};
	};


//	-----------------
//	Button Functions
//	-----------------
	function addShape(newshape){
		//debug('ADDSHAPE - was passed:\n' + JSON.stringify(newshape));
		if(newshape){
			if(newshape.link){
				_UI.selectedtool = 'shaperesize';
			} else if(newshape.path && (_UI.selectedtool === 'shaperesize')) {
				//debug('ADDSHAPE triggered as true: newshape.path && _UI.selectedtool == shaperesize \n\t NOT calling calcmaxes, okay?');
				//newshape.path.calcMaxes();
			}
		} else {
			//debug('ADDSHAPE - passed null, creating new shape.');
			newshape = new Shape({});
			newshape.name = ('Rectangle ' + ((getSelectedCharShapes().length*1)+1));
		}

		var sc = getSelectedChar();

		if(_UI.navhere === 'linked shapes' ){
			_UI.selectedshape = getSelectedCharID();
			sc.shape = newshape;
		} else {
			_UI.selectedshape = sc.charshapes.length;
			sc.charshapes.push(newshape);
			updateCurrentCharWidth();
		}

		_UI.navprimaryhere = 'npAttributes';

		//debug('ADDSHAPE - returns:\n' + JSON.stringify(newshape));
		return newshape;
	}

	function addBasicShape(type){
		var hd = 50;
		var th = 500;
		var tw = 300;
		var newshape = new Shape({});
		var parr = false;
		var shapetype = 'Shape ';
		var p1,p2,p3,p4;

		if(type === 'oval'){
			p1 = new PathPoint({'P':new Coord({'x':0,'y':(th/2)}), 'H1':new Coord({'x':0,'y':hd}), 'H2':new Coord({'x':0,'y':(th-hd)}), 'type':'symmetric'});
			p2 = new PathPoint({'P':new Coord({'x':(tw/2),'y':th}), 'H1':new Coord({'x':hd,'y':th}), 'H2':new Coord({'x':(tw-hd),'y':th}), 'type':'symmetric'});
			p3 = new PathPoint({'P':new Coord({'x':tw,'y':(th/2)}), 'H1':new Coord({'x':tw,'y':(th-hd)}), 'H2':new Coord({'x':tw,'y':hd}), 'type':'symmetric'});
			p4 = new PathPoint({'P':new Coord({'x':(tw/2),'y':0}), 'H1':new Coord({'x':(tw-hd),'y':0}), 'H2':new Coord({'x':hd,'y':0}), 'type':'symmetric'});
			parr = [p1,p2,p3,p4];
			shapetype = 'Oval ';
		} else {
			p1 = new PathPoint({'P':new Coord({'x':0,'y':0}), 'H1':new Coord({'x':hd,'y':0}), 'H2':new Coord({'x':0,'y':hd})});
			p2 = new PathPoint({'P':new Coord({'x':0,'y':th}), 'H1':new Coord({'x':0,'y':(th-hd)}), 'H2':new Coord({'x':hd,'y':th})});
			p3 = new PathPoint({'P':new Coord({'x':tw,'y':th}), 'H1':new Coord({'x':(tw-hd),'y':th}), 'H2':new Coord({'x':tw,'y':(th-hd)})});
			p4 = new PathPoint({'P':new Coord({'x':tw,'y':0}), 'H1':new Coord({'x':tw,'y':hd}), 'H2':new Coord({'x':(tw-hd),'y':0})});
			parr = [p1,p2,p3,p4];
			shapetype = 'Rectangle ';
		}

		newshape.path = new Path({'pathpoints':parr});
		newshape.name = (shapetype + getSelectedCharShapes().length+1);

		if(_UI.navhere === 'character edit') { _UI.selectedshape = getSelectedCharShapes().length; }
		getSelectedCharShapes().push(newshape);
		updateCurrentCharWidth();
	}

	function deleteShape(){
		var scs = getSelectedCharShapes();

		if(scs[_UI.selectedshape] && scs[_UI.selectedshape].link){
			removeFromUsedIn(scs[_UI.selectedshape].link, _UI.selectedchar);
		}

		if((scs.length > 0) && (_UI.selectedshape >= 0)){
			scs.splice(_UI.selectedshape, 1);
			if(scs.length === _UI.selectedshape) {
				_UI.selectedshape = _UI.selectedshape-1;
			}
		} else {
			//debug('DELETESHAPES - no shapes left');
		}

		if((_UI.selectedshape >= 0) && (scs[_UI.selectedshape].link)){
			//debug('DELETESHAPE - newly selected shape is linkedshape, changing tool');
			_UI.selectedtool = 'shaperesize';
		}
		updateCurrentCharWidth();
	}

	function turnSelectedShapeIntoALinkedShape(){
		var newls = clone(ss());
		deleteShape();
		newls.name = ('Linked Shape from ' + newls.name);
		var newid = addLinkedShape(newls);
		insertLinkedShape(newid, getSelectedCharID());
		_UI.selectedshape = getSelectedCharShapes().length-1;
		redraw('turnSelectedShapeIntoALinkedShape');
	}

	function clickSelectShape(x,y){
		//debug('CLICKSELECTShape() - checking x:' + x + ' y:' + y);

		if(_UI.navhere === 'linked shapes'){
			return clickSelectLinkedShape(x,y);
		}
		var ts;
		var scs = getSelectedCharShapes();
		for(var j=(scs.length-1); j>=0; j--){
			ts = scs[j];
			//debug('CLICKSELECTShape() - Checking shape ' + j);

			if(ts.isHere(x,y)){
				if(!ts.link) ts.path.selectPathPoint(false);
				if(j !== _UI.selectedshape){
					//debug('CLICKSELECTShape() - selecting shape ' + j);
					_UI.selectedshape = j;

					if(ts.link){
						//debug('CLICKSELECTSHAPE - detected this.link, setting _UI.selectedtool = shaperesize');
						_UI.selectedtool = 'shaperesize';
					}
				}

				_UI.navprimaryhere = 'npAttributes';
				return true;
			}
		}
		_UI.selectedshape = -1;
		//debug('CLICKSELECTShape() - deselecting, setting to -1');
		return false;
	}

	function isOverShape(x,y) {
		var scs = getSelectedCharShapes();
		for(var j=(scs.length-1); j>=0; j--){
			if(scs[j].isHere(x,y)) return true;
		}
		return false;
	}

	Shape.prototype.isHere = function(x,y){
		var imageData;
		_UI.ishereghostctx.clearRect(0,0,_UI.chareditcanvassize,_UI.chareditcanvassize);
		this.drawShape_Single(_UI.ishereghostctx);
		imageData = _UI.ishereghostctx.getImageData(x, y, 1, 1);
		//debug('ISHERE? alpha = ' + imageData.data[3] + '  returning: ' + (imageData.data[3] > 0));
		return (imageData.data[3] > 0);
	};

	Shape.prototype.isOverHandle = function(px,py){
		//debug('ISOVERHANDLE() - checking x:' + px + ' y:' + py);

		// Translation Fidelity - converting passed canvas values to saved value system
		var hp = _GP.projectsettings.pointsize/2;
		var leftxb = sx_cx(this.path.maxes.xmin) -hp;
		var midxb = Math.floor(sx_cx(this.path.maxes.xmin)+((sx_cx(this.path.maxes.xmax)-sx_cx(this.path.maxes.xmin))/2)-hp)+0.5;
		var rightxb = sx_cx(this.path.maxes.xmax) -hp;

		var topyb = sy_cy(this.path.maxes.ymax)-hp;
		var midyb = Math.floor(sy_cy(this.path.maxes.ymax)+((sy_cy(this.path.maxes.ymin)-sy_cy(this.path.maxes.ymax))/2)-hp)+0.5;
		var bottomyb = sy_cy(this.path.maxes.ymin) -hp;

		// upper left
		if(canResize('nw')){
			if( ((px > leftxb) && (px < leftxb+_GP.projectsettings.pointsize)) && ((py > topyb) && (py < topyb+_GP.projectsettings.pointsize)) ){
				setCursor('nw-resize');
				//debug('ISOVERHANDLE() -  upper left');
				return 'nw';
			}
		}

		// top
		if(canResize('n')){
			if( ((px > midxb) && (px < midxb+_GP.projectsettings.pointsize)) && ((py > topyb) && (py < topyb+_GP.projectsettings.pointsize)) ){
				setCursor('n-resize');
				//debug('ISOVERHANDLE() -  top');
				return 'n';
			}
		}

		// upper right
		if(canResize('ne')){
			if( ((px > rightxb) && (px < rightxb+_GP.projectsettings.pointsize)) && ((py > topyb) && (py < topyb+_GP.projectsettings.pointsize)) ){
				setCursor('ne-resize');
				//debug('ISOVERHANDLE() - upper right');
				return 'ne';
			}
		}

		// right
		if(canResize('e')){
			if( ((px > rightxb) && (px < rightxb+_GP.projectsettings.pointsize)) && ((py > midyb) && (py < midyb+_GP.projectsettings.pointsize)) ){
				setCursor('e-resize');
				//debug('ISOVERHANDLE() - right');
				return 'e';
			}
		}

		// lower right
		if(canResize('se')){
				if( ((px > rightxb) && (px < rightxb+_GP.projectsettings.pointsize)) && ((py > bottomyb) && (py < bottomyb+_GP.projectsettings.pointsize)) ){
				setCursor('se-resize');
				//debug('ISOVERHANDLE() - lower right');
				return 'se';
			}
		}

		// bottom
		if(canResize('s')){
			if( ((px > midxb) && (px < midxb+_GP.projectsettings.pointsize)) && ((py > bottomyb) && (py < bottomyb+_GP.projectsettings.pointsize)) ){
				setCursor('s-resize');
				//debug('ISOVERHANDLE() - bottom');
				return 's';
			}
		}

		// lower left
		if(canResize('sw')){
			if( ((px > leftxb) && (px < leftxb+_GP.projectsettings.pointsize)) && ((py > bottomyb) && (py < bottomyb+_GP.projectsettings.pointsize)) ){
				setCursor('sw-resize');
				//debug('ISOVERHANDLE() - lower left');
				return 'sw';
			}
		}

		// left
		if(canResize('w')){
			if( ((px > leftxb) && (px < leftxb+_GP.projectsettings.pointsize)) && ((py > midyb) && (py < midyb+_GP.projectsettings.pointsize)) ){
				setCursor('w-resize');
					//debug('ISOVERHANDLE() - left');
				return 'w';
			}
		}

		//debug('ISOVERHANDLE() - Returning FALSE');
		// updateCursor();
		return false;
	};

	Shape.prototype.changeShapeName = function(sn){
		sn = strSan(sn);
		//debug('CHANGESHAPENAME - sanitized name: ' + sn);
		if(sn !== ''){
			this.name = sn;
			history_put('shape name');
		} else {
			openDialog('<h1>Invalid shape name</h1><br>Shape names must only contain alphanumeric characters or spaces.<br>');
		}

		redraw('Shape Name');
	};

// end of file