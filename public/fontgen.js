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
		for (var i in Data.vowels)
		{
			var s = Data.vowels[i];
			glyphs.push(CreateGlyph(s.ipa.charCodeAt(0), s.symbol.symbol_data));
		}

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

		var font = new opentype.Font(
		{
			familyName: FontName || 'Sequoyah Font',
			syleName: 'medium',
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
function CreateGlyph(CharCode, SvgData)
{
	var $svg = $($.parseXML(SvgData)).children('svg');

	var wid = parseInt($svg.attr('width'));
	var hgt = parseInt($svg.attr('height'));

	var chPath = new opentype.Path();
	$svg.children().each(function(i)
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
		console.log(w);
		if (!w || w <= 0)
			w = 1;
		else
			w = parseInt(w) * (w.indexOf('%') >= 0 ? DocWidth / 100 : 1);

		var x1 = $Node.attr('x1');
		var y1 = $Node.attr('y1');
		var x2 = $Node.attr('x2');
		var y2 = $Node.attr('y2');

		//handle relative; other units ignored
		x1 = parseInt(x1) * (x1.indexOf('%') >= 0 ? DocWidth / 100 : 1);
		y1 = parseInt(y1) * (y1.indexOf('%') >= 0 ? DocHeight / 100 : 1);
		x2 = parseInt(x2) * (x2.indexOf('%') >= 0 ? DocWidth / 100 : 1);
		y2 = parseInt(y2) * (y2.indexOf('%') >= 0 ? DocHeight / 100 : 1);

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
}