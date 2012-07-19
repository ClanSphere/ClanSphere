<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod1}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{loop:links}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{links:name}</td>
  </tr>
  <tr>
    <td class="leftc">{links:url_img}</td>
  </tr>
  <tr>
    <td class="leftc">{links:info}</td>
  </tr>
</table>
<br />
{stop:links}