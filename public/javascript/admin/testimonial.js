$().ready(function() {
	
	$("#testimonialForm").validate({
		rules: {
			testimonial_author: {
				required: true,
			},
			testimonial: {
				required: true,
				sentence: true,
			},
		},
		messages: {
			testimonial_author: {
				required: 'Please enter the authors name',
			},
			testimonial: {
				required: 'Please enter a testimonial',
				sentence: 'Letters, numbers and basic punctuation only please',
			},
		}
	});
	
});