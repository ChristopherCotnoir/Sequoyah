//requires jQuery && opentype to be loaded

//Export a syllabary to a font to OTF
//File extension automatically appended to FontName
void ExportSyllabary(ProjectId, SyllabaryId, FontName)
{
	var file = FontName + ".otf";

	//fetch all glyphs from server
	$.ajax('')
}