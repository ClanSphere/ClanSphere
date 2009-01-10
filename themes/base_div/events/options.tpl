<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:options}</div>
  <div class="leftb">{lang:errors_here}</div>
</div>
<br />
{lang:getmsg}
<form method="post" action="{url:events_options}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:configure} {lang:extended}</td>
  <td class="leftb">
    <input type="checkbox" name="show_wars" value="1" {checked:show_wars} />
    {lang:show_wars}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:save}" />
    <input type="reset" name="reset" value="{lang:reset}" />
  </td>
 </tr>
</table>
</form>