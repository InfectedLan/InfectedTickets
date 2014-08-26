//View faders
function showRegisterBox() {
	$("#loginFrame").fadeOut(200, function() {
		$("#registerFrame").fadeIn(200);
	});
	$(".inner").animate({height:'550px'}, 200);

}
function showLoginBoxFromRegister() {
	$("#registerFrame").fadeOut(200, function() {
		$("#loginFrame").fadeIn(200);
		$(".inner").animate({height:'176px'}, 200);
	});

}
function showLoginBoxFromForgot() {
	$("#forgotFrame").fadeOut(200, function() {
		$("#loginFrame").fadeIn(200);
		$(".inner").animate({height:'176px'}, 200);
	});

}
function showForgotBox() {
	$("#loginFrame").fadeOut(200, function() {
		$("#forgotFrame").fadeIn(200);
	});
	$(".inner").animate({height:'230px'}, 200);

}