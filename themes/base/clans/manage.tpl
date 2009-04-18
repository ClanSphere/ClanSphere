<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
  		<td class="headb" colspan="4">{lang:mod_name} - {lang:manage}</td>
 	</tr>
 	<tr>
  		<td class="leftb">{icon:editpaste} <a href="{url:clans_create}">{lang:new_clan}</a></td>
  		<td class="leftb">{icon:contents} {lang:total}: {count:all}</td>
  		<td class="leftb">{icon:package_settings} <a href="{url:clans_options}">{lang:options}</a></td>
  		<td class="rightb">{pages:list}</td>
 	</tr>
	{if:done}
	<tr>
    	<td class="leftc" colspan="4"> {lang:wizard}: {link:wizard}</td>
  	</tr>
	{stop:done}   	
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
  		<td class="headb">{sort:name} {lang:name}</td>
  		<td class="headb">{sort:short} {lang:short}</td>
  		<td class="headb" colspan="2">{lang:options}</td>
 	</tr>
 	{loop:clans}
 	<tr>
  		<td class="leftc">{clans:name}</td>
  		<td class="leftc">{clans:short}</td>
  		<td class="leftc">{clans:edit}</td>
  		<td class="leftc">{clans:remove}</td>
 	</tr>
 	{stop:clans}
</table>