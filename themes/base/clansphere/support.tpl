<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> ClanSphere - {lang:support} </td>
  </tr>
  <tr>
    <td class="leftb"> {lang:body_support} </td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
{loop:support}
  <tr>
    <td class="leftc"><a href="http://{support:url}" target="_blank">{support:name}</a></td>
    <td class="leftb">{support:text}<br /><br /></td>
  </tr>
{stop:support}
</table>