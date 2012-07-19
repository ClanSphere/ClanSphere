<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:categories_create:where={where:mod}}">{lang:new_category}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="3">
      <form method="post" id="categories_manage" action="{url:categories_manage}">
        {lang:modul}
        <select name="where">
          {loop:mod}
          {mod:sel}
          {stop:mod}
        </select>
        <input type="submit" name="submit" value="{lang:show}" />
      </form>
    </td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:url} {lang:url}</td>
    <td class="headb" colspan="2" style="width:20%">{lang:options}</td>
  </tr>
  {loop:cat}
  <tr>
    <td class="leftc">{cat:subcat_layer} {cat:category}</td>
    <td class="leftc">{cat:url}</td>
    <td class="leftc"><a href="{url:categories_edit:id={cat:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:categories_remove:id={cat:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:cat}
</table>