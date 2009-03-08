<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:mod} - {lang:head_view}</td>
	</tr>
	<tr>
		<td class="leftc">{lang:body_view}</td>
	</tr>
{if:topinfo}
	<tr>
		<td class="centerb">{head:status}</td>
	</tr>
{stop:topinfo}
</table>
<br />
{head:getmsg}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc" style="width:130px">{icon:cal} {lang:name}</td>
		<td class="leftb">{data:events_name}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:folder_yellow} {lang:category}</td>
		<td class="leftb">
			{data:categorie}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:1day} {lang:date}</td>
		<td class="leftb">
			{data:time}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:starthere} {lang:venue}</td>
		<td class="leftb">{data:events_venue}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kdmconfig} {lang:guests}</td>
		<td class="leftb">
			{lang:signed}: {data:signed}<br />
			{lang:min}: {data:events_guestsmin}<br />
			{lang:max}: {data:events_guestsmax}<br />
			{lang:needage}: {data:events_needage}
		</td>
	</tr>
	<tr>
		<td class="leftc">{icon:gohome} {lang:url}</td>
		<td class="leftb">{data:events_url}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:images} {lang:pictures}</td>
		<td class="leftb">{data:pictures}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kate} {lang:more}</td>
		<td class="leftb">
			{data:events_more}
		</td>
	</tr>
</table>