<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod} - {lang:options}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:errors_here}</td>
 </tr>
</table>
<br />

<form method="post" action="{url:comments_options}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:babelfish} {lang:show_avatars}</td>
  <td class="leftb"><input type="radio" name="show_avatar" value="1"{selected:show_avatar} />{lang:yes} <input type="radio" name="show_avatar" value="0"{selected:show_avatar_no} />{lang:no}</td>
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