<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="links_edit" action="{url:links_edit}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb">{icon:kedit} {lang:name} *</td>
    <td class="leftc"><input type="text" name="links_name" value="{data:links_name}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:folder_yellow} {lang:cat} *</td>
    <td class="leftc">
      {cat:dropdown}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:gohome} {lang:url} *</td>
    <td class="leftc">http://<input type="text" name="links_url" value="{data:links_url}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:multimedia} {lang:status} *</td>
    <td class="leftc">
      {status:dropdown}
    </td>
  </tr>
  {if:abcode}
  <tr>
    <td class="leftb">{icon:kate} {lang:info} *<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftc">
      {abcode:features}
      <textarea name="links_info" cols="50" rows="15" id="links_info">{data:links_info}</textarea>
    </td>
  </tr>
  {stop:abcode}
  {if:rte_html}
  <tr>
    <td class="leftb" colspan="2">{icon:kate} {lang:info} *</td>
  </tr>
  <tr>
    <td class="leftc" style="padding: 0px" colspan="2">
      {rte:html}
    </td>
  </tr>
  {stop:rte_html}
  {if:img}
  <tr>
    <td class="leftb">{icon:images} {lang:icon}</td>
    <td class="leftc">{links:img}</td>
  </tr>
  {stop:img}
  <tr>
    <td class="leftb">{icon:images} {lang:icon}</td>
    <td class="leftc">
      <input type="file" name="symbol" value="" /><br /><br />
      {picup:clip}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:configure} {lang:extension}</td>
    <td class="leftc">
      <input type="checkbox" name="links_sponsor" value="1" {check:sponsor} /> {lang:sponsorbox}<br />
      {if:allow_del}<input type="checkbox" name="del_banner" value="1" /> {lang:delicon}{stop:allow_del}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="hidden" name="id" value="{links:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>