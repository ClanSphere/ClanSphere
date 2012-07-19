<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:options}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:errors_here}</td>
 </tr>
</table>
<br />
{lang:getmsg}
<form method="post" action="{url:static_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:configure} {lang:extended}</td>
  <td class="leftb">
    <input type="checkbox" name="php_eval" value="1" {checked:php_eval} /> {lang:php_eval}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:save}" />
      </td>
 </tr>
</table>
</form>