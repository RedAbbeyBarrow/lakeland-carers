$().ready(function() {
	
	var targetUrl;
	$(".delete-confirm").click(function(e) {
		$( "#confirm_delete" ).dialog( "open" );
		e.preventDefault();
    	targetUrl = $(this).attr("href");
	});
	
	$( "#confirm_delete" ).dialog({	
		title: 'Delete Testimonial?',
		resizable: false,
		draggable: false,
		autoOpen: false,
		height:180,
		width:350,
		modal: true,
		hide: 'fade',
		buttons: {
			"Delete": function() {
				window.location.href = targetUrl;
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
});