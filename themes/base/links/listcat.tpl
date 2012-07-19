<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {categories:name}</td>
  </tr>
  <tr>
    <td class="leftb">{categories:text}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:url}</td>
    <td class="headb">{lang:status}</td>
  </tr>
  {loop:links}
  <tr>
    <td class="leftc"><a href="{url:links_view:id={links:id}}">{links:name}</a></td>
    <td class="leftc"><a href="http://{links:url}" target="_blank">{links:url_short}</a></td>
    <td class="leftc"><span style="color:{links:color}">{links:on_off}</span></td>
  </tr>
  {stop:links}
</table>