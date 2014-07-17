$(document).ready(function() {
	var RanNum = Math.floor((Math.random() * 8) + 1);

	$('.bgControl').css("background-image", 'url(backgrounds/' + RanNum + '.jpg)')
	$('#fade').click(function(){closePrompt()});

	$('#userSearchInput').on('input', function(){
		updateSearchField();
	});

	});
function logOut() {
	$.getJSON('http://<?php echo $_SERVER['HTTP_HOST']; ?>/api/json/logout.php', function(data){
		if(data.result == true)
		{
			location.reload();
		}		
  	});
}
var updateKey = 0;
function updateSearchField()
{
	updateKey = Math.random();
	$.getJSON('http://<?php echo $_SERVER['HTTP_HOST']; ?>/api/json/search.php?key=' + encodeURIComponent(updateKey), function(data){
		if(data.result == true)
		{
			location.reload();
		}		
  	});
}
function searchUser() {
	$("#fade").fadeIn(200);
	$("#prompt").fadeIn(200);
}
function closePrompt()
{
	$("#fade").fadeOut(200);
	$("#prompt").fadeOut(200);
}