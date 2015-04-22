//requires jQuery && opentype to be loaded

//path api ref: https://github.com/nodebox/opentype.js/blob/master/src/path.js

//Export a syllabary to an opentype.Font which can be downloaded to an OTF
//File extension automatically appended to FontName
function ExportSyllabary(SyllabaryId, FontName, Callback)
{
	var file = FontName + ".otf";

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
			familyName: FontName || "Sequoyah Font",
			designer: 'Sequoyah',
			glyphs: glyphs,
			//unitsPerEm (1000)
			//styleName
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
					Path.moveTo(dx, dy);
					x = dx;
					y = dy;
				}
				else
				{
					Path.moveTo(x + dx, y + dy);
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
					Path.lineTo(dx, dy);
					x = dx;
					y = dy;
				}
				else
				{
					Path.lineTo(x + dx, y + dy);
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
					Path.curveTo(d1x, d1y, d2x, d2y, dx, dy);
					x = dx;
					y = dy;
				}
				else
				{
					Path.curveTo(x + d1x, y + d1y, x + d2x, y + d2y, x + dx, y + dy);
					x += dx;
					y += dy;
				}
			}
			else if (c == 'q') //quadratic curve to
			{
				//todo
			}
		}
	}
}