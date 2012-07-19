<table style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:kedit} {lang:text} *</td>
    <td class="leftc">
      <form method="post" id="search_functions" action="{url:search_list}">
        <input type="text" name="text" value="" maxlength="200" size="50" />
        <input type="hidden" name="where" value="{search:mod}" />
        <input type="submit" name="submit" value="{lang:search}" />
              </form>
    </td>
  </tr>
</table>