$().ready(function() {
	
	CKEDITOR.replace( 'article_content',
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
	
	$("#newsForm").validate({
		rules: {
			title: {
				required: true,
				maxlength: 100,
			},
			image: {
				accept: 'jpg,png',
			},
		},
		messages: {
			title: {
				required: 'Please enter the article title',
				maxlength: 'The title can have a maximum of 100 characters',
			},
			image: {
				accept: "jpg/png is the accepted format",
			},
		}
	});
	
});