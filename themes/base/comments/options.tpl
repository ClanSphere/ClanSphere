<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:options}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:errors_here}</td>
 </tr>
</table>
<br />

<form method="post" action="{url:comments_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:babelfish} {lang:show_avatars}</td>
  <td class="leftb">
    <input type="radio" name="show_avatar" value="1" {checked:show_avatar} />{lang:yes}
    <input type="radio" name="show_avatar" value="0" {checked:show_avatar_no} />{lang:no}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:personal} {lang:allow_unreg}</td>
  <td class="leftb">
    <input type="radio" name="allow_unreg" value="1" {checked:allow_unreg} />{lang:yes}
    <input type="radio" name="allow_unreg" value="0" {checked:allow_unreg_no} />{lang:no}
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