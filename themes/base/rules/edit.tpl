<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:head_edit}</td>
 </tr>
 <tr>
  <td class="leftb">{head:body}</td>
 </tr>
</table>
<br />

{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">&sect; {ru:rules_order} {ru:rules_title}</td>
 </tr>
 <tr>
  <td class="leftb">{ru:rules_rule}</td>
 </tr>
</table>
<br />
{stop:preview}

<form method="post" id="rules_edit" action="{url:rules_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
  <td class="leftc">{icon:kedit} {lang:order} *</td>
  <td class="leftb">
    <input type="text" name="rules_order" value="{data:rules_order}" maxlength="3" size="6" />
    <input type="text" name="rules_title" value="{data:rules_title}" maxlength="40" size="40" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:folder_yellow} {lang:cat} *</td>
  <td class="leftb">{categories:dropdown}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate} {lang:rule} *<br /><br /></td>
  <td class="leftb">
  {abcode:features}
    <textarea class="rte_abcode" name="rules_rule" cols="50" rows="20" id="rules_rule" style="width:98%;">{data:rules_rule}</textarea></td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="hidden" name="id" value="{data:rules_id}" />
    <input type="submit" name="submit" value="{lang:edit}" />
    <input type="submit" name="preview" value="{lang:preview}" />
    </td>
  </tr>
</table>
</form>
