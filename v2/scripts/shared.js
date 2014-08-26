//Error box functions
function error(errorMsg) {
	$('#errorMsg').text(errorMsg);
	showErrorBox();
}
function info(errorMsg) {
	$('#errorMsg').text(errorMsg);
	showInfoBox();
}
function hideErrorBox() {
	$("#errorbox").fadeOut(200);
}
function showErrorBox() {
	$("#errorbox").fadeIn(200);
	$('#errorbox').attr("class", "error");
}
function showInfoBox() {
	$("#errorbox").fadeIn(200);
	$('#errorbox').attr("class", "info");
}
$(document).ready(function() {	
	$('.errorClose').click(function() {
		hideErrorBox();
	});
});