<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:head_center}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_center}</td>
    <td class="centerb">{lang:list}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:start} {lang:start}</td>
    <td class="headb">{sort:status} {lang:status}</td>
    <td class="headb" colspan="2"> {lang:options} </td>
  </tr>
  {loop:lanpartys}
  <tr>
    <td class="leftc">{lanpartys:name}</td>
    <td class="leftc">{lanpartys:start}</td>
    <td class="leftc">{lanpartys:status}</td>
    <td class="leftc">{lanpartys:edit}</td>
	<td class="leftc">{lanpartys:remove}</td>
  </tr>
  {stop:lanpartys}
</table>
