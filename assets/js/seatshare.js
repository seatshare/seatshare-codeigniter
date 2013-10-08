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

// Sidebar Calendar
// @requires clndr.js
$(document).ready(function() {
	if (!$('#sidebar_calendar').length) {
		return;
	}

	$.get(SITE_ROOT+'/events/ajax_calendar_data_source', function(result) {
		$('#sidebar_calendar').clndr({
			daysOfTheWeek: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
			numberOfRows: 5,
			events: result,
			clickEvents: {
				click: function(target) {
					if (!_.isObject(target.events) || _.isEmpty(target.events[0])) {
						return false;
					}
					window.location = target.events[0].url;
				}
			},
			showAdjacentMonths: true,
			adjacentDaysChangeMonth: true
		});
	});
});