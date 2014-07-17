$(document).ready(function() {
	var RanNum = Math.floor((Math.random() * 8) + 1);

	$('.bgControl').css("background-image", 'url(backgrounds/' + RanNum + '.jpg)')

	});
function logOut() {
	$.getJSON('http://<?php echo $_SERVER['HTTP_HOST']; ?>/api/json/logout.php', function(data){
		if(data.result == true)
		{
			location.reload();
		}		
  	});
}