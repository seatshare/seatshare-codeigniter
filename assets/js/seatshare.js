var SITE_ROOT = '';

// Navbar group switching
$(document).ready(function() {
	$('#group_switcher').change(function(e) {
		$.post(SITE_ROOT+'/groups/switch_groups', {
			group_id : $(this).val()
		});
		setTimeout(function() {
			location.reload();
		}, 300);
	});
});

// Confirm actions
$('a.confirm').click(function() {
	return window.confirm('Are you sure?');
});