<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="boardmods_edit" action="{url:boardmods_edit}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:personal} {lang:user} *</td>
    <td class="leftb">
      {bm:user}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:rank} *</td>
    <td class="leftb">
      {bm:cat_dropdown}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:access}</td><td class="leftb">
      <input type="checkbox" name="boardmods_modpanel" value="1" {bm:boardmods_modpanel} />{lang:modpanel}<br />
      <input type="checkbox" name="boardmods_edit" value="1" {bm:boardmods_edit} />{lang:edit}<br />
      <input type="checkbox" name="boardmods_del" value="1" {bm:boardmods_del} />{lang:remove}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{bm:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>
