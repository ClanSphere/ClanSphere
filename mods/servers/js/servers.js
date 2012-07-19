$(function() {
	$('[name="servers_class"]').bind({
		change: function(event) {
			if($('[name="servers_class"] option:selected').val() == 'ts3') {
				hideServerQuery();
			}
			else {
				var port = $('[name="servers_class"] option:selected').attr('class');
				$('[name="servers_query"]').parent().html('<input type="text" name="servers_query" value="{create:servers_query}" maxlength="200" size="10" />');
				$('[name="servers_query"]').val(port);
			}
		}
	});
	if($('[name="servers_class"] option:selected').val() == "ts3") {
		hideServerQuery();
	}
});

function hideServerQuery() {
	var html = 'Not used by TeamSpeak 3 <input type="hidden" name="servers_query" value="1" />';
	$('[name="servers_query"]').parent().html(html);
}