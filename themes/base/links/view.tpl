<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb" colspan="2">{lang:mod} - {lang:details}</td>
	</tr>
	<tr>
		<td class="leftb" style="width:140px">{icon:kedit} {lang:name}</td>
		<td class="leftc">{links:name}</td>
	</tr>
	<tr>
		<td class="leftb">{icon:gohome} {lang:url}</td>
		<td class="leftc"><a href="http://{links:url}" target="cs1">{links:url}</a></td>
	</tr>
	<tr>
		<td class="leftb">{icon:multimedia} {lang:status}</td>
		<td class="leftc"><span style="color:{links:color}">{links:on_off}</span></td>
	</tr>
	{if:img}
	<tr>
		<td class="leftb">{icon:thumbnail} {lang:icon}</td>
		<td class="leftc">{links:img}</td>
	</tr>
	{stop:img}
	<tr>
		<td class="headb" colspan="2">{lang:info}</td>
	</tr>
	<tr>
		<td class="leftb" colspan="2">{links:info}</td>
	</tr>
</table>