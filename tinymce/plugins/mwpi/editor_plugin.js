(function() {
	tinymce.PluginManager.requireLangPack('mwpi');
	 
	tinymce.create('tinymce.plugins.mwpi', {
		
		init : function(ed, url) {

			ed.addCommand('mwpi', function() {
				ed.windowManager.open({
					file : url + '/dialog.php',
					width : 310 + parseInt(ed.getLang('mwpi.delta_width', 0)),
					height : 115 + parseInt(ed.getLang('mwpi.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url 
				});
			});
			
			ed.addCommand('mwpi_block', function() {
				ed.windowManager.open({
					file : url + '/block-dialog.php',
					width : 310 + parseInt(ed.getLang('mwpi.delta_width', 0)),
					height : 90 + parseInt(ed.getLang('mwpi.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url 
				});
			});

			ed.addButton('mwpi', {
				title : 'mwpi.insert_mwpi',
				cmd : 'mwpi',
				image : url + '/img/mwpi.png'
			});
			
			ed.addButton('mwpi_block', {
				title : 'mwpi.insert_mwpi_block',
				cmd : 'mwpi_block',
				image : url + '/img/mwpi-block.png'
			});

			ed.onNodeChange.add(function(ed, cm, n, co) {
				cm.setDisabled('mwpi', !co);
				cm.setDisabled('mwpi_block', co);
			});
		},
		
		getInfo : function() {
			return {
					longname  : 'My WP Plugin Info',
					author 	  : 'minimus',
					authorurl : 'http://blogovod.co.cc',
					infourl   : 'http://blogovod.co.cc',
					version   : "1.0.11"
			};
		}
	});

	tinymce.PluginManager.add('mwpi', tinymce.plugins.mwpi);
})();