/**
 * Created by Chris on 3/24/14.
 */

$(document).on('ready', function () {
	$.ajax({
		url: "module_mini_profile.php?sid=" + Math.random()
	}).done(function (data) {
		$('#divMiniProfile').html(data);
	});
});
