$().ready(function() {
	
	$("#pageForm").validate({
		rules: {
			title: {
				required: true,
				maxlength: 70,
			},
			meta_keywords: {
				required: true,
				maxlength: 250,
			},
			meta_description: {
				required: true,
				maxlength: 200,
			},
		},
		messages: {
			title: {
				required: 'Please enter the page title',
				maxlength: 'The title can have a maximum of 70 characters',
			},
			meta_keywords: {
				required: 'Please enter the meta keywords',
				maxlength: 'The meta keywords can have a maximum of 250 characters',
			},
			meta_description: {
				required: 'Please enter the meta description',
				maxlength: 'The meta description can have a maximum of 200 characters',
			},
		}
	});
	
});