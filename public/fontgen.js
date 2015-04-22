//requires jQuery && opentype to be loaded

//path api ref: https://github.com/nodebox/opentype.js/blob/master/src/path.js

//Export a syllabary to an opentype.Font which can be downloaded to an OTF
function ExportSyllabary(SyllabaryId, FontName, Callback)
{
	var glyphs = [];

	//fetch all glyphs from server
	$.ajax('/json/syllabary/grid/' + SyllabaryId)
	.done(function(Data)
	{
		//not defined glyph (required)
		var ndp = new opentype.Path();
		ndp.moveTo(0, 0);
		ndp.lineTo(100, 100);
		glyphs.push(new opentype.Glyph(
		{
			name: '.notdef',
			unicode: 0,
			advanceWidth: 100,
			path: ndp
		}));

		var ccode = 97; //a
		for (var i in Data.vowels)
		{
			for (j in Data.consonants)
			{
				var v = Data.vowels[i].symbol;
				var c = Data.consonants[j].symbol;
				var sdata;
				//console.log(Data.cells);
				/*if (Data.cells.length > (i + j * Data.vowels.length))
				{
					sData = Data.cells[i + j * Data.vowels.length].symbol_data;
					sdata = $($.parseXML(sdata)).children('svg');
				}
				else*/
				{
					var vdata = $($.parseXML(v.symbol_data)).children('svg');
					var cdata = $($.parseXML(c.symbol_data)).children('svg');

					sdata = $(vdata).append(cdata.children());
					console.log(sdata);
				}

				glyphs.push(CreateGlyph(ccode, sdata));
				ccode++;
			}
		}
		var font = new opentype.Font(
		{
			familyName: FontName || 'Sequoyah Font',
			styleName: 'regular',
			designer: 'Sequoyah',
			glyphs: glyphs,
			//unitsPerEm (1000)
			//encoding
			//copyright
			//description
			//version
			//license
			//licenseURL
		});

		if (Callback)
			Callback(font);
	})
	.fail(function(Err)
	{
		console.log("FAILED", Err);
	});
}
//Creates a glyph and returns the opentype glyph
function CreateGlyph(CharCode, $Svg)
{
	var wid = parseInt($Svg.attr('width'));
	var hgt = parseInt($Svg.attr('height'));

	var chPath = new opentype.Path();
	$Svg.children().each(function(i)
	{
		SvgToPath(chPath, $(this), wid, hgt);
	});

	var glyph = new opentype.Glyph(
	{
		name: String.fromCharCode(CharCode),
		unicode: CharCode,
		advanceWidth: wid,
		path: chPath
	});
	return glyph;
}

