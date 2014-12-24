$(document).ready(function () {
	// Implement jQuery UI Buttons & Button Sets
	$(function () {
		$('button[data-mod*="tsn8_button"]').button({
			text: false
		});
		$('input[data-mod*="tsn8_button"]').button({
			text: false
		});
		$(".buttonset").buttonset();

	});
});
//
//function make_ajax_request(url, type, element_id) {
//
//	var request = $.ajax({
//		url: url,
//		type: type,
//		dataType: "html"
//	});
//
//	request.success(function (msg) {
//		insert_modal_contents(element_id, msg);
//	}).fail(function (jqXHR, textStatus) {
//		alert("Request failed: " + textStatus);
//	});
//}
//
//function insert_modal_contents(element_id, html) {
//	$('#' + element_id).html(html);
//}
