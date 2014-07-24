//Login form submitter
$(document).ready(function() {
	$('#loginForm').submit( function(e) {
		e.preventDefault();
	    $.post( 'json/login.php', $('#loginForm').serialize(), function(data) { // TODO: Link this to api in a more elegant way.
	    	console.log('Got data!');
	        if(data.result==true)
	        {
	        	location.reload();
	        }
	        else
	        {
	         	error(data.message);
	        }
	       },
	       'json'
	    );
	});
	$('#registerForm').submit( function(e) {
		e.preventDefault();
	    $.post( 'json/register.php', $('#registerForm').serialize(), function(data) { // TODO: Link this to api in a more elegant way.
	    	console.log('Got data!');
	        if(data.result==true)
	        {
	        	//$('#registerForm').reset();
	        	showLoginBoxFromRegister();
	        	info("Din bruker har blitt laget! Sjekk e-posten din for å aktivere, før du logger inn.");

	        }
	        else
	        {
	         	error(data.message);
	        }
	       },
	       'json'
	    );
	});
	$('.errorClose').click(function() {hideErrorBox();});
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