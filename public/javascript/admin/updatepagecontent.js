$().ready(function() {

	CKEDITOR.replace( 'content',
	{
		skin : 'kama',
		width: '450px',
		toolbar :
					[
						{ name: 'basicstyles', items : [ 'Bold','-','Italic','-','Underline' ] },
						{ name: 'styles', items : [ 'Styles' ] },
						{ name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
						{ name: 'editing', items : [ 'SpellChecker' ] },
						{ name: 'links', items : [ 'Link','Unlink' ] },
						{ name: 'tools', items : [ 'Maximize' ] }
					]
		
	});
	
	CKEDITOR.stylesSet.add( 'my_styles',
	[
		// Inline styles
		{ name : 'Sub Heading', element : 'span', styles : { 'color' : '#094CA7', 'font-weight' : 'bold' } }
	]);
});