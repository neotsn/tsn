$(document).ready(function () {
	/**
	 * Monitor New Topic button on view forum/topic/post pages
	 */
	//$('span.tsn8_icon_newtopic').on('click', function () {
	//	var element_id = 'tsn8_newtopic_modal';
	//
	//	var id = $(this).attr('data-id');
	//	var mode = $(this).attr('data-mode');
	//	var param = $(this).attr('data-param');
	//	var url = $(this).attr('data-url');
	//
	//	url = url + '?mode=' + mode + "&" + param + '=' + id;
	//
	//	make_ajax_request(url, 'GET');
	//
	//	var modal_box = $('#' + element_id);
	//	var dialog = modal_box.dialog({
	//		autoOpen: false,
	//		height: 500,
	//		width: 800,
	//		modal: true,
	//		buttons: {
	//
	//			"Cancel": function () {
	//				dialog.dialog("close");
	//			}
	//		},
	//		close: function () {
	//
	//		}
	//	});
	//	dialog.dialog("open");
	//});
})

function make_ajax_request(url, type, element_id) {

	var request = $.ajax({
		url: url,
		type: type,
		dataType: "html"
	});

	request.success(function (msg) {
		insert_modal_contents(element_id, msg);
	}).fail(function (jqXHR, textStatus) {
		alert("Request failed: " + textStatus);
	});
}

function insert_modal_contents(element_id, html) {
	$('#' + element_id).html(html);
}
