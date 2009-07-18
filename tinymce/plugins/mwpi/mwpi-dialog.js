function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertMWPICode() {
	
	var mwpiCode;
	var mwpiSlugObj = document.getElementById('mwpi_slug');
	var mwpiSlug = mwpiSlugObj.value;
	var mwpiDataObj = document.getElementById('mwpi_data');
	var mwpiData = mwpiDataObj.value;
	var mwpiModeObj = document.getElementById('mwpi_mode');
	var mwpiMode = mwpiModeObj.value;
	var contentObj = tinyMCE.getInstanceById('content');
	var mwpiBody = contentObj.selection.getContent();
	
	if (mwpiMode == 'block') 
		mwpiCode = ' [mwpi slug ="' + mwpiSlug + '" mode="' + mwpiMode + '" body="' + mwpiBody + '"]';
	else
	  mwpiCode = ' [mwpi slug ="' + mwpiSlug + '" data="' + mwpiData + '" mode="' + mwpiMode + '"]';
	
	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, mwpiCode);
	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();
	return;
}
