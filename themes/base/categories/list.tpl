<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">
      <form method="post" id="categories_list" action="{url:categories_list}">
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

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:url} {lang:url}</td>
  </tr>
  {loop:cat}
  <tr>
    <td class="leftc">{cat:category}</td>
    <td class="leftc">{cat:url}</td>
  </tr>
  {stop:cat}
</table>