var SITE_ROOT = '';

// Navbar group switching
$(document).ready(function() {
	$('#group_switcher').change(function(e) {
		window.location = SITE_ROOT+'/groups/switch_groups/' + $(this).val();
	});
});

// Confirm actions
$('a.confirm').click(function() {
	return window.confirm('Are you sure?');
});