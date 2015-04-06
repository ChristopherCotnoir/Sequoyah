// start of file

//-------------------
// Layers Panel
//-------------------
	function makePanel_LayerChooser(){

		var content = "<div class='navarea_header'>";

		content += makePanelSuperTitle();

		content += "<h1 class='paneltitle'>shapes</h1>";

		content += "</div><div class='panel_section'>";

		var scs = getSelectedCharShapes();
		var ts;

		if(scs.length > 0){
			content += "<table class='layertable'>";
			for(var i=(scs.length-1); i>=0; i--){
				ts = scs[i];

				if(i===_UI.selectedshape) {
					if(ts.link)	content += "<tr class='lslayersel'";
					else content += "<tr class='layersel'";
				} else content += "<tr class='layer'";
				
				content += " onclick='_UI.selectedshape = " + i + "; redraw(\"updatelayers\");'>";

				if(ts.link) {
					content += "<td class='layerthumb'>"+_GP.linkedshapes[ts.link].shape.makeSVG()+"</td>";
					content += "<td class='layername'>" +ts.name;
					content += "<span class='layernote'>[linked to "+_GP.linkedshapes[ts.link].shape.name+"]</span>";
				} else {
					content += "<td class='layerthumb'>"+ts.makeSVG()+"</td>";
					content += "<td class='layername'>" + ts.name ;
				}

				content += "</td></tr>";
			}
			content += "</table>";
		} else {
			content += "<div style='margin-left:10px; font-style:oblique;'>No shapes exist yet.<br><br></div>";
		}

		if(_UI.clipboardshape){
			content += "<br>Clipboard: " + _UI.clipboardshape.s.name;
		}

		content +=  "<br><br>" + updateLayerActions();

		content += "</div>";

		return content;
	}

// end of file