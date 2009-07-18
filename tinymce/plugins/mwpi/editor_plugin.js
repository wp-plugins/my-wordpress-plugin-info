(function() {
	tinymce.PluginManager.requireLangPack('mwpi');
	 
	tinymce.create('tinymce.plugins.mwpi', {
		
		init : function(ed, url) {

			ed.addCommand('mwpi', function() {
				ed.windowManager.open({
					file : url + '/dialog.php',
					width : 310,
					height : 130,
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

			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('mwpi', n.nodeName == 'IMG');
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
					longname  : 'My WP Plugin Info',
					author 	  : 'minimus',
					authorurl : 'http://blogovod.co.cc',
					infourl   : 'http://blogovod.co.cc',
					version   : "0.3.6"
			};
		}
	});

	tinymce.PluginManager.add('mwpi', tinymce.plugins.mwpi);
})();