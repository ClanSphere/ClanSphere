<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="bottom">{preview:date} - {preview:user}</td>
  </tr>
  <tr>
    <td class="leftc">
      {preview:text}
    </td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" id="history_edit" action="{url:history_edit}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  {if:no_rte_html}
  <tr>
    <td class="leftc">{icon:kate} {lang:text} *<br />
      <br />
      {history:abcode_smileys}</td>
    <td class="leftb">
      {history:abcode_features}
      <textarea name="history_text" cols="50" rows="30" id="history_text">{history:text}</textarea>
    </td>
  </tr>
  {stop:no_rte_html}
    {if:rte_html}
  <tr>
    <td class="leftc" colspan="2">{icon:kate} {lang:text} *<br />
      <br />
      {history:rte_html}
    </td>
  </tr>
  {stop:rte_html}
  <tr>
    <td class="leftc">{lang:more}</td>
    <td class="leftb"><input type="checkbox" name="history_newtime" value="1" />{lang:new_date}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{history:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
      <input type="submit" name="preview" value="{lang:preview}" />
          </td>
  </tr>
</table>
</form>
