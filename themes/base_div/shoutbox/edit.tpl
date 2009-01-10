<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:edit}</div>
  <div class="leftc">{head:text}</div>
</div>
<br />

<form method="post" name="shoutboxedit" action="{url:form}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:personal} {lang:nick} *</td>
  <td class="leftb"><input type="text" name="name" value="{value:nick}"  /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate} {lang:message} *</td>
  <td class="leftb"><textarea name="message2" cols="17" rows="2" >{value:text}</textarea></td>
 </tr>
 <tr>
  <td class="leftc">{icon:configure} {lang:extended}</td>
  <td class="leftb"><input type="checkbox" name="refresh" value="1"  />{lang:refresh}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="hidden" name="id" value="{value:id}"  />
    <input type="submit" name="submit" value="{lang:edit}"  />
    <input type="reset" name="reset" value="{lang:reset}"  />
  </td>
 </tr>
</table>
</form>