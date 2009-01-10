<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_center}</div>
    <div class="leftb fl">{lang:body_center}</div>
    <div class="centerb fr">{lang:list}</div>
</div>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
