/**
 * Created by Chris on 3/24/14.
 */

$(document).on('ready', function () {

	var login_status = $("#login_status").val();

	if (login_status == 1) {
		// Get mini profile
		ajax_fetch_html('module_mini_profile.php?', 'divMiniProfile', false);
	}

	// Get tsn Special Report
	ajax_fetch_html('module_news.php?', 'divSpecialReport', false);

	ajax_fetch_html('module_mini_index.php?', 'divMiniForumIndex', false);

});

function ajax_fetch_html(url, elementid, refresh) {
	$.ajax({
		url: url + "sid=" + Math.random()
	}).done(function (data) {
		$('#' + elementid).html(data);
		if (refresh) {
			setTimeout(function () {
				ajax_fetch_html(url, elementid, refresh);
			}, 30000);
		}
	});
}
