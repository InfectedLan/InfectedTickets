//Login form submitter
$(document).ready(function() {
	$('#loginForm').submit(function(e) {
		e.preventDefault();
		$.getJSON('../json/login.php' + '?' + $(this).serialize(), function(data){
			if (data.result) {
				location.reload();
			} else {
				error(data.message); 
			}
		});
	});
	
	$('#registerForm').submit( function(e) {
		e.preventDefault();
		$.getJSON('../json/register.php' + '?' + $(this).serialize(), function(data){
			if (data.result) {
				showLoginBoxFromRegister();
	        	info("Din bruker har blitt laget! Sjekk e-posten din for å aktivere, før du logger inn.");
			} else {
				error(data.message); 
			}
		});
	});
	
	$('.errorClose').click(function() {
		hideErrorBox();
	});
});

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