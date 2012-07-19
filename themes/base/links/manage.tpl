<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">
      <form method="post" id="categorie_select" action="{url:links_manage}">
        <fieldset style="border: 0; padding: 0">
          {icon:folder_yellow} {lang:cat}
          {head:cat_dropdown}
          <input type="submit" name="submit" value="{lang:show}" />
        </fieldset>
      </form>
    </td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:cat}</td>
    <td class="headb">{lang:url}</td>
    <td class="headb">{lang:status}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:links}
  <tr>
    <td class="leftc"><a href="{url:links_view:id={links:id}}">{links:name}</a></td>
    <td class="leftc">{links:cat}</td>
    <td class="leftc"><a href="http://{links:url}" target="_blank">{links:url_short}</a></td>
    <td class="leftc"><span style="color:{links:color}">{links:on_off}</span></td>
    <td class="leftc"><a href="{url:links_edit:id={links:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:links_remove:id={links:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:links}
</table>