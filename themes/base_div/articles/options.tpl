<div class="container" style="width:{page:width}">
  <div class="headb">{head:mod} - {head:action}</div>
  <div class="leftb">{head:topline}</div>
</div>
<br />

<form method="post" action="{url:articles_options}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_navlist}</td>
  <td class="leftb"><input type="text" name="max_navlist" value="{op:max_navlist}" maxlength="2" size="2"  /></td>
 </tr> 
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:edit}" />
    <input type="reset" name="reset" value="{lang:reset}" />
  </td>
 </tr>
</table>
</form>