function NormUnits(Value, Scale)
{
	if (!Value)
		return 0;

	return parseInt(Value) * (Value.indexOf('%') >= 0 ? Scale / 100 : 1);
}
//Note, all Y coordinates are flipped
function SvgToPath(Path, $Node, DocWidth, DocHeight)
{
	var tag = $Node.prop('tagName');

	if (tag == 'g') //groups
		$Node.children().each(function(i) { SvgToPath(Path, $(this), DocWidth, DocHeight); });

	if (tag == 'path')
	{
		//https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/d
		var d = $Node.attr('d');
		var x = 0, y = 0; //previous location. (Some commands are relative)

		var matches = d.match(/([a-z])([^a-z]+)?/ig);
		for (var i in matches)
		{
			var m = matches[i];
			var c = m[0];
			var isCap = (c === c.toUpperCase()); //capitals specify absolute path

			if (c == 'z') //close
				Path.close();

			if (m.length < 2)
				continue;

			else if (c == 'm') //move to
			{
				var sub = m.match(/m\s*(-?[\d.]+)[,\s]+(-?[\d.]+)/i); //requires well-formed
				
				var dx = parseInt(sub[1]), dy = parseInt(sub[2]);
				if (isCap)
				{
					Path.moveTo(dx, DocHeight - dy);
					x = dx;
					y = dy;
				}
				else
				{
					Path.moveTo(x + dx, DocHeight - (y + dy));
					x += dx;
					y += dy;
				}
			}
			else if (c == 'l') //line to
			{
				var sub = m.match(/l\s*(-?[\d.]+)[,\s]+(-?[\d.]+)/i); //requires well-formed
				
				var dx = parseInt(sub[1]), dy = parseInt(sub[2]);
				if (isCap)
				{
					Path.lineTo(dx, DocHeight - dy);
					x = dx;
					y = dy;
				}
				else
				{
					Path.lineTo(x + dx, DocHeight - (y + dy));
					x += dx;
					y += dy;
				}
			}
			else if (c == 'c') //cubic curve to
			{
				var sub = m.match(/(-?[\d.]+)/gi); //requires well-formed

				var d1x = parseInt(sub[0]), d1y = parseInt(sub[1]);
				var d2x = parseInt(sub[2]), d2y = parseInt(sub[3]);
				var dx = parseInt(sub[4]), dy = parseInt(sub[5]);

				if (isCap)
				{
					Path.curveTo(d1x, DocHeight - d1y, d2x, DocHeight - d2y, dx, DocHeight - dy);
					x = dx;
					y = dy;
				}
				else
				{
					Path.curveTo(x + d1x, DocHeight - (y + d1y), x + d2x, DocHeight - (y + d2y), x + dx, DocHeight - (y + dy));
					x += dx;
					y += dy;
				}
			}
			else if (c == 'q') //quadratic curve to
			{
				var sub = m.match(/(-?[\d.]+)/gi); //requires well-formed

				var d1x = parseInt(sub[0]), d1y = parseInt(sub[1]);
				var dx = parseInt(sub[2]), dy = parseInt(sub[3]);

				if (isCap)
				{
					Path.quadTo(d1x, DocHeight - d1y, dx, DocHeight - dy);
					x = dx;
					y = dy;
				}
				else
				{
					Path.quadTo(x + d1x, DocHeight - (y + d1y), x + dx, DocHeight - (y + dy));
					x += dx;
					y += dy;
				}
			}
		}
	}
	else if (tag == 'line')
	{
		var w = $Node[0].getAttribute('stroke-width');
		if (!w || w <= 0)
			w = 1;
		else
			w = NormUnits(w, DocWidth);

		var x1 = NormUnits($Node.attr('x1'), DocWidth);
		var y1 = NormUnits($Node.attr('y1'), DocHeight);
		var x2 = NormUnits($Node.attr('x2'), DocWidth);
		var y2 = NormUnits($Node.attr('y2'), DocHeight);

		var dx = x2 - x1;
		var dy = y2 - y1;
		var w2 = w / 2;

		var l = Math.sqrt((dx * dx) + (dy * dy));
		var nx = -dy / l;
		var ny = dx / l;
		nx *= w2;
		ny *= w2;

		//console.log(DocWidth, DocHeight, w, x1, y1, x2, y2, l);

		Path.moveTo(x1 - nx, DocHeight - (y1 - ny));
		Path.lineTo(x1 + nx, DocHeight - (y1 + ny));
		Path.lineTo(x2 + nx, DocHeight - (y2 + ny));
		Path.lineTo(x2 - nx, DocHeight - (y2 - ny));
		Path.lineTo(x1 - nx, DocHeight - (y1 - ny));
		Path.close();
	}
	else if (tag == 'circle') //simulated with cubic bezier curves
	{
		var cx = NormUnits($Node.attr('cx'), DocWidth);
		var cy = NormUnits($Node.attr('cy'), DocHeight);
		var r = NormUnits($Node.attr('r'), DocWidth);

		var d = r * 0.551784; //good approximation for cubic bezier circle

		Path.moveTo(cx - r, DocHeight - cy);
		Path.curveTo(cx - r, DocHeight - (cy + d), cx - d, DocHeight - (cy + r), cx, DocHeight - (cy + r));
		Path.curveTo(cx + d, DocHeight - (cy + r), cx + r, DocHeight - (cy + d), cx + r, DocHeight - cy);
		Path.curveTo(cx + r, DocHeight - (cy - d), cx + d, DocHeight - (cy - r), cx, DocHeight - (cy - r));
		Path.curveTo(cx - d, DocHeight - (cy - r), cx - r, DocHeight - (cy - d), cx - r, DocHeight - cy);
		Path.close();
	}
	else if (tag == 'ellipse') //simulated with cubic bezier curves
	{
		var cx = NormUnits($Node.attr('cx'), DocWidth);
		var cy = NormUnits($Node.attr('cy'), DocHeight);
		var rx = NormUnits($Node.attr('rx'), DocWidth);
		var ry = NormUnits($Node.attr('ry'), DocHeight);
		
		//good approximation for cubic bezier ellipse
		var dx = rx * 0.551784;
		var dy = ry * 0.551784;

		Path.moveTo(cx - rx, DocHeight - cy);
		Path.curveTo(cx - rx, DocHeight - (cy + dy), cx - dx, DocHeight - (cy + ry), cx, DocHeight - (cy + ry));
		Path.curveTo(cx + dx, DocHeight - (cy + ry), cx + rx, DocHeight - (cy + dy), cx + rx, DocHeight - cy);
		Path.curveTo(cx + rx, DocHeight - (cy - dy), cx + dx, DocHeight - (cy - ry), cx, DocHeight - (cy - ry));
		Path.curveTo(cx - dx, DocHeight - (cy - ry), cx - rx, DocHeight - (cy - dy), cx - rx, DocHeight - cy);
		Path.close();
	}
	else if (tag == 'rect')
	{
		var x = NormUnits($Node.attr('x'), DocWidth);
		var y = NormUnits($Node.attr('y'), DocHeight);
		var w = NormUnits($Node.attr('width'), DocHeight);
		var h = NormUnits($Node.attr('height'), DocHeight);

		Path.moveTo(x, DocHeight - y);
		Path.lineTo(x + w, DocHeight - y);
		Path.lineTo(x + w, DocHeight - (y + h));
		Path.lineTo(x, DocHeight - (y + h));
		Path.lineTo(x, DocHeight - y);
		Path.close();
	}
	else if (tag == 'polygon' || tag == 'polyline')
	{
		var points = $Node.attr('points').match(/(-?[\d.]+)/gi);
		if (points.length < 2)
			return;

		Path.moveTo(parseInt(points[0]), DocHeight - parseInt(points[1]));
		for (var i = 2; i < points.length - 1; i += 2)
			Path.lineTo(parseInt(points[i]), DocHeight - parseInt(points[i + 1]));
		if (tag == 'polygon')
			Path.lineTo(parseInt(points[0]), DocHeight - parseInt(points[1]));
		Path.close();
	}
}