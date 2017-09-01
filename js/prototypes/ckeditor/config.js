CKEDITOR.editorConfig = function( config ) {
	config.language	= 'en';
	
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
	];

	config.removeButtons = 'Underline,Superscript,PasteFromWord,Anchor,Subscript,RemoveFormat,Outdent,Indent,SpecialChar,Maximize,Scayt,Blockquote';
	config.extraPlugins = 'colorbutton,font,youtube,justify,smiley';
};
