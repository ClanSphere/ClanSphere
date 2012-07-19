<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head2}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="links_create" action="{url:links_create}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:name} *</td>
    <td class="leftb"><input type="text" name="links_name" value="{data:links_name}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:cat} *</td>
    <td class="leftb">
      {cat:dropdown}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url} *</td>
    <td class="leftb">http://<input type="text" name="links_url" value="{data:links_url}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:multimedia} {lang:status} *</td>
    <td class="leftb">
      {status:dropdown}
    </td>
  </tr>
  {if:abcode}
  <tr>
    <td class="leftc">{icon:kate} {lang:info} *<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea name="links_info" cols="50" rows="15" id="links_info">{data:links_info}</textarea>
    </td>
  </tr>
  {stop:abcode}
  {if:rte_html}
  <tr>
    <td class="leftc" colspan="2">{icon:kate} {lang:info} *</td>
  </tr>
  <tr>
    <td class="leftb" style="padding: 0px" colspan="2">
      {rte:html}
    </td>
  </tr>
  {stop:rte_html}
  <tr>
    <td class="leftc">{icon:images} {lang:icon}</td>
    <td class="leftb">
      <input type="file" name="symbol" value="" /><br /><br />
      {picup:clip}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:extension}</td>
    <td class="leftb"><input type="checkbox" name="links_sponsor" value="1" {check:sponsor} /> {lang:sponsorbox}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>