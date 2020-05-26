$(document).ready(function(){	
	$('body').on('click', '.iheg-linkto .dashicons-admin-generic', function(e) {		
		$(this).closest('.ihe-block-control').find('.link-attributes').toggleClass('visible');
	});	
});