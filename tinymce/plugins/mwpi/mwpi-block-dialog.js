function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertMWPICode() {
	
	var mwpiCode;
	var mwpiSlugObj = document.getElementById('mwpi_slug');
	var mwpiSlug = mwpiSlugObj.value;
	var mwpiModeObj = document.getElementById('mwpi_mode');
	var mwpiMode = mwpiModeObj.value;
	var contentObj = tinyMCE.getInstanceById('content');
	var mwpiBody = contentObj.selection.getContent();
	
	mwpiCode = ' [mwpi_block slug ="' + mwpiSlug + '" mode="' + mwpiMode + '"]' + mwpiBody + '[/mwpi_block]]';
	
	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, mwpiCode);
	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();
	return;
}

tinyMCEPopup.onInit.add(init);