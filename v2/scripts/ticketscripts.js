$(document).ready(function() {
	var RanNum = Math.floor((Math.random() * 8) + 1);

	$('.bgControl').css("background-image", 'url(backgrounds/' + RanNum + '.jpg)')
	$('#fade').click(function(){closePrompt()});

	$('#userSearchInput').on('input', function(){
		updateSearchField();
	});
});
var updateKey = 0;
function updateSearchField()
{
	$.getJSON('../api/json/user/findUser.php?query=' + encodeURIComponent( $('#userSearchInput').val() ), function(data){
		resetSelectedUser();
		if(data.result == true)
		{
			$('#userSearchContent').html("");
			var userLength = data.users.length;
			if(userLength==0)
			{
				$('#userSearchContent').append("<i>Det er ingen brukere som fyller kravene! Har du stavet no feil?</i>");
			}
			else
			{
				for(var i = 0; i < userLength; i++)
				{
					$('#userSearchContent').append("<b>" + data.users[i].firstname + ' "' + data.users[i].username + '" ' + data.users[i].lastname + '</b> <input type="button" value="Velg" onclick="setSelectedUser(\'' + data.users[i].id + '\', \'' + data.users[i].firstname + ' &quot;' + data.users[i].nickname + '&quot; ' + data.users[i].lastname + '\')" /><br />');
				}
			}
		}
  	});
}
function revertTransfer(revertId) {
	$.getJSON('../api/json/ticket/revertTransfer.php?id=' + encodeURIComponent( revertId ), function(data){
		handleJson(data);
  	});
}
var selectedUserId = 0;
var acceptText = "hei";
var acceptFunction = 0;
function setSelectedUser(userId, displayname) {
	selectedUserId = userId;
	acceptFunction(userId);
	//$("#userSelectedData").html('<b>Du har valgt ' + displayname + '. <input type="button" value="' + acceptText + '" onclick="acceptFunction(' + userId + ')" /></b>');
}
function resetSelectedUser() {
	selectedUserId = 0;
	$("#userSelectedData").html('');
}
function searchUser(acceptTextIn, onAccept) {
	$("#fade").fadeIn(200);
	$("#prompt").fadeIn(200);
	acceptText = acceptTextIn;
	acceptFunction = onAccept;
}
function closePrompt()
{
	$("#fade").fadeOut(200);
	$("#prompt").fadeOut(200, function() {
		resetSelectedUser();
		$('#userSearchContent').html("");
		$('#userSearchInput').val("");
	});
}
function handleJson(data)
{
	if(data.result == true)
	{
		location.reload();
	}
	else
	{
		error(data.message);
	}
}