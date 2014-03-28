/**
 * Created by Chris on 3/24/14.
 */

$(document).on('ready', function () {

	// Get mini profile
	ajax_fetch_html('module_mini_profile.php?', 'divMiniProfile', false);

	// Get tsn Special Report
	ajax_fetch_html('module_news.php?', 'divSpecialReport', false);

});

function ajax_fetch_html(url, elementid, refetch) {
	$.ajax({
		url: url + "sid=" + Math.random()
	}).done(function (data) {
		$('#' + elementid).html(data);
		if (refetch) {
			setTimeout(function () {
				ajax_fetch_html(url, elementid, refetch);
			}, 30000);
		}
	});
}
