<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:edit}</td>
 </tr>
 <tr>
  <td class="leftc">{head:text}</td>
 </tr>
</table>
<br />

<form method="post" id="shoutbox_edit" action="{url:shoutbox_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:personal} {lang:nick} *</td>
  <td class="leftb"><input type="text" name="name" value="{value:nick}" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate} {lang:message} *</td>
  <td class="leftb"><textarea class="rte_abcode" name="message2" cols="17" rows="2">{value:text}</textarea></td>
 </tr>
 <tr>
  <td class="leftc">{icon:configure} {lang:extended}</td>
  <td class="leftb"><input type="checkbox" name="refresh" value="1" />{lang:refresh}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="hidden" name="id" value="{value:id}" />
    <input type="submit" name="submit" value="{lang:edit}" />
      </td>
 </tr>
</table>
</form>