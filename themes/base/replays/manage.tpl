<form method="post" id="replays_manage" action="{url:replays_manage}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>  
  <td class="leftb">{icon:contents} {lang:total}: {head:replays_count}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">{lang:category}
    {head:dropdown}
    <input type="submit" value="{lang:show}" name="submit" /></td>
 </tr>
</table>
<br />
{head:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:game}</td>
  <td class="headb">{sort:date} {lang:date}</td>
  <td class="headb">{sort:team1} {lang:team1}</td>
  <td class="headb">{sort:team2} {lang:team2}</td>
  <td class="headb" colspan="2">{lang:options}</td>
 </tr>
{loop:replays}
 <tr>
  <td class="leftc">{replays:game_icon}</td>
  <td class="leftc"><a href="{replays:date_url}">{replays:date}</a></td>
  <td class="leftc">{replays:team1}</td>
  <td class="leftc">{replays:team2}</td>
  <td class="leftc"><a href="{replays:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{replays:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
{stop:replays}
</table>
</form>