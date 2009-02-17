{if:done}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">  
  <tr>
    <td class="leftc" colspan="3"> {lang:wizard}: {link:wizard}</td>
  </tr>
</table>
<br />
{stop:done}

<form method="post" name="users_setup" action="{url:users_setup}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
  		<td class="leftc">{icon:locale} {lang:lang}</td>
  		<td class="leftb">
			<select name="users_lang" >
				{setup:languages}        
			</select>
  		</td>
 	</tr>
 	<tr>
  		<td class="leftc">{icon:ktimer} {lang:timezone}</td>
  		<td class="leftb">
			<select name="users_timezone" >
				{setup:timezone} 
			</select>
  		</td>
 	</tr>
 	<tr>
  		<td class="leftc">{icon:kweather} {lang:dstime}</td>
  		<td class="leftb">
   			<select name="users_dstime" >
    			{setup:option_automatic}
    			{setup:option_on}
    			{setup:option_off}
   			</select>
  		</td>
 	</tr>
 	<tr>
  		<td class="leftc">{icon:view_text} {lang:datasheet_per_page}</td>
  		<td class="leftb" colspan="2">{setup:users_limit}</td>
 	</tr>
 	<tr>
  		<td class="leftc">{icon:view_text} {lang:readtime}</td>
  		<td class="leftb" colspan="2">{setup:readtime} {lang:days}</td>
 	</tr>
 	<tr>
  		<td class="leftc">{icon:view_text} {lang:homelimit}</td>
  		<td class="leftb" colspan="2">{setup:homelimit}</td>
 	</tr>
 	<tr>
  		<td class="leftc">{icon:view_choose} {lang:view}</td>
  		<td class="leftb" colspan="2">{setup:view_type}</td>
 	</tr>
 	<tr>
  		<td class="leftc">{icon:msn_invisible} {lang:invisible}</td>
  		<td class="leftb" colspan="2">{setup:users_invisible}</td>
 	</tr>
 	{if:ajax_allowed}
 	<tr>
  		<td class="leftc">{icon:agt_reload} {lang:ajax}</td>
  		<td class="leftb" colspan="2">{setup:users_ajax}</td>
 	</tr>
 	{stop:ajax_allowed}
 	<tr>
  		<td class="leftc">{icon:ksysguard} {lang:options}</td>
  		<td class="leftb">
   			<input type="submit" name="submit" value="{lang:save}" />
   			<input type="reset" name="reset" value="{lang:reset}" />
  		</td>
 	</tr>
</table>
</form>