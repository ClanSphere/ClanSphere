<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{loop:linkus}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{linkus:name}  {linkus:mass}</td>
  </tr>
  <tr>
    <td class="leftc">{linkus:banner}</td>
  </tr>
  <tr>
    <td class="leftc">
      <strong>{lang:html}</strong><br />
      <textarea name="html_{linkus:run}" cols="50" rows="2" class="noexpand" readonly="readonly" id="html_{linkus:run}">{linkus:html_code}</textarea>
      <br />
      <strong>{lang:abcode}</strong>
      <br />
      <textarea name="abcode_{linkus:run}" cols="50" rows="2" class="noexpand" readonly="readonly" id="abcode_{linkus:run}">{linkus:abcode}</textarea>
    </td>
  </tr>
</table>
<br />
{stop:linkus}