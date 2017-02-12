
<input type="checkbox" id="users_blank_edit_send_time_v_js" checked>Отображать время отправки сообщений?<button onclick="users_blank_edit_time_v_js()"></button><br />


function users_blank_edit_time_v_js()
{
	$.post(
	"engine/include/users/page/time_v.php",
	{ 
		message: document.getElementById('users_blank_edit_send_time_v_js').checked
	},
	function (data)
	{
		document.getElementById('users_blank_edit_complete').innerHTML = "Опция успешно обновлена.";
		document.getElementById('users_blank_edit_text_color').value = "";
	});
}
