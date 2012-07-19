<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{tpl:preview}

<form method="post" id="gbook_edit" action="{url:gbook_edit}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  {tpl:extension}
  <tr>
    <td class="leftc">{icon:kate} {lang:text} *<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea class="rte_abcode" name="gbook_text" cols="50" rows="15" id="gbook_text">{gbook:gbook_text}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="gbook_newtime" value="1" {check:newtime} /> {lang:new_date}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{gbook:id}" />
      <input type="hidden" name="from" value="{gbook:from}" />
      <input type="submit" name="submit" value="{lang:edit}" />
      <input type="submit" name="preview" value="{lang:preview}" />
          </td>
  </tr>
</table>
</form